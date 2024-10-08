<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include 'master/nav.php';
include 'auth/config.php';

$sql = "SELECT * FROM menu";
$result = mysqli_query($con, $sql);
?>

<main id="main" class="main">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Menus List</h5>

      <div class="col-12" style="margin-left:1%";>
    <a href="add-menu.php">
      <button class="btn btn-primary" name="button" type="submit">Add Menu</button>
      </a>
    </div>
<br>
      <!-- Dark Table -->
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Menu</th>
            <th scope="col">Restaurant</th>
            <th scope="col">Description</th>
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
                <td><?php echo $row['menu_name'] ?></td>
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
                      <?php echo $col['restaurant_name']; ?> </td>
                <?php
                  }
                }
                ?>
                <td><?php echo $row['description'] ?></td>
                <td><a href="menu-delete.php?delete=<?php echo $row['id'] ?>"><span class="bi bi-trash-fill custom-icon-color" style="color: black;"></span></td>
                <td><a href="menu-edit.php?edit=<?php echo $row['id'] ?>"><span class="bi bi-pencil-square custom-icon-color" style="color: black;"></span></td>
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