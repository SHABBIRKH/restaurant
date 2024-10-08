<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include 'master/nav.php';
include 'auth/config.php';

$sql = "SELECT * FROM category";
$result = mysqli_query($con, $sql);
?>

<main id="main" class="main">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Category List</h5>

      <div class="col-12" style="margin-left:1%" ;>
        <a href="add-category.php">
          <button class="btn btn-primary" name="button" type="submit">Add Category</button>
        </a>
      </div>
<br>
      <!-- Dark Table -->
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Category Name</th>
            <th scope="col">Restaurant</th>
            <th scope="col"><span class="bi bi-trash-fill custom-icon-color" style="color: black;"></span></th>
            <th scope="col"><span class="bi bi-pencil-square custom-icon-color" style="color: black;"></span></th>

          </tr>
        </thead>
        <tbody>
          <?php
          if ($result) {
            while ($row = mysqli_fetch_array($result)) {
          ?>
              <tr>
                <th scope="row"><?php echo $row['id'] ?></th>
                <td><?php echo $row['category'] ?></td>
                <?php
                // fetching Restaurant name from Restaurant table from id
                include 'auth/config.php';
                // select statement
                $stmt = "SELECT restaurant_name FROM restaurants WHERE id =$row[restaurants] ";
                $rs = mysqli_query($con, $stmt);
                // loop
                if ($rs) {
                  while ($col = mysqli_fetch_array($rs)) {
                ?>
                    <td>
                      <!-- Restaurant name from Restaurant through id -->
                      <?php echo $col['restaurant_name']; ?> </td>
                <?php
                  }
                }
                ?>

                <td><a href="category-delete.php?delete=<?php echo $row['id'] ?>"><span class="bi bi-trash-fill custom-icon-color" style="color: black;"></span></td>
                <td><a href="category-edit.php?edit=<?php echo $row['id'] ?>"><span class="bi bi-pencil-square custom-icon-color" style="color: black;"></span></td>
              </tr>

          <?php
            }
          }
          ?>
        </tbody>
      </table>
      <!-- End Dark Table -->

    </div>
  </div>
</main>


<?php
include 'master/footer.php';
?>