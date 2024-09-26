<?php
session_start(); // Start the session to manage user sessions
include('db.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']); // Sanitize user input
    $password = trim($_POST['password']); // Sanitize user input

    // Prepare an SQL statement to select the user with the provided email
    $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email = ?");
    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fullname, $hashed_password, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['role'] = $role;

            // Redirect to the dashboard or appropriate page
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Invalid email or password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid email or password!</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
   include("header.php");?>
    <!-- Login section -->
    <section class="login_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>Login</h2>
            </div>
            <div class="login_form">
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="mt-3">
                    <p>Not registered? <a href="register.php" class="btn btn-secondary">Register</a></p>
                </div>
            </div>
        </div>
    </section>
    <!-- End login section -->
    <?php
   include("footer.php");?>
</body>
</html>
