<?php

// submit_recipe.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "the_overcooked_db";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recipeName = $_POST["recipeName"];
    $chefId = $_POST["chefId"];
    $category = $_POST["category"];
    $tag = $_POST["tag"];
    $note = $_POST["note"];
    $details = $_POST["details"];
    $ingredients = $_POST["ingredients"];
    $instruction = $_POST["instruction"];

    // Ensure the upload directory exists
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle multiple file uploads
    $picturePaths = [];
    if (!empty($_FILES["pictures"]["name"][0])) {
        foreach ($_FILES["pictures"]["name"] as $key => $fileName) {
            $targetFilePath = $uploadDir . basename($fileName);

            if (move_uploaded_file($_FILES["pictures"]["tmp_name"][$key], $targetFilePath)) {
                $picturePaths[] = $targetFilePath; // Store the file path
            }
        }
    }

    // Convert array of file paths into a single string (comma-separated)
    $picturePathsString = implode(",", $picturePaths);

    // Insert recipe data into database with picture paths
    $stmt = $conn->prepare("INSERT INTO pending_recipe (recipeName, chefId, category, tag, note, details, ingredients, instruction, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $recipeName, $chefId, $category, $tag, $note, $details, $ingredients, $instruction, $picturePathsString);

    if ($stmt->execute()) {
        echo "Recipe submitted for review successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
