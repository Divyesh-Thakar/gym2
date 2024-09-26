<?php
session_start();
include("../db.php"); // Ensure this path is correct

// Initialize message variable
$message = "";

// Handle form submission for adding a new class
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];
    $instructor_name = $_POST['instructor_name'];
    $schedule_time = $_POST['schedule_time'];
    $schedule_day = $_POST['schedule_day'];
    $capacity = $_POST['capacity'];

    $query = "INSERT INTO classes (class_name, instructor_name, schedule_time, schedule_day, capacity)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ssssi", $class_name, $instructor_name, $schedule_time, $schedule_day, $capacity);
        if ($stmt->execute()) {
            $message = "Class added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error in preparing the statement: " . $conn->error;
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = "DELETE FROM classes WHERE id=?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            header("Location: manage_classes.php");
            exit(); // It's good practice to exit after header redirection
        } else {
            $message = "Error deleting class: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error in preparing the delete statement: " . $conn->error;
    }
}

// Fetch all classes
$query = "SELECT * FROM classes";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - Energym</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include("../header.php"); ?>

    <header>
        <h1>Manage Classes</h1>
        <nav>
            <a href="admin_dashboard.php">Admin Dashboard</a> |
            <a href="manage_classes.php">Manage Classes</a> |
            <a href="admin_logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Manage Classes</h2>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <form action="manage_classes.php" method="POST">
            <div class="form-group">
                <label for="class_name">Class Name</label>
                <input type="text" class="form-control" id="class_name" name="class_name" required>
            </div>
            <div class="form-group">
                <label for="instructor_name">Instructor Name</label>
                <input type="text" class="form-control" id="instructor_name" name="instructor_name" required>
            </div>
            <div class="form-group">
                <label for="schedule_time">Schedule Time</label>
                <input type="time" class="form-control" id="schedule_time" name="schedule_time" required>
            </div>
            <div class="form-group">
                <label for="schedule_day">Schedule Day</label>
                <input type="text" class="form-control" id="schedule_day" name="schedule_day" required>
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Class</button>
        </form>

        <h3 class="mt-5">Existing Classes</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Instructor Name</th>
                    <th>Schedule Time</th>
                    <th>Schedule Day</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['instructor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['schedule_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['schedule_day']); ?></td>
                        <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                        <td>
                            <a href="manage_classes.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this class?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include("../footer.php"); ?>

    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
</body>

</html>
