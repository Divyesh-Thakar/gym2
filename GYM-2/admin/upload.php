<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Add New Service</h2>
        <form action="add_service.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="service_name">Service Name</label>
                <input type="text" name="service_name" id="service_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Service</button>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        // Database connection
        $conn = new mysqli("localhost", "username", "password", "database");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Collect form data
        $service_name = $conn->real_escape_string($_POST['service_name']);
        $image_data = addslashes(file_get_contents($_FILES['image']['tmp_name']));

        // Insert data into the database
        $sql = "INSERT INTO service_images (service_name, image_data) VALUES ('$service_name', '$image_data')";
        if ($conn->query($sql) === TRUE) {
            echo "New service added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
