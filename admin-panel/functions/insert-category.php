<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
    echo "<script>Alert('not logged in') </script>";
    header("location:login.php");
}

include "../auth/config.php";


if (isset($_POST['submit'])) {
    include "../auth/config.php";
    // Check if the database connection is successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // get values from from POST method
    $category = $_POST['category'];
    $restaurant = $_POST['restaurants'];


    // Validate form input
    if (empty($category) || empty($restaurant)) {
        echo '<script type="text/javascript">alert("Please fill in all fields.");</script>';
        exit();
    }
    // insert into database
    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($con, "INSERT INTO category (category , restaurants) VALUES (?, ?)");

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $category, $restaurant);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo '<script type="text/javascript"> 
                    alert("Added successfully");
                    window.location.href="../category-list.php"; 
                </script>';
    } else {
        echo '<script type="text/javascript">alert("something went wrong");</script>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
