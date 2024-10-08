<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
    echo "<script>Alert('not logged in') </script>";
    header("location:login.php");
}

include "master/nav.php";
?>

<!-<div class="container">
  <div class="col-lg-10 mx-auto">
    <main id="main" class="main">

      <div class="pagetitle">
        <h1>Add Menu</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Add Items</li>
            <li class="breadcrumb-item active">Add Menu</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <div class="col-12">
        <p class="small mb-0"> <a href="menu-list.php">Menu List</a></p>
      </div>

      <h5 class="card-title">Add Menu</h5>
      <!-- <p>Browser default validation with using the <code>required</code> keyword. Try submitting the form below. Depending on your browser and OS, you’ll see a slightly different style of feedback.</p> -->
      <br>
      <!-- Browser Default Validation -->
      <form class="row g-3" method="post" action="functions/insert-menu.php" enctype="multipart/form-data">

        <?php
        // Include your database configuration file
        include "auth/config.php";

        // Assuming your table name is 'restaurants'
        $query = "SELECT id, restaurant_name FROM restaurants";
        $result = mysqli_query($con, $query);
        ?>
        <div class="col-md-3">
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
        <div class="col-md-3">
          <label for="validationDefault05" class="form-label">Menu Name</label>
          <input type="text" class="form-control" name="menu-name" id="validationDefault05" required>
        </div>
        <div class="col-md-6">
          <label for="validationDefault03" class="form-label">Description</label>
          <textarea class="form-control" style="height: 100px" name="description" placeholder="A restaurant website is an online platform that showcases a dining establishment's menu, ambiance and services." required></textarea>
        </div>
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