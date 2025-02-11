<?php
    include ("../database/db_connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Birria Beef Tacos - The OverCooked</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="recipe_details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Newsreader:opsz@6..72&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap');
    </style>
</head>

<body>
    <header>
        <img class="logo" src="../assets/brand_logo.svg" alt="logo">
        <nav>
            <ul class="navigation_link">
                <li><a href="#">Trending Recipes</a></li>
                <li><a href="#">Browse by Category</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </nav>
        <form action="">
            <input type="search" placeholder="Search for recipes!">
            <i class="fa fa-search"></i>
        </form>
    </header>

    <main class="recipe-details">
        <?php
            if (isset($_GET['recipeId'])) {
                $recipeId = intval($_GET['recipeId']); // Ensure it's an integer
            } else {
                die("Recipe ID is missing!");
            }

            $sql = "SELECT recipeName, picture, chefId, tag, note, details, ingredients, instruction FROM posted_recipe WHERE recipeId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $recipeId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result-> fetch_assoc()) {
                echo "<section class='recipe-header'>";
                echo "<h1>{$row['recipeName']}</h1>";

                echo "<div class='recipe-tags'>";
                echo "<span>{$row['tag']}</span>";
                echo "</div>";

                echo "<img src='../{$row['picture']}' alt='{$row['recipeName']}'>";
                echo "</section>";

                echo "<section class='save-recipe'>";
                echo "<button>Save Recipe</button>";
                echo "</section>";

                echo "<section class='recipe-chef'>";
                echo "<img src='{$row['picture']}' alt='{$row['chefId']}'>";
                echo "<p>{$row['chefId']}</p>";
                echo "</section>";

                echo "<section class='recipe-notes'>";
                echo "<h2>Chef's Notes</h2>";
                echo "<p>{$row['note']}</p>";
                echo "</section>";

                echo "<section class='recipe-details-section'>";
                echo "<h2>Details</h2>";
                echo "<ul>";
                echo "<p>{$row['details']}</p>";
                echo "</ul>";
                echo "</section>";

                echo "<section class='recipe-ingredients'>";
                echo "<h2>Ingredients</h2>";
                echo "<p>{$row['ingredients']}</p>";
                echo "</section>";

                echo "<section class='recipe-directions'>";
                echo "<h2><b>Directions</b></h2>";
                echo "<p>{$row['instruction']}</p>";
                echo "</section>";

                $stmt->close();
            }
        ?>

        <section class="recipe-comments">
            <h2>Comments</h2>

                <?php
                    if (isset($_GET['recipeId'])) {
                    $recipeId = intval($_GET['recipeId']); // Ensure it's an integer
                } else {
                    die("Recipe ID is missing!");
                }

                $sql = "SELECT userId, commentContent, commentDatetime FROM comment WHERE recipeId = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $recipeId);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<img src='default-user.png' alt='User'>";
                    echo "<p class='user-name'>User</p>";
                    echo "<p>{$row['commentDatetime']}</p>";
                    echo "<p class='user-comment'>{$row['commentContent']}</p>";
                    echo "</div>";
                }
            ?>
        </section>

        <section class="comment-form">
            <form action="submit_comment.php" method="POST">
                <input type="hidden" name="recipeId" value="<?php echo htmlspecialchars($_GET['recipeId']); ?>">
                <input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>"> 
                <textarea name="commentContent" placeholder="Write your comment here..." required></textarea>
                <button type="submit">Post</button>
            </form>
        </section>
    </main>
</body>

</html>