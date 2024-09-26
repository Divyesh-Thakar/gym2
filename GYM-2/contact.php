<!DOCTYPE html>
<html>
<head>
<!-- Basic -->
<meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Energym</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

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

<body class="sub_page">
  <div class="hero_area">
    <?php include("header.php"); ?>
    <!-- slider section -->
    <section class="slider_section position-relative">
      <!-- slider content -->
    </section>
    <!-- end slider section -->
  </div>

  <!-- contact section -->
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2><span>Get In Touch</span></h2>
      </div>
      <div class="layout_padding2-top">
        <div class="row">
          <div class="col-md-6">
            <form action="contact.php" method="POST">
              <div class="contact_form-container">
                <div>
                  <div>
                    <input type="text" name="name" placeholder="Name" required />
                  </div>
                  <div>
                    <input type="email" name="email" placeholder="Email" required />
                  </div>
                  <div>
                    <input type="text" name="phone" placeholder="Phone Number" required />
                  </div>
                  <div class="mt-5">
                    <input type="text" name="message" placeholder="Message" required />
                  </div>
                  <div class="mt-5">
                    <button type="submit">Send</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <div class="map_container">
              <div class="map-responsive">
              <iframe
                  src="https://www.google.co.in/maps/place/Atmiya+University/@22.2823656,70.7652068,17z/data=!3m1!4b1!4m6!3m5!1s0x3959cbbfcdeb3e33:0x11a782bf6775a71d!8m2!3d22.2823607!4d70.7677871!16s%2Fg%2F11grv2z9w5?entry=ttu&g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D"
                  width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%"
                  allowfullscreen></iframe> <!-- Google Map Embed -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end contact section -->
  <?php include("footer.php"); ?>

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>

  <script>
    function openNav() {
      document.getElementById("myNav").classList.toggle("menu_width");
      document.querySelector(".custom_menu-btn").classList.toggle("menu_btn-style");
    }
  </script>
</body>
</html>

<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection file
include("db.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Prepare an SQL statement to insert the data
    $query = "INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare() failed: ' . htmlspecialchars($conn->error));
    }

    $bind = $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if ($bind === false) {
        die('Bind_param() failed: ' . htmlspecialchars($stmt->error));
    }

    $exec = $stmt->execute();

    if ($exec === false) {
        die('Execute() failed: ' . htmlspecialchars($stmt->error));
    } else {
        echo "Your message has been sent successfully!";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No POST data received.";
}

// Close the database connection
$conn->close();
?>
