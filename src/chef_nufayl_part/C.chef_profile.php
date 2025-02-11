<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Chef Profile</h1>
    </header>

    <div class="container">
        <?php
        $conn = new mysqli("localhost", "root", "", "the_overcooked_db");

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Get chef ID from the query parameter
        $chefId = isset($_GET['chefId']) ? intval($_GET['chefId']) : 0;

        // Fetch chef information
        $chefSql = "SELECT * FROM users WHERE userId = ?";
        $chefStmt = $conn->prepare($chefSql);
        $chefStmt->bind_param("i", $chefId);
        $chefStmt->execute();
        $chefResult = $chefStmt->get_result();

        if ($chefResult->num_rows > 0) {
            $chef = $chefResult->fetch_assoc();
            echo "<h2>Chef Name: " . htmlspecialchars($chef['name']) . "</h2>";
            echo "<p><strong>Username:</strong> " . htmlspecialchars($chef['username']) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($chef['email']) . "</p>";

            echo "<a href='C.chef_pending_recipe.php?chefId=" . htmlspecialchars($chefId) . "' class='button'>View Submitted Recipes</a>";
        } else {
            echo "<p>Chef not found.</p>";
            exit;
        }

        

        $chefStmt->close();

        echo "<h2>Published Recipes</h2>";

        // Fetch recipes by the chef
        $recipeSql = "SELECT * FROM posted_recipe WHERE chefId = ? ORDER BY datetime_posted DESC";
        $recipeStmt = $conn->prepare($recipeSql);
        $recipeStmt->bind_param("i", $chefId);
        $recipeStmt->execute();
        $recipeResult = $recipeStmt->get_result();

        echo "<div class='recipe-grid'>";
        if ($recipeResult->num_rows > 0) {
            while ($row = $recipeResult->fetch_assoc()) {
                echo "<div class='recipe-card'>
                        <img src='" . htmlspecialchars($row['picture']) . "' alt='" . htmlspecialchars($row['recipeName']) . "' class='recipe-image'>
                        <h3>" . htmlspecialchars($row['recipeName']) . "</h3>
                        <p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>
                        <p><strong>Tag:</strong> " . htmlspecialchars($row['tag']) . "</p>
                        <p><strong>Date Posted:</strong> " . htmlspecialchars($row['datetime_posted']) . "</p>
                        <a href='C.chef_recipe_details.php?id=" . htmlspecialchars($row['recipeId']) . "' class='details-button'>View Details</a>
                    </div>";
            }
        } else {
            echo "<p>No recipes published by this chef.</p>";
        }
        echo "</div>";

        $recipeStmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
