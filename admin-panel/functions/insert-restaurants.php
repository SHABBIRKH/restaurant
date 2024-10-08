<?php
session_start();
if($_SESSION['loggedin']!= true || !$_SESSION['loggedin']){
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include "../auth/config.php";

if (isset($_POST['submit'])) {
    // Include your database configuration file
    include "../auth/config.php";
    // Check if the database connection is successful

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }


    // get values from from POST method
    $restaurant_name = $_POST['restaurant-name'];
    $email = $_POST['email'];
    $whatsapp_number = $_POST['WhatsApp-number'];
    $text_message_number = $_POST['text-message-number'];
    $phone  = $_POST['phone'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $logo = $_FILES['logo']['name'];
    $location_link = $_POST['location-link'];


    // File upload handling
    $tmp_name = $_FILES['logo']['tmp_name'];
    $path = "../upload/" . $logo;
    $path1 = "../upload/" . $logo;


    if (move_uploaded_file($tmp_name, $path)) {
        // File uploaded successfully, continue with database insertion
        // You should perform additional validation and sanitation on user input

        // Use prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($con, "INSERT INTO restaurants (restaurant_name, email, whatsapp_number, text_message_number, phone, city, State, zip, logo, location_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // Check if the prepare statement succeeded
        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $restaurant_name, $email, $whatsapp_number, $text_message_number, $phone, $city, $state, $zip, $path1, $location_link);
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo '<script type="text/javascript">
                alert("Service added successfully");
                </script>';
                header("location:../restaurant-list.php");
            } else {
                echo '<script type="text/javascript">
                alert("Error adding service");
                </script>';
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle the case when preparing the statement fails
            echo "Error preparing statement: " . mysqli_error($con);
        }
    } else {
        echo '<script type="text/javascript">alert("Error uploading file");</script>';
    }

    // Close the database connection
    mysqli_close($con);
}
