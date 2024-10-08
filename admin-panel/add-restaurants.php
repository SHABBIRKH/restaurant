<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
    echo "<script>Alert('not logged in') </script>";
    header("location:login.php");
}

include 'master/nav.php';
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Restaurants Edit</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item">Restaurant List</li>
        <li class="breadcrumb-item active">Restaurants Edit</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <div class="col-12">
    <p class="small mb-0"> <a href="restaurant-list.php">Restaurants List</a></p>
  </div>

  <h5 class="card-title">Restaurants Edit</h5>
  <!-- <p>Browser default validation with using the <code>required</code> keyword. Try submitting the form below. Depending on your browser and OS, you’ll see a slightly different style of feedback.</p> -->
  <br>

  <form class="row g-3" method="post" action="#" enctype="multipart/form-data">
    <div class="col-md-4">
      <label for="validationDefault01" class="form-label">Restaurant Name</label>
      <input type="text" class="form-control" id="validationDefault01" name="restaurant-name" placeholder="Classic Cuisine Cafe" required>
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Email</label>
      <input type="Email" class="form-control" name="email" placeholder="ABC@example.com" id="validationDefault02" required>
    </div>
    <div class="col-md-4">
      <label for="validationDefaultUsername" class="form-label">WhatsApp Number</label>
      <div class="input-group">
        <span class="input-group-text" id="inputGroupPrepend2">+92</span>
        <input type="number" class="form-control" name="WhatsApp-number" placeholder="302227217" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationDefaultUsername" class="form-label">Text Message Number</label>
      <div class="input-group">
        <!-- <span class="input-group-text" id="inputGroupPrepend2">+92</span> -->
        <input type="number" class="form-control" name="text-message-number" placeholder="0302227217" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationDefaultUsername" class="form-label">Phone</label>
      <div class="input-group">
        <!-- <span class="input-group-text" id="inputGroupPrepend2">+92</span> -->
        <input type="number" class="form-control" name="phone" placeholder="0302227217" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationDefault05" class="form-label">City</label>
      <input type="text" class="form-control" name="city" placeholder="Karachi" id="validationDefault05" required>
    </div>

    <div class="col-md-3">
      <label for="validationDefault04" class="form-label">State</label>
      <select class="form-select" name="state" id="validationDefault04" required>
        <option selected disabled value="">Choose...</option>
        <option>...</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="validationDefault05" class="form-label">Zip</label>
      <input type="text" class="form-control" name="zip" placeholder="05444" id="validationDefault05" required>
    </div>
    <div class="col-md-3">
      <label for="validationDefault05" class="form-label">Logo</label>
      <input type="file" class="form-control" name="logo" id="validationDefault05" required>
    </div>
    <div class="col-md-6">
      <label for="validationDefault03" class="form-label">Location Link</label>
      <input type="text" class="form-control" id="basic-url" name="location-link" placeholder="https://example.com/users/" aria-describedby="basic-addon3" required>
    </div>

    <div class="col-12">
      <button class="btn btn-primary" name="submit" type="submit">Submit</button>
    </div>
  </form>



  <?php


  include "auth/config.php";

  if (isset($_POST['submit'])) {
    // Include your database configuration file
    include "auth/config.php";
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
    $path = "upload/" . $logo;
    $path1 = "upload/" . $logo;


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
  ?>

</main>

<?php
include 'master/footer.php';
?>