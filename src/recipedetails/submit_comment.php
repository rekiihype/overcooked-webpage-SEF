<?php
include '../database/db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeId = intval($_POST["recipeId"]);
    $userId = intval($_POST["userId"]); 
    $commentContent = trim($_POST["commentContent"]);

    if (!empty($commentContent) && $recipeId > 0 && $userId > 0) {
        $sql = "INSERT INTO comments (commentContent, commentDatetime, userId, recipeId) VALUES (?, NOW(), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $commentContent, $userId, $recipeId);

        if ($stmt->execute()) {
            header("Location: recipe_details.php?recipeId=" . $recipeId . "&success=1");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid comment.";
    }
} else {
    echo "Invalid request.";
}
?>