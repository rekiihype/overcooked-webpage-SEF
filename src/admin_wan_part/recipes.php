<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'the_overcooked_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Pending Recipes
$pendingSql = "SELECT pendingId, recipeName, chefId, submitted_at FROM pending_recipe";
$pendingResult = $conn->query($pendingSql);

// Fetch Posted Recipes
$postedSql = "SELECT recipeId, recipeName, chefId, datetime_posted FROM posted_recipe WHERE approved = 0";
$postedResult = $conn->query($postedSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes</title>
    <link rel="stylesheet" href="./global.css">
    <link rel="stylesheet" href="./recipesStyle.css">
</head>
<body>
    <div class="main-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
            <a href="./dashboard.html">
                    <img src="./brand_logo.svg" alt="The OverCooked" class="logo-img">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a></li>
                    <li><a href="./adminProfile.html">Admin Profile</a></li>
                    <li class="divider">Verification</li>
                    <li><a href="#" class="active">Recipes</a></li>
                    <li><a href="./comments.php">Comments</a></li>
                    <li class="divider">Manage</li>
                    <li><a href="./usersManagement.php">User Accounts</a></li>
                    <li class="divider">Miscellaneous</li>
                    <li><a href="#">Trash</a></li>
                    <li><a href="#">Policies</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="content">
            <!-- Header Bar -->
            <header class="header-bar">
                <div class="left">
                    <h1>Recipes</h1>
                </div>
                <div class="right">
                    <span>Activity Logs</span>
                    <span class="icon">🔍</span>
                    <span class="icon">🔔</span>
                    <span class="icon">👤</span>
                </div>
            </header>

            <!-- Recipes Content -->
            <section class="recipes-content">
                <h2>Pending Recipe Approvals</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Recipe ID</th>
                            <th>Recipe Name</th>
                            <th>Submitted Date</th>
                            <th>Chef ID</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($pendingResult->num_rows > 0) {
                            while ($row = $pendingResult->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['pendingId']}</td>
                                    <td>{$row['recipeName']}</td>
                                    <td>{$row['submitted_at']}</td>
                                    <td>{$row['chefId']}</td>
                                    <td>
                                        <form method='POST' action='recipes.php'>
                                            <input type='hidden' name='recipe_id' value='{$row['pendingId']}'>
                                            <button type='submit' name='action' value='approve' class='approve-btn'>Approve</button>
                                            <button type='submit' name='action' value='reject' class='reject-btn'>Reject</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No recipes pending approval.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <h2>Posted Recipes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Recipe ID</th>
                            <th>Recipe Name</th>
                            <th>Posted Date</th>
                            <th>Chef ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($postedResult->num_rows > 0) {
                            while ($row = $postedResult->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['recipeId']}</td>
                                    <td>{$row['recipeName']}</td>
                                    <td>{$row['datetime_posted']}</td>
                                    <td>{$row['chefId']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No posted recipes available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <?php
    // Handle Approve/Reject Actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['recipe_id'])) {
        $recipeId = $conn->real_escape_string($_POST['recipe_id']);
        $action = $_POST['action'] === 'approve' ? 1 : 0; // 1 for approved, 0 for rejected

        if ($action === 1) {
            // Move recipe to `posted_recipe` table
            $moveSql = "INSERT INTO posted_recipe (recipeId, recipeName, chefId, datetime_posted)
                        SELECT pendingId, recipeName, chefId, submitted_at
                        FROM pending_recipe
                        WHERE pendingId = '$recipeId'";
            $deleteSql = "DELETE FROM pending_recipe WHERE pendingId = '$recipeId'";

            if ($conn->query($moveSql) === TRUE && $conn->query($deleteSql) === TRUE) {
                echo "<script>alert('Recipe has been approved and moved to posted recipes!'); window.location.href='recipes.php';</script>";
            } else {
                echo "<script>alert('Error moving recipe: " . $conn->error . "');</script>";
            }
        } else {
            // Reject recipe
            /*$updateSql = "UPDATE pending_recipe SET approved = 0 WHERE recipeId = '$pendingId'";

            if ($conn->query($updateSql) === TRUE) {
                echo "<script>alert('Recipe has been rejected!'); window.location.href='recipes.php';</script>";
            } else {
                echo "<script>alert('Error rejecting recipe: " . $conn->error . "');</script>";
            }*/
        }
    }
    ?>
</body>
</html>
