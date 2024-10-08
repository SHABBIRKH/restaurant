<?php
session_start();
if ($_SESSION['loggedin'] != true || !$_SESSION['loggedin']) {
  echo "<script>Alert('not logged in') </script>";
  header("location:login.php");
}

include "master/nav.php";
?>
<!-- php for update form -->
<?php
if (isset($_POST['update'])) {

  include "auth/config.php";
  $name = $_POST['fullName'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $img = $_FILES['img']['name'];

  $tmp_name = $_FILES['img']['tmp_name'];
  $path = "upload/" . $img;
  $path1 = "upload/" . $img;
  if (move_uploaded_file($tmp_name, $path)) {

    $sql = "UPDATE admin SET full_name='$name', email = '$email', role = '$role', img='$path1'";
    $result = mysqli_query($con, $sql);
    if ($result) {
      echo "<script type='text/javascript'>alert('edit'); 
        window.location.href = 'users-profile.php'; 
        </script>";
    } else {
      echo "<script>alert('not edited');
</script>";
    }
  }
}

?>
<!-- php for update form end-->


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <!-- show Details start -->
  <?php
  include 'auth/config.php';

  $sql = "SELECT * FROM admin WHERE id = 1";
  $result = mysqli_query($con, $sql);
  if ($result) {
    while ($row = mysqli_fetch_array($result)) {
  ?>

      <section class="section profile">
        <div class="row">
          <div class="col-xl-4">

            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                <img src="<?php echo $row['img'] ?>" alt="Profile" class="rounded-circle">
                <h2><?php echo $row['full_name'] ?></h2>
                <h3><?php echo $row['role'] ?></h3>
              </div>
            </div>

          </div>

          <div class="col-xl-8">

            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                  </li>



                  <!-- <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                  </li> -->

                </ul>
                <div class="tab-content pt-2">

                  <div class="tab-pane fade show active profile-overview" id="profile-overview">


                    <h5 class="card-title">Profile Details</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Full Name</div>
                      <div class="col-lg-9 col-md-8"><?php echo $row['full_name'] ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Role</div>
                      <div class="col-lg-9 col-md-8"><?php echo $row['role'] ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8"><?php echo $row['email'] ?></div>
                    </div>

                  </div>


                  <!-- show Details end -->

                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <!-- Profile Edit Form -->
                    <form method="post" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-3">
                          <label for="validationDefault05" class="form-label">Image</label>
                          <input type="file" class="form-control" name="img" aria-describedby="inputGroupPrepend2" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $row['full_name'] ?>">
                        </div>
                      </div>


                      <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Role</label>
                        <div class="col-md-8 col-lg-9">
                          <input type="text" class="form-control" id="Email" value="<?php echo $row['role'] ?>" name="role">
                        </div>
                      </div>



                      <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input type="email" class="form-control" id="Email" value="<?php echo $row['email'] ?>" name="email">
                        </div>
                      </div>


                  <?php
                }
              }
                  ?>

                  <div class="text-center">
                    <input type="submit" class="btn btn-primary" name="update"></button>
                  </div>
                    </form><!-- End Profile Edit Form -->


                  </div>

                  <div class="tab-pane fade pt-3" id="profile-settings">



                  </div>

                  <!-- <div class="tab-pane fade pt-3" id="profile-change-password"> -->
                    <!-- Change Password Form -->
                    <!-- <form>

                      <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="password" type="password" class="form-control" id="currentPassword">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="newpassword" type="password" class="form-control" id="newPassword">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                      </div>
                    </form>End Change Password Form -->

                  </div>

                </div><!-- End Bordered Tabs -->

              </div>
            </div>

          </div>
        </div>
      </section>

</main><!-- End #main -->
<?php
include "master/footer.php";
?>