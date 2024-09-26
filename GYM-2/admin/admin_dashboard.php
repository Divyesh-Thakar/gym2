<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - Energym</title>
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
</head>
<body>
    <?php 
    include("../header.php"); ?>

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
                            <a class="nav-link" href="upload.php">update service</a>
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
        <h2>Admin Overview</h2>
        <div class="card">
            <div class="card-body">
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>! Use the menu above to navigate through your admin options.</p>
                <!-- Add additional admin functionalities here -->
            </div>
        </div>
    </main>

    <?php 
    include("../footer.php"); ?>
</body>
</html>
