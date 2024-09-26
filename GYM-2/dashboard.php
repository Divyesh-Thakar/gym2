<?php
session_start();

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Fetch user information
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error fetching user data.";
}

// Fetch the name of the selected membership plan
$plan_name = "None"; // Default value if no plan is selected
if (!empty($user['membership_plan_id'])) {
    $plan_query = "SELECT plan_name FROM memberships WHERE id = " . $user['membership_plan_id'];
    $plan_result = $conn->query($plan_query);

    if ($plan_result->num_rows > 0) {
        $plan = $plan_result->fetch_assoc();
        $plan_name = $plan['plan_name'];
    }
}

// Fetch available membership plans
$plans_query = "SELECT * FROM memberships";
$plans_result = $conn->query($plans_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Energym</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

<!-- fonts style -->
<link href="https://fonts.googleapis.com/css?family=Baloo+Chettan|Dosis:400,600,700|Poppins:400,600,700&display=swap"
  rel="stylesheet" />
<!-- Custom styles for this template -->
<link href="css/style.css" rel="stylesheet" />
<!-- responsive style -->
<link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
<?php include("header.php"); ?>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['fullname']); ?>!</h1> <!-- Changed 'name' to 'fullname' -->
        
        <div class="row">
            <div class="col-md-6">
                <h2>Profile Information</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p> <!-- Changed 'name' to 'fullname' -->
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Membership Status:</strong> <?php echo htmlspecialchars($plan_name); ?></p>
                <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
            <div class="col-md-6">
                <h2>Recent Activities</h2>
                <ul>
                    <li>Workout Session on August 25, 2024</li>
                    <li>Yoga Class on August 24, 2024</li>
                    <li>Cardio Training on August 23, 2024</li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Select a Membership Plan</h2>
                <form method="POST" action="select_plan.php">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Duration (months)</th>
                                <th>Price</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($plans_result->num_rows > 0): ?>
                                <?php while ($plan = $plans_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($plan['plan_name']); ?></td>
                                        <td><?php echo htmlspecialchars($plan['duration']); ?></td>
                                        <td><?php echo htmlspecialchars($plan['price']); ?></td>
                                        <td>
                                            <input type="radio" name="selected_plan" value="<?php echo $plan['id']; ?>" required>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No membership plans available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <input type="submit" value="Select Plan" class="btn btn-success">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
<?php include("footer.php"); ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
