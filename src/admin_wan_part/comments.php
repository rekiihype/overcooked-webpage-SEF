<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'the_overcooked_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Comments
$commentSql = "SELECT commentId, commentContent, commentDatetime, userId, recipeId FROM comment";
$commentResult = $conn->query($commentSql);

// Handle Delete Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commentId'])) {
    $commentId = $conn->real_escape_string($_POST['commentId']);

    // Delete the comment from the database
    $deleteSql = "DELETE FROM comment WHERE commentId = '$commentId'";

    if ($conn->query($deleteSql) === TRUE) {
        echo "<script>alert('Comment has been removed!'); window.location.href='comments.php';</script>";
    } else {
        echo "<script>alert('Error removing comment: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="./global.css">
    <link rel="stylesheet" href="./commentStyle.css">

    <script>
        function confirmDelete(event, form) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this comment?')) {
                form.submit();
            }
        }
    </script>
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
                    <li><a href="./recipes.php">Recipes</a></li>
                    <li><a href="#" class="active">Comments</a></li>
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
                    <h1>Comments</h1>
                </div>
                <div class="right">
                    <span>Activity Logs</span>
                    <span class="icon">🔍</span> <!-- Search Placeholder -->
                    <span class="icon">🔔</span> <!-- Notifications Placeholder -->
                    <span class="icon">👤</span> <!-- Profile Placeholder -->
                </div>
            </header>

            <!-- Comments Content -->
            <section class="comments-content">
                <h2>Reviewed Comments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Comment ID</th>
                            <th>Comments</th>
                            <th>Publish Date</th>
                            <th>Writer ID</th>
                            <th>Recipe ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($commentResult->num_rows > 0) {
                            while ($row = $commentResult->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['commentId']}</td>
                                    <td>{$row['commentContent']}</td>
                                    <td>{$row['commentDatetime']}</td>
                                    <td>{$row['userId']}</td>
                                    <td>{$row['recipeId']}</td>
                                    <td>
                                        <form method='POST' action='comments.php' onsubmit='confirmDelete(event, this)'>
                                            <input type='hidden' name='commentId' value='{$row['commentId']}'>
                                            <button type='submit' class='delete-btn'>Delete</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No comments available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>
