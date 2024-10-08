<?php
session_start();
if($_SESSION['loggedin']!= true || !$_SESSION['loggedin']){
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include 'master/nav.php';
include 'auth/config.php';
$sql = "SELECT * FROM restaurants";
$result = mysqli_query($con, $sql);
?>

<main id="main" class="main">
  <div class="card">

    <div class="card-body">
      <h5 class="card-title">Restaurants List</h5>
    </div>

    <div class="col-12" style="margin-left:1%";>
    <a href="add-restaurants.php">
      <button class="btn btn-primary" name="button" type="submit">Add Restaurant</button>
      </a>
    </div>
<br>
    <!-- Default Table -->
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Whatsapp-NO</th>
          <th scope="col">Text-Message NO</th>
          <th scope="col">Phone</th>
          <th scope="col">City</th>
          <th scope="col">State</th>
          <th scope="col">Zip</th>
          <th scope="col">Logo</th>
          <th scope="col">Location</th>
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
              <td><?php echo $row['restaurant_name'] ?></td>
              <td><?php echo $row['email'] ?></td>
              <td><?php echo $row['whatsapp_number'] ?></td>
              <td><?php echo $row['text_message_number'] ?></td>
              <td><?php echo $row['phone'] ?></td>
              <td><?php echo $row['city'] ?></td>
              <td><?php echo $row['State'] ?></td>
              <td><?php echo $row['zip'] ?></td>
              <td><img src="<?php echo $row['logo'] ?>" width="50px" height="50px" alt="logo"></td>
              <td><?php echo $row['location_link'] ?></td>
              <td><a href="restaurant-delete.php?delete=<?php echo $row['id'] ?>"><span class="bi bi-trash-fill custom-icon-color" style="color: black;"></span></td>
              <td><a href="restaurant-edit.php?edit=<?php echo $row['id'] ?>"><span class="bi bi-pencil-square custom-icon-color" style="color: black;"></span></td>

            </tr>
        <?php
          }
        }
        ?>

      </tbody>
    </table>
  </div>
  </div>

</main>

<?php
include 'master/footer.php';
?>