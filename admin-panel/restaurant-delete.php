<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
    echo "<script>Alert('not logged in') </script>";
    header("location:login.php");
}


include "auth/config.php";

$id = $_GET['delete'];

$sql = "DELETE FROM restaurants WHERE id= '$id'";

if (mysqli_query($con, $sql)) {
    echo "<script>alert('your data is deleted');</script>";
    header("location:restaurant-list.php");
}
