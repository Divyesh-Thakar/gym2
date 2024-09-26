<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .profile-container h2 {
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
            color: #343a40;
        }
        .form-group label {
            font-weight: 500;
            color: #495057;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <div class="profile-container">
        <h2>Edit Profile</h2>
        <form action="update-profile.php" method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" name="fullname" id="fullname" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
        </form>
    </div>

    <?php include("footer.php"); ?>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>

<?php
session_start();

// Include the database connection file
include('db.php'); // Make sure the path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data from the form
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Assuming you have the user ID stored in the session
    $userId = $_SESSION['user_id'];

    // Hash the password before saving it into the database (if not already hashed)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to update the user information
    $query = "UPDATE users SET fullname = '$fullname', email = '$email', password = '$hashed_password', address = '$address' WHERE id = $userId";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // If the query was successful, redirect to a success page or show a success message
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: profile.php"); // Redirect to profile page
        exit();
    } else {
        // If there was an error, show an error message
        $_SESSION['error'] = "Error updating profile: " . mysqli_error($conn);
        header("Location: edit-profile.php"); // Redirect back to edit profile page
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
?>
