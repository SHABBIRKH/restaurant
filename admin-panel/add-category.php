<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include "master/nav.php";
?>
<!-- header -->


<div class="container">
  <div class="col-lg-10 mx-auto">
    <main id="main" class="main">

      <div class="pagetitle">
        <h1>Add Category</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Add Items</li>
            <li class="breadcrumb-item active">Add Category</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <div class="col-12">
        <p class="small mb-0"> <a href="category-list.php">Category List</a></p>
      </div>

      <h5 class="card-title">Add Category</h5>
      <!-- <p>Browser default validation with using the <code>required</code> keyword. Try submitting the form below. Depending on your browser and OS, you’ll see a slightly different style of feedback.</p> -->
      <br>
      <!-- Browser Default Validation -->
      <form class="row g-5" method="post" action="functions/insert-category.php" enctype="multipart/form-data">
        <div class="col-md-5">
          <label for="validationDefault01" class="form-label">Category</label>
          <input type="text" class="form-control" id="validationDefault01" name="category" placeholder="Coffe" required>
        </div>

        <?php
        // Include your database configuration file
        include "auth/config.php";

        // Assuming your table name is 'restaurants'
        $query = "SELECT id, restaurant_name FROM restaurants";
        $result = mysqli_query($con, $query);
        ?>
        <div class="col-md-5">
          <label for="validationDefault04" class="form-label">Restaurants</label>
          <select class="form-select" name="restaurant" id="validationDefault04" required>
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

        <?php
        // Free result set
        mysqli_free_result($result);
        mysqli_close($con);
        ?>

        <div class="col-12">
          <button class="btn btn-primary" name="submit" type="submit">Submit</button>
        </div>
      </form>
      <!-- End Browser Default Validation -->

    </main>
  </div>
</div>
<!-- End #main -->
<!-- footer -->
<?php
include "master/footer.php";
?>