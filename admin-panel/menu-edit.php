<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include "master/nav.php";
?>
<!-- header -->
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Menu</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item">Table</li>
        <li class="breadcrumb-item">Menu List</li>
        <li class="breadcrumb-item active">Edit Menu</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->
  <!-- get data from id -->
  <?php
  include 'auth/config.php';

  // Check if 'edit' is set in the URL parameters
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Fetch data for the specified service ID
    $sql = "SELECT * FROM menu WHERE id='$id'";
    $rs = mysqli_query($con, $sql);

    // Check if the service exists
    if ($result = mysqli_fetch_array($rs)) {
      $menu_name = $result['menu_name'];
      $restaurant = $result['restaurant'];
      $description = $result['description'];
    } else {
      echo "Service not found";
    }
  }
  ?>

  <!--end -->

  <h5 class="card-title">Edit Menu</h5>
  <!-- <p>Browser default validation with using the <code>required</code> keyword. Try submitting the form below. Depending on your browser and OS, you’ll see a slightly different style of feedback.</p> -->
  <br>
  <!-- Browser Default Validation -->
  <form class="row g-3" method="post" action="#" enctype="multipart/form-data">

    <?php
    // Include your database configuration file
    include "auth/config.php";

    // Assuming your table name is 'restaurants'
    $query = "SELECT id, restaurant_name FROM restaurants";
    $result = mysqli_query($con, $query);
    ?>
    <div class="col-md-3">
      <label for="validationDefault04" class="form-label">Restaurants</label>
      <select class="form-select" name="restaurant" value="<?php echo $restaurant; ?>" id="validationDefault04" required>
        <option selected disabled value="">Choose...</option>

        <?php
        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['restaurant_name']; ?></option>
        <?php
          }
        } else {
          echo 'Error executing query: ' . mysqli_error($con);
        }
        ?>
      </select>
    </div>
    </div>
    <div class="col-md-3">
      <label for="validationDefault05" class="form-label">Menu Name</label>
      <input type="text" class="form-control" name="menu-name" value="<?php echo $menu_name; ?>" id="validationDefault05" required>
    </div>
    <div class="col-md-6">
      <label for="validationDefault03" class="form-label">Description</label>
      <textarea class="form-control" style="height: 100px" name="description" value="<?php echo $description; ?>" placeholder="A restaurant website is an online platform that showcases a dining establishment's menu, ambiance and services." required></textarea>
    </div>
    <div class="col-12">
      <button class="btn btn-primary" name="submit" type="submit">Submit</button>
    </div>
  </form>
  <!-- End Browser Default Validation -->

  <?php

  include 'auth/config.php';
  if (isset($_POST['submit'])) {
    include 'auth/config.php';
    $menuname = $_POST['menu-name'];
    $restaurant = $_POST['restaurant'];
    $description = $_POST['description'];

    $sql = $sql = "UPDATE menu SET menu_name='$menuname', restaurant='$restaurant', description='$description' WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
      echo "<script type='text/javascript'>alert('edit'); 
      window.location.href = 'menu-list.php'; 
      </script>";
    } else {
      echo "<script>alert('not edited');
        </script>";
    }
  }
  ?>

</main>
<!-- End #main -->
<!-- footer -->
<?php
include "master/footer.php";
?>