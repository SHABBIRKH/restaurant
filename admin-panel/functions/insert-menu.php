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
    $restaurant = $_POST['restaurant'];
    $menuname = $_POST['menu-name'];
    $description = $_POST['description'];


    // Validate form input
    if (empty($restaurant) || empty($menuname) || empty($description)) {
        echo '<script type="text/javascript">alert("Please fill in all fields.");</script>';
        exit();
    }
    // insert into database
    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($con, "INSERT INTO menu (menu_name , restaurant, description) VALUES (?, ?, ?)");

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sss", $menuname, $restaurant, $description);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo '<script type="text/javascript"> 
                    alert("Added successfully");
                    window.location.href="../menu-list.php"; 
                </script>';
    } else {
        echo '<script type="text/javascript">alert("something went wrong");</script>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
