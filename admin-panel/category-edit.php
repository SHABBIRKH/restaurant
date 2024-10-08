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
    <h1>Edit Category</h1>
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
    $sql = "SELECT * FROM category WHERE id='$id'";
    $rs = mysqli_query($con, $sql);

    // Check if the service exists
    if ($result = mysqli_fetch_array($rs)) {
      $category = $result['category'];
      $restaurants = $result['restaurants'];
    } else {
      echo "Service not found";
    }
  }
  ?>

  <!--end -->

  <h5 class="card-title">Edit Category</h5>
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
            <option value="<?php echo $row['restaurant_name']; ?>"><?php echo $row['restaurant_name']; ?></option>
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
      <label for="validationDefault05" class="form-label">category Name</label>
      <input type="text" class="form-control" name="category" value="<?php echo $category; ?>" id="validationDefault05" required>
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
    $category = $_POST['category'];
    $restaurant = $_POST['restaurant'];
   
    $sql = $sql = "UPDATE category SET category='$category', restaurants='$restaurant' WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
      echo "<script type='text/javascript'>alert('edit'); 
      window.location.href = 'category-list.php'; 
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