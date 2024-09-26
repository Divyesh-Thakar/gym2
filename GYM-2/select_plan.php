<?php
session_start();

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) 
{
    header("Location: login.php");
    exit();
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the correct user_id from session
    $user_id = $_SESSION['user_id'];  // Use 'user_id' to match the session check above
    $selected_plan_id = $_POST['selected_plan'];

    // Prepare the SQL statement to prevent SQL injection
    $query = $conn->prepare("UPDATE users SET membership_plan_id = ? WHERE id = ?");
    $query->bind_param("ii", $selected_plan_id, $user_id);

    // Execute the query
    if ($query->execute()) {
        echo "Membership plan updated successfully.";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating membership plan: " . $query->error;
    }

    // Close the statement
    $query->close();
}

// Close the database connection
$conn->close();
?>
