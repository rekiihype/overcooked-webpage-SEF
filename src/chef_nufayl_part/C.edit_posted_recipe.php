<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); // Ensure the response is JSON

// Enable error reporting to catch issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "the_overcooked_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    $chefId = $_SESSION['chef_id'] ?? null;
    if (!$chefId) {
        echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
        exit();
    }

    $originalId = $_POST["recipeId"] ?? null;
    if (!$originalId) {
        echo json_encode(["status" => "error", "message" => "Recipe ID is missing."]);
        exit();
    }

    $recipeName = $_POST["recipeName"] ?? '';
    $category = $_POST["category"] ?? '';
    $tag = $_POST["tag"] ?? '';
    $note = $_POST["note"] ?? '';
    $details = $_POST["details"] ?? '';
    $ingredients = $_POST["ingredients"] ?? '';
    $instruction = $_POST["instruction"] ?? '';

    // Debugging - Log received data
    error_log("Received Data: " . json_encode($_POST));

    // Check if an edit is already pending
    $checkPending = $conn->prepare("SELECT * FROM pending_recipe WHERE originalId = ? AND status = 'pending'");
    $checkPending->bind_param("i", $originalId);
    $checkPending->execute();
    $result = $checkPending->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "This recipe already has a pending edit."]);
        exit();
    }
    $checkPending->close();

    // Insert into pending_recipe table
    $sqlInsert = "INSERT INTO pending_recipe 
        (recipeName, category, tag, note, details, ingredients, instruction, chefId, submitted_at, status, originalId) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pending', ?)";
    
    $stmt = $conn->prepare($sqlInsert);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("sssssssii", $recipeName, $category, $tag, $note, $details, $ingredients, $instruction, $chefId, $originalId);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Your recipe edit has been submitted for approval."]);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to submit recipe edit: " . $stmt->error]);
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
