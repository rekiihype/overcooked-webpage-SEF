<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Recipe Details</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showNotification(message) {
            const overlay = document.getElementById('overlay');
            const notificationBox = document.getElementById('notificationBox');
            document.getElementById('notificationMessage').innerText = message;
            overlay.style.display = 'block';
            notificationBox.style.display = 'block';
        }

        function closeNotification() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('notificationBox').style.display = 'none';
            window.location.href = 'C.chef_profile.php'; // Redirect back to chef profile
        }

        async function handleDelete(recipeId) {
            if (!confirm("Are you sure you want to delete this recipe?")) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('recipeId', recipeId);

                const response = await fetch('C.delete_posted_recipe.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                if (result.status === "success") {
                    showNotification(result.message);
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        }

        async function handleEdit(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById('editRecipeForm'));

    try {
        const response = await fetch('C.edit_posted_recipe.php', {
            method: 'POST',
            body: formData
        });

        // Check if the response is actually JSON
        const textResponse = await response.text();
        try {
            var result = JSON.parse(textResponse);
        } catch (error) {
            console.error("Invalid JSON Response:", textResponse);
            alert("Unexpected error: Server returned invalid response.");
            return;
        }

        if (result.status === "success") {
            showNotification(result.message);
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

    </script>
</head>
<body>
    <header>
        <h1>The OverCooked - Chef Recipe Details</h1>
    </header>

    <div id="overlay"></div>
    <div id="notificationBox" class="notification-box">
        <p id="notificationMessage"></p>
        <button onclick="closeNotification()">Back to Profile</button>
    </div>

    <div class="container">
        <?php
        $conn = new mysqli("localhost", "root", "", "the_overcooked_db");

        if ($conn->connect_error) {
            die(json_encode(array("status" => "error", "message" => "Database connection failed: " . $conn->connect_error)));
        }

        // ✅ Ensure only 'id' is used in the URL
        $recipeId = isset($_GET['id']) ? intval($_GET['id']) : null;
        if (!$recipeId) {
            die("<p>Recipe ID is missing.</p>");
        }

        // Fetch recipe from `posted_recipe`
        $sql = "SELECT * FROM posted_recipe WHERE recipeId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $recipeId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $recipe = $result->fetch_assoc();
            echo "<h2>" . htmlspecialchars($recipe['recipeName']) . "</h2>";
            echo "<img src='" . htmlspecialchars($recipe['picture']) . "' alt='" . htmlspecialchars($recipe['recipeName']) . "' class='recipe-details-image'>";
            echo "<p><strong>Category:</strong> " . htmlspecialchars($recipe['category']) . "</p>";
            echo "<p><strong>Tag:</strong> " . htmlspecialchars($recipe['tag']) . "</p>";
            echo "<p><strong>Note:</strong> " . htmlspecialchars($recipe['note']) . "</p>";
            echo "<p><strong>Details:</strong> " . htmlspecialchars($recipe['details']) . "</p>";
            echo "<p><strong>Ingredients:</strong> " . htmlspecialchars($recipe['ingredients']) . "</p>";
            echo "<p><strong>Instructions:</strong> " . htmlspecialchars($recipe['instruction']) . "</p>";

            // ✅ Check if there's a pending edit for this recipe
            $pendingQuery = $conn->prepare("SELECT * FROM pending_recipe WHERE originalId = ? AND status = 'pending'");
            $pendingQuery->bind_param("i", $recipeId);
            $pendingQuery->execute();
            $pendingResult = $pendingQuery->get_result();

            if ($pendingResult->num_rows > 0) {
                echo "<p style='color: orange;'><strong>Pending Edit: </strong>An updated version of this recipe is waiting for admin approval.</p>";
            }
            $pendingQuery->close();

            // Edit and Delete Buttons
            echo "<div class='button-container'>
                    <button onclick=\"document.getElementById('editRecipeForm').style.display = 'block';\">Edit</button>
                    <button onclick=\"handleDelete($recipeId)\">Delete</button>
                </div>";

            // Edit Form (Submits to `pending_recipe`)
            echo "<form id='editRecipeForm' style='display: none;' onsubmit='handleEdit(event)'>
                    <h3>Edit Recipe</h3>
                    <input type='hidden' name='recipeId' value='" . htmlspecialchars($recipeId) . "'>
                    <label for='recipeName'>Recipe Name:</label>
                    <input type='text' id='recipeName' name='recipeName' value='" . htmlspecialchars($recipe['recipeName']) . "' required>

                    <label for='category'>Category:</label>
                    <select id='category' name='category' required>
                        <option value='Breakfast' " . ($recipe['category'] == 'Breakfast' ? 'selected' : '') . ">Breakfast</option>
                        <option value='Lunch' " . ($recipe['category'] == 'Lunch' ? 'selected' : '') . ">Lunch</option>
                        <option value='Dinner' " . ($recipe['category'] == 'Dinner' ? 'selected' : '') . ">Dinner</option>
                        <option value='Dessert' " . ($recipe['category'] == 'Dessert' ? 'selected' : '') . ">Dessert</option>
                        <option value='Beverages' " . ($recipe['category'] == 'Beverages' ? 'selected' : '') . ">Beverages</option>
                    </select>

                    <label for='tag'>Tag:</label>
                    <input type='text' id='tag' name='tag' value='" . htmlspecialchars($recipe['tag']) . "' required>

                    <label for='note'>Note:</label>
                    <textarea id='note' name='note' required>" . htmlspecialchars($recipe['note']) . "</textarea>

                    <label for='ingredients'>Ingredients:</label>
                    <textarea id='ingredients' name='ingredients' required>" . htmlspecialchars($recipe['ingredients']) . "</textarea>

                    <label for='instruction'>Instructions:</label>
                    <textarea id='instruction' name='instruction' required>" . htmlspecialchars($recipe['instruction']) . "</textarea>

                    <label for='picture'>Change Picture:</label>
                    <input type='file' id='picture' name='picture' accept='image/*'>

                    <button type='submit'>Submit Changes</button>
                    <button type='button' onclick=\"document.getElementById('editRecipeForm').style.display = 'none';\">Cancel</button>
                </form>";
        } else {
            echo "<p>Recipe not found.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
