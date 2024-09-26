<?php
include('db.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']); // Sanitize user input
    $email = trim($_POST['email']); // Sanitize user input
    $password = trim($_POST['password']); // Sanitize user input
    $confirm_password = trim($_POST['confirm_password']); // Sanitize user input

    // Check if passwords match
    if ($password === $confirm_password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an SQL statement to insert the new user
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);

        // Execute the query
        if ($stmt->execute()) {
            echo "Registration successful! Redirecting to login page...";
            header("Refresh: 3; URL=login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "<div class='alert alert-danger'>Passwords do not match!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
   include("header.php");?>

    <!-- Register section -->
    <section class="register_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>Register</h2>
            </div>
            <div class="register_form">
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="fullname">Full Name:</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <div class="mt-3">
                    <p>Already have an account? <a href="login.php" class="btn btn-secondary">Login</a></p>
                </div>
            </div>
        </div>
    </section>
    <!-- End register section -->
    <?php
   include("footer.php");?>
</body>
</html>
