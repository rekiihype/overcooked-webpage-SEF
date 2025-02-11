<?php
// update_profile.php

// Database connection
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_db_name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$fullName = $_POST['full-name'];
$gender = $_POST['gender'];
$language = $_POST['language'];
$country = $_POST['country'];
$email = $_POST['email'];
$password = $_POST['password'];

// Handle file upload
if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] == 0) {
    $profilePicture = $_FILES['profile-picture']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($profilePicture);
    move_uploaded_file($_FILES['profile-picture']['tmp_name'], $targetFile);
} else {
    $profilePicture = null;
}

// Update database
$sql = "UPDATE users SET full_name=?, gender=?, language=?, country=?, email=?, password=?, profile_picture=? WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi", $fullName, $gender, $language, $country, $email, $password, $profilePicture, $userId);

if ($stmt->execute()) {
    echo json_encode(["message" => "Profile updated successfully!"]);
} else {
    echo json_encode(["error" => "Error updating profile: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>