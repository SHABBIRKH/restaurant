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
        <h1>Edit Dishes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item">Dishes List</li>
                <li class="breadcrumb-item active">Edit Dishes</li>
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
        $sql = "SELECT * FROM dishes WHERE id='$id'";
        $rs = mysqli_query($con, $sql);

        // Check if the service exists
        if ($result = mysqli_fetch_array($rs)) {
            $dish_name = $result['dish_name'];
            $price = $result['price'];
            $taxes = $result['taxes'];
            $restaurant = $result['restaurant'];
            $category = $result['category'];
            $menu = $result['menu'];
            $description = $result['description'];
        } else {
            echo "Service not found";
            exit();
        }
    } else {
        echo "Invalid request";
        exit();
    }
    ?>

    <!--end -->


    <h5 class="card-title">Edit Dishes</h5>
    <!-- <p>Browser default validation with using the <code>required</code> keyword. Try submitting the form below. Depending on your browser and OS, you’ll see a slightly different style of feedback.</p> -->
    <br>
    <!-- Browser Default Validation -->
    <form class="row g-3" method="post" action="#" enctype="multipart/form-data">
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">Dish Name</label>
            <input type="text" class="form-control" id="validationDefault01" name="dish-name" value="<?php echo $dish_name; ?>" placeholder="Classic Cuisine Cafe" required>
        </div>


        <div class="col-md-4">
            <label for="validationDefaultUsername" class="form-label">Price</label>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend2">$</span>
                <input type="number" class="form-control" name="price" value="<?php echo $price; ?>" placeholder="000" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
            </div>
        </div>
        <div class="col-md-4">
            <label for="validationDefaultUsername" class="form-label">Taxes</label>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend2">$</span>
                <input type="number" class="form-control" name="taxes" value="<?php echo $taxes; ?>" placeholder="000" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
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
            <select class="form-select" name="restaurant" value="<?php echo $restaurant; ?>" id="validationDefault04" required>
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
            <select class="form-select" name="category" value="<?php echo $category; ?>" id="validationDefault04" required>
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
            <select class="form-select" name="menu" value="<?php echo $menu; ?>" id="validationDefault04" required>
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
            <textarea class="form-control" style="height: 100px" name="description" value="<?php echo $description; ?>" placeholder="A restaurant website is an online platform that showcases a dining establishment's menu, ambiance and services." required></textarea>
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
            $sql = "UPDATE dishes SET dish_name='$dishname', price='$price', taxes='$taxes', restaurant='$restaurant', category='$category', menu='$menu', img='$path1', description='$description'  WHERE id=$id";
            // Check if the prepare statement succeeded
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "<script type='text/javascript'>alert('edit'); 
                window.location.href = 'dishes-list.php'; 
                </script>";
            } else {
                echo "<script>alert('not edited');
        </script>";
            }
        }
    }

    ?>


</main>
<!-- End #main -->
<!-- footer -->
<?php
include "master/footer.php";
?>