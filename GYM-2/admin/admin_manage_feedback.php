<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
include("../db.php");

// Check if 'delete_id' is set in the POST request to handle the delete action
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']); // Convert the ID to an integer to avoid SQL injection

    // Prepare and execute the delete query
    $query = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Success message
        $_SESSION['message'] = "Feedback deleted successfully.";
    } else {
        // Failure message
        $_SESSION['message'] = "Failed to delete feedback.";
    }
    $stmt->close();
}

// Fetch feedback data
$query = "SELECT * FROM feedback ORDER BY submission_date DESC";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>Manage Feedback - Energym</title>

    <!-- Include Stylesheets -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
</head>
<body>
    <?php include("../header.php"); ?>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Menu</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="remove_member.php">Remove Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mange_classes.php">Manage Classes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_manage_memberships.php">Manage Membership Plans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_manage_feedback.php">Manage Feedback</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        <h2>Manage Feedback</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?php
                echo htmlspecialchars($_SESSION['message']);
                unset($_SESSION['message']); // Clear the message after displaying it
                ?>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rating</th>
                        <th>Type</th>
                        <th>Recommend</th>
                        <th>Feedback</th>
                        <th>Submission Date</th>
                        <th>Action</th> <!-- New column for action -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['feedback_type']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['recommend']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['feedback']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>";
                            echo "<td>
                                    <form method='POST' onsubmit=\"return confirm('Are you sure you want to delete this feedback?');\">
                                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No feedback available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include("../footer.php"); ?>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
