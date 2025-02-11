<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Recipes</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .recipe-row {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .recipe-row:hover {
            background-color: #f0f0f0;
        }
    </style>
    <script>
        function redirectToDetails(recipeId) {
            if (recipeId) {
                window.location.href = "C.pending_recipe_details.php?id=" + encodeURIComponent(recipeId);
            } else {
                alert("Invalid recipe ID.");
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Submitted Recipes</h1>
    </header>

    <div class="container">
        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "the_overcooked_db");

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Get chef ID from the query parameter
        $chefId = isset($_GET['chefId']) ? intval($_GET['chefId']) : 0;

        if ($chefId <= 0) {
            echo "<p>Invalid chef ID provided.</p>";
            $conn->close();
            exit;
        }

        // Fetch submitted recipes by the chef
        $sql = "SELECT * FROM pending_recipe WHERE chefId = ? ORDER BY submitted_at DESC";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "<p>Failed to prepare the query.</p>";
            $conn->close();
            exit;
        }

        $stmt->bind_param("i", $chefId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table class='recipe-table'>";
            echo "<thead>
                    <tr>
                        <th>Recipe Name</th>
                        <th>Category</th>
                        <th>Tag</th>
                        <th>Status</th>
                        <th>Rejection Reason</th>
                        <th>Date Submitted</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $recipeId = htmlspecialchars($row['pendingId']);
                echo "<tr class='recipe-row' onclick='redirectToDetails(\"$recipeId\")'>
                        <td>" . htmlspecialchars($row['recipeName']) . "</td>
                        <td>" . htmlspecialchars($row['category']) . "</td>
                        <td>" . htmlspecialchars($row['tag']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['rejection_reason'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['submitted_at']) . "</td>
                      </tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No submitted recipes found for this chef.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
