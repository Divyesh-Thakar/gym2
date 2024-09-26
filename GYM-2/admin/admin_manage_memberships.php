<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
include("../db.php");

// Handle form submission for adding a membership plan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_plan'])) {
    $plan_name = $_POST['plan_name'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];

    $query = "INSERT INTO memberships (plan_name, duration, price) VALUES ('$plan_name', '$duration', '$price')";
    if (mysqli_query($conn, $query)) {
        $message = "New membership plan added successfully!";
    } else {
        $message = "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Handle membership plan deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = "DELETE FROM memberships WHERE id='$delete_id'";
    if (mysqli_query($conn, $query)) {
        $message = "Membership plan deleted successfully!";
    } else {
        $message = "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch existing membership plans
$query = "SELECT * FROM memberships";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Membership Plans - Energym</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 800px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333333;
            margin-bottom: 20px;
            font-weight: 700;
        }
        form {
            margin-bottom: 40px;
        }
        label {
            font-weight: 600;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f1f1f1;
            font-weight: 600;
        }
        a.delete-link {
            color: #dc3545;
            text-decoration: none;
        }
        a.delete-link:hover {
            text-decoration: underline;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body> 
    <div class="container">
        <h2>Manage Membership Plans</h2>
    </div>
     

        <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>

        <h3>Add a New Membership Plan</h3>
        <form method="POST" action="admin_manage_memberships.php">
            <label for="plan_name">Plan Name:</label>
            <input type="text" name="plan_name" required>
            
            <label for="duration">Duration (months):</label>
            <input type="number" name="duration" required>
            
            <label for="price">Price:</label>
            <input type="text" name="price" required>
            
            <input type="submit" name="add_plan" value="Add Plan">
        </form>

        <h3>Existing Membership Plans</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Plan Name</th>
                    <th>Duration (months)</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['plan_name']; ?></td>
                        <td><?php echo $row['duration']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <a class="delete-link" href="admin_manage_memberships.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this plan?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
