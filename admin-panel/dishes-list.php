<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include 'master/nav.php';
include 'auth/config.php';
$sql = "SELECT * FROM dishes";
$result = mysqli_query($con, $sql);
?>

<main id="main" class="main">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Dishes List</h5>

      <div class="col-12" style="margin-left:1%" ;>
        <a href="add-dishes.php">
          <button class="btn btn-primary" name="button" type="submit">Add Dishes</button>
        </a>
      </div>
      <br>

      <!-- Dark Table -->
      <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Dish-Name</th>
            <th scope="col">Price</th>
            <th scope="col">taxes</th>
            <th scope="col">Restaurant</th>
            <th scope="col">category</th>
            <th scope="col">menu</th>
            <th scope="col">image</th>
            <th scope="col">description</th>
            <th scope="col"><span class="bi bi-trash-fill custom-icon-color" style="color: black;"></span></th>
            <th scope="col"><span class="bi bi-pencil-square custom-icon-color" style="color: black;"></span></th>
          </tr>
        </thead>
        <tbody>

          <?php
          if ($result) {
            while ($row = mysqli_fetch_array($result)) {;

          ?>
              <tr>
                <th scope="row"><?php echo $row['id'] ?></th>
                <td><?php echo $row['dish_name'] ?></td>
                <td>RS:<?php echo $row['price'] ?></td>
                <td>RS:<?php echo $row['taxes'] ?></td>

                <!-- Restaurant -->
                <?php
                // fetching Restaurant name from Restaurant table from id
                include 'auth/config.php';
                // select statement
                $stmt = "SELECT restaurant_name FROM restaurants WHERE id =$row[restaurant] ";
                $rs = mysqli_query($con, $stmt);
                // loop
                if ($rs) {
                  while ($col = mysqli_fetch_array($rs)) {
                ?>
                    <td>
                      <!-- Restaurant name from Restaurant through id -->
                      <?php echo $col['restaurant_name']; ?>
                    </td>
                <?php
                  }
                }
                ?>

                <!-- category -->
                <?php
                // fetching category name from category table from id
                include 'auth/config.php';
                // select statement
                $stmt = "SELECT category FROM category WHERE id =$row[category] ";
                $rs = mysqli_query($con, $stmt);
                // loop
                if ($rs) {
                  while ($col = mysqli_fetch_array($rs)) {
                ?>
                    <td><?php echo $col['category'] ?></td>
                <?php
                  }
                }
                ?>
                <!-- menu -->
                <?php
                // fetching category name from category table from id
                include 'auth/config.php';
                // select statement
                $stmt = "SELECT menu_name FROM menu WHERE id =$row[menu] ";
                $rs = mysqli_query($con, $stmt);
                // loop
                if ($rs) {
                  while ($col = mysqli_fetch_array($rs)) {
                ?>
                <td><?php echo $col['menu_name'] ?></td>
                <?php
                  }
                }
                ?>
                <td><img src="<?php echo $row['img'] ?>" width="50px" height="50px" alt="img"></td>
                <td><?php echo $row['description'] ?></td>
                <td><a href="dishes-delete.php?delete=<?php echo $row['id'] ?>"><span class="bi bi-trash-fill custom-icon-color" style="color: black;"></span></td>
                <td><a href="dishes-edit.php?edit=<?php echo $row['id'] ?>"><span class="bi bi-pencil-square custom-icon-color" style="color: black;"></span></td>
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