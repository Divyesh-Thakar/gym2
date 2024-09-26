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
  <?php
   include("header.php");?>
    <!-- slider section -->
    <section class="slider_section position-relative">
      <div class="container">
        <div class="custom_nav2">
          <nav class="navbar navbar-expand-lg custom_nav-container ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <div class="d-flex  flex-column flex-lg-row align-items-center">
                <ul class="navbar-nav  ">
                  <li class="nav-item ">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="about.php">About </a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="service.php">Services </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                  </li>
                </ul>
                <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
                  <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
                </form>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>

  <!-- service section -->

  <section class="service_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Our Services
        </h2>
      </div>
      <div class="service_container">
        <div class="box">
          <img src="images/s-1.jpg" alt="">
          <h6 class="visible_heading">
            CROSSFIT TRAINING
          </h6>
          <div class="link_box">
            <a href="">
              <img src="images/link.png" alt="">
            </a>
            <h6>
              CROSSFIT TRAINING
            </h6>
          </div>
        </div>
        <div class="box">
          <img src="images/s-2.jpg" alt="">
          <h6 class="visible_heading">
            FITNESS
          </h6>
          <div class="link_box">
            <a href="">
              <img src="images/link.png" alt="">
            </a>
            <h6>
              FITNESS
            </h6>
          </div>
        </div>
        <div class="box">
          <img src="images/s-3.jpg" alt="">
          <h6 class="visible_heading">
            DYNAMIC STRENGTH TRAINING
          </h6>
          <div class="link_box">
            <a href="">
              <img src="images/link.png" alt="">
            </a>
            <h6>
              DYNAMIC STRENGTH TRAINING
            </h6>
          </div>
        </div>      
        <div class="box">
          <img src="images/s-4.jpg" alt="">
          <h6 class="visible_heading">
            HEALTH
          </h6>
          <div class="link_box">
            <a href="">
              <img src="images/link.png" alt="">
            </a>
            <h6>
              HEALTH
            </h6>
          </div>
        </div>
        <div class="box">
          <img src="images/s-5.jpg" alt="">
          <h6 class="visible_heading">
            WORKOUT
          </h6>
          <div class="link_box">
            <a href="">
              <img src="images/link.png" alt="">
            </a>
            <h6>
              WORKOUT
            </h6>
          </div>
        </div>
        <div class="box">
          <img src="images/s-6.jpg" alt="">
          <h6 class="visible_heading">
            STRATEGIES
          </h6>
          <div class="link_box">
            <a href="">
              <img src="images/link.png" alt="">
            </a>
            <h6>
              STRATEGIES
            </h6>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end service section -->

  <?php
   include("footer.php");?>

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>

  <script>
    function openNav() {
      document.getElementById("myNav").classList.toggle("menu_width");
      document
        .querySelector(".custom_menu-btn")
        .classList.toggle("menu_btn-style");
    }
  </script>
</body>

</html>
<?php
// Connect to the database
$conn = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all images
$sql = "SELECT service_name, image_data FROM service_images";
$result = $conn->query($sql);
?>

<section class="service_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>Our Services</h2>
        </div>
        <div class="service_container">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '
                    <div class="box">
                        <img src="'.$row["image_data"].'" alt="'.$row["service_name"].'">
                        <h6 class="visible_heading">'.strtoupper($row["service_name"]).'</h6>
                        <div class="link_box">
                            <a href="">
                                <img src="images/link.png" alt="">
                            </a>
                            <h6>'.strtoupper($row["service_name"]).'</h6>
                        </div>
                    </div>';
                }
            } else {
                echo "No services available.";
            }
            ?>
        </div>
    </div>
</section>

<?php
$conn->close();
?>
