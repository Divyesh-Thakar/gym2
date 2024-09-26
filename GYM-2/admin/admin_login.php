<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header section -->
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg custom_nav-container">
                <a class="navbar-brand" href="../index.php">
                    <img src="images/logo.png" alt="">
                    <span>
                        Energym Admin
                    </span>
                </a>
            </nav>
        </div>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

<!-- fonts style -->
<link href="https://fonts.googleapis.com/css?family=Baloo+Chettan|Dosis:400,600,700|Poppins:400,600,700&display=swap"
  rel="stylesheet" />
<!-- Custom styles for this template -->
<link href="../css/style.css" rel="stylesheet" />
<!-- responsive style -->
<link href="../css/responsive.css" rel="stylesheet" />
    </header>
    <!-- End header section -->

    <!-- Admin Login section -->
    <section class="login_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <center><h2>Admin Login</h2></center>
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']); // Clear the error after displaying it
                }
                ?>
            </div>
            <div class="login_form">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </section>
    <!-- End Admin Login section -->

</body>
</html>

<?php
session_start(); // Start the session to manage admin sessions
ob_start(); // Start output buffering

// Include the database connection file
include('../db.php'); // Adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $admin_name = mysqli_real_escape_string($conn, $_POST['username']);
    $admin_password = mysqli_real_escape_string($conn, $_POST['password']); // Escape the password input

    // Prepare the SQL query to fetch the username and password
    $query = "SELECT username, password FROM admin WHERE username = '$admin_name' AND password = '$admin_password'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn)); // Display any SQL errors
    }

    if (mysqli_num_rows($result) > 0) {
        // Set session variables
        $_SESSION['admin_name'] = $admin_name;

        // Redirect to the admin dashboard
        header("Location: admin_dashboard.php?message=success");
        exit(); // Ensure no further code is executed
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        // Redirect back to the login page to display the error
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
} 

// Close the database connection
mysqli_close($conn);
ob_end_flush(); // End output buffering and flush the buffer
?>

?>
