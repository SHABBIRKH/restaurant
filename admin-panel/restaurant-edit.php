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
  <!-- get data from id -->
  <!-- php script -->
  <?php
  include 'auth/config.php';

  // Check if 'edit' is set in the URL parameters
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Fetch data for the specified service ID
    $sql = "SELECT * FROM restaurants WHERE id='$id'";
    $rs = mysqli_query($con, $sql);

    // Check if the service exists
    if ($result = mysqli_fetch_array($rs)) {
      $restaurant_name = $result['restaurant_name'];
      $email = $result['email'];
      $whatsapp_number = $result['whatsapp_number'];
      $text_message_number = $result['text_message_number'];
      $phone = $result['phone'];
      $city = $result['city'];
      $State = $result['State'];
      $zip = $result['zip'];
      $location_link = $result['location_link'];
    } else {
      echo "Service not found";
    }
  }
  ?>
  <!-- end -->

  <h5 class="card-title">Restaurants Edit</h5>
  <!-- <p>Browser default validation with using the <code>required</code> keyword. Try submitting the form below. Depending on your browser and OS, you’ll see a slightly different style of feedback.</p> -->
  <br>

  <form class="row g-3" method="post" enctype="multipart/form-data">
    <div class="col-md-4">
      <label for="validationDefault01" class="form-label">Restaurant Name</label>
      <input type="text" class="form-control" id="validationDefault01" name="restaurant-name" value="<?php echo $restaurant_name; ?>" placeholder="Classic Cuisine Cafe" required>
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Email</label>
      <input type="Email" class="form-control" name="email" placeholder="ABC@example.com" value="<?php echo $email; ?>" id="validationDefault02" required>
    </div>
    <div class="col-md-4">
      <label for="validationDefaultUsername" class="form-label">WhatsApp Number</label>
      <div class="input-group">
        <span class="input-group-text" id="inputGroupPrepend2">+92</span>
        <input type="number" class="form-control" name="WhatsApp-number" placeholder="302227217" value="<?php echo $whatsapp_number; ?>" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationDefaultUsername" class="form-label">Text Message Number</label>
      <div class="input-group">
        <!-- <span class="input-group-text" id="inputGroupPrepend2">+92</span> -->
        <input type="number" class="form-control" name="text-message-number" placeholder="0302227217" value="<?php echo $text_message_number; ?>" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationDefaultUsername" class="form-label">Phone</label>
      <div class="input-group">
        <!-- <span class="input-group-text" id="inputGroupPrepend2">+92</span> -->
        <input type="number" class="form-control" name="phone" placeholder="0302227217" value="<?php echo $phone; ?>" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationDefault05" class="form-label">City</label>
      <input type="text" class="form-control" name="city" placeholder="Karachi" value="<?php echo $city; ?>" id="validationDefault05" required>
    </div>

    <div class="col-md-3">
      <label for="validationDefault04" class="form-label">State</label>
      <select class="form-select" name="state" id="validationDefault04" value="<?php echo $State; ?>" required>
        <option selected value=""></option>
        <option>...</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="validationDefault05" class="form-label">Zip</label>
      <input type="text" class="form-control" name="zip" placeholder="05444" value="<?php echo $zip; ?>" id="validationDefault05" required>
    </div>
    <div class="col-md-3">
      <label for="validationDefault05" class="form-label">Logo</label>
      <input type="file" class="form-control" name="logo" id="validationDefault05" required>
    </div>
    <div class="col-md-6">
      <label for="validationDefault03" class="form-label">Location Link</label>
      <input type="text" class="form-control" id="basic-url" name="location-link" value="<?php echo $location_link; ?>" placeholder="https://example.com/users/" aria-describedby="basic-addon3" required>
    </div>

    <div class="col-12">
      <button class="btn btn-primary" name="submit" type="submit">Submit</button>
    </div>
  </form>
  <!-- php script -->
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
    // uploading img
    if (move_uploaded_file($tmp_name, $path)) {
      // File uploaded successfully, continue with database insertion
      // update query

      $sql = "UPDATE restaurants SET restaurant_name='$restaurant_name', email='$email', whatsapp_number='$whatsapp_number', text_message_number='$text_message_number', phone='$phone', city='$city', State='$state', zip='$zip', logo='$path1', location_link='$location_link' WHERE id=$id";
      $result = mysqli_query($con, $sql);

      if ($result) {
        echo "<script type='text/javascript'>alert('edit'); 
        window.location.href = 'restaurant-list.php'; 
        </script>";
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
  }
  ?>
  <!-- end -->

</main>
<!-- main End -->
<?php
include 'master/footer.php';
?>