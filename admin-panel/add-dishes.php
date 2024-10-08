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
        <h1>Add Dishes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Add Items</li>
                <li class="breadcrumb-item active">Add Dishes</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <div class="col-12">
        <p class="small mb-0"> <a href="dishes-list.php">Dishes List</a></p>
      </div>

    <h5 class="card-title">Add Dishes</h5>
    <!-- <p>Browser default validation with using the <code>required</code> keyword. Try submitting the form below. Depending on your browser and OS, you’ll see a slightly different style of feedback.</p> -->
    <br>
    <!-- Browser Default Validation -->
    <form class="row g-3" method="post" action="#" enctype="multipart/form-data">
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">Dish Name</label>
            <input type="text" class="form-control" id="validationDefault01" name="dish-name" placeholder="Classic Cuisine Cafe" required>
        </div>


        <div class="col-md-4">
            <label for="validationDefaultUsername" class="form-label">Price</label>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend2">$</span>
                <input type="number" class="form-control" name="price" placeholder="000" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
            </div>
        </div>
        <div class="col-md-4">
            <label for="validationDefaultUsername" class="form-label">Taxes</label>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend2">$</span>
                <input type="number" class="form-control" name="taxes" placeholder="000" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
            </div>
        </div>

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
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['restaurant_name']; ?>
                        </option>
                <?php
                    }
                } else {
                    echo 'Error executing query: ' . mysqli_error($con);
                }
                ?>
            </select>
        </div>


        <?php
        // Include your database configuration file
        include "auth/config.php";

        // Assuming your table name is 'restaurants'
        $query = "SELECT id, category FROM category";
        $result = mysqli_query($con, $query);
        ?>
        <div class="col-md-3">
            <label for="validationDefault04" class="form-label">Category</label>
            <select class="form-select" name="category" id="validationDefault04" required>
                <option selected disabled value="">Choose...</option>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['category']; ?>
                        </option>
                <?php
                    }
                } else {
                    echo 'Error executing query: ' . mysqli_error($con);
                }
                ?>
            </select>
        </div>

        <?php
        // Include your database configuration file
        include "auth/config.php";

        // Assuming your table name is 'restaurants'
        $query = "SELECT id, menu_name FROM menu";
        $result = mysqli_query($con, $query);
        ?>
        <div class="col-md-3">
            <label for="validationDefault04" class="form-label">Menu</label>
            <select class="form-select" name="menu" id="validationDefault04" required>
                <option selected disabled value="">Choose...</option>
                <option value="">example</option>

                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['menu_name']; ?>
                        </option>
                <?php
                    }
                } else {
                    echo 'Error executing query: ' . mysqli_error($con);
                }
                ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="validationDefault05" class="form-label">Image</label>
            <input type="file" class="form-control" name="img" aria-describedby="inputGroupPrepend2" required>
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
    $dishname = $_POST['dish-name'];
    $price = $_POST['price'];
    $taxes = $_POST['taxes'];
    $restaurant = $_POST['restaurant'];
    $category  = $_POST['category'];
    $menu  = $_POST['menu'];
    $img = $_FILES['img']['name'];
    $description = $_POST['description'];


    // File upload handling
    $tmp_name = $_FILES['img']['tmp_name'];
    $path = "upload/" . $img;
    $path1 = "upload/" . $img;


    if (move_uploaded_file($tmp_name, $path)) {
        // File uploaded successfully, continue with database insertion
        // You should perform additional validation and sanitation on user input

        // Use prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($con, "INSERT INTO dishes (dish_name, price, taxes, restaurant, category, menu, img, description) VALUES (?, ? , ? , ? , ? ,? , ? , ?)");
        // Check if the prepare statement succeeded
        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $dishname, $price, $taxes, $restaurant, $category, $menu, $path1, $description);
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo '<script type="text/javascript">
                alert("Service added successfully");
                </script>';
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
    } else {
        echo '<script type="text/javascript">alert("Error uploading file");</script>';
    }

    // Close the database connection
    mysqli_close($con);
}
?>



</main>
<!-- End #main -->
<!-- footer -->
<?php
include "master/footer.php";
?>