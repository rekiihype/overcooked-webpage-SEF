<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "the_overcooked_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recipeName = $_POST["recipeName"];
    $chefId = $_POST["chefId"];
    $tag = $_POST["tag"];
    $note = $_POST["note"];
    $details = $_POST["details"];
    $ingredients = $_POST["ingredients"];
    $instruction = $_POST["instruction"];

    $picture = "";
    if (isset($_FILES["picture"])) {
        $targetDir = "uploads/";
        $picture = $targetDir . basename($_FILES["picture"]["name"]);
        move_uploaded_file($_FILES["picture"]["tmp_name"], $picture);
    }

    $stmt = $conn->prepare("INSERT INTO recipe (recipeName, chefId, tag, note, details, ingredients, instruction, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssss", $recipeName, $chefId, $tag, $note, $details, $ingredients, $instruction, $picture);

    if ($stmt->execute()) {
        echo "Recipe submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
