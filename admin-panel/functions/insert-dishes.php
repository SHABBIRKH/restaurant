<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
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
    $dishname = $_POST['dish-name'];
    $price = $_POST['price'];
    $taxes = $_POST['taxes'];
    $restaurant = $_POST['restaurant'];
    $category  = $_POST['category'];
    $menu  = $_POST['menu'];
    $img = $_FILES['img']['name'];
    // $description = $_POST['description'];


    // File upload handling
    $tmp_name = $_FILES['img']['tmp_name'];
    $path = "../upload/" . $img;
    $path1 = "../upload/" . $img;


    if (move_uploaded_file($tmp_name, $path)) {
        // File uploaded successfully, continue with database insertion
        // You should perform additional validation and sanitation on user input

        // Use prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($con, "INSERT INTO dishes (dish_name, price, taxes, restaurant, category, menu, img) VALUES (?, ? , ? , ? , ? ,? , ? )");
        // Check if the prepare statement succeeded
        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $dishname, $price, $taxes, $restaurant, $category, $menu, $path1);
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo '<script type="text/javascript">
                alert("Service added successfully");
                </script>';
                header("location:../dishes-list.php");
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
