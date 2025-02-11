<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The OverCooked</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="recipe_list_dessert.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Newsreader:opsz@6..72&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap');
        </style>
    </head>
    <body>
        <header>
            <img class="logo" src="../../assets/brand_logo.svg" alt="logo">
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

        <section class="recipes-view">
            <h1 class="recipes-title">Dessert</h1>
            <div class="recipes-grid">
                <?php 
                    include 'fetch_dessert_recipe.php'; 
                ?>
            </div>
        </section>

        <script>
            const searchInput = document.getElementById("recipe-search");
            const recipeCards = document.querySelectorAll(".recipe-card");
        
            searchInput.addEventListener("keyup", function(event) {
                const searchTerm = event.target.value.toLowerCase();
        
                recipeCards.forEach(card => {
                    const recipeName = card.querySelector(".recipe-name").textContent.toLowerCase();
        
                    if (recipeName.includes(searchTerm)) {
                        card.style.display = "block"; // Or "grid", "flex", depending on your layout
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        </script>
    </body>
</html>