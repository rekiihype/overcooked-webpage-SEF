<?php
$conn = new mysqli('localhost', 'root', '', 'the_overcooked_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Database connection successful!<br>";

$sql = "SELECT * FROM pending_recipe WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Pending recipes found:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Recipe ID: " . $row['pendingId'] . " - Name: " . $row['recipeName'] . "<br>";
    }
} else {
    echo "No pending recipes found in the database.";
}

$conn->close();
?>
