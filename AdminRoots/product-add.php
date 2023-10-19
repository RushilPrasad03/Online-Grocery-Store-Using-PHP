<?php
include 'Function/connection.php';  

if(empty($_SESSION["admin_id"])){
    header('Location:index.php');
}

$admin_id = $_SESSION['admin_id'];

// get admin info
$admin = "SELECT * FROM `admins` WHERE `admin_id` = '$admin_id';";
$adminResult = $mysqli->query($admin);

// get reviews
$reviewDisplay = "SELECT * FROM `review` INNER JOIN `users` ON review.user_id=users.user_id;";
$reviewDisplayResult = $mysqli->query($reviewDisplay);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="lib/style.css">
</head>
<body>
    <section class="body">
        <section class="navbar">
            <h2 class="logo">
                <img src="images/icon.png">
                gardenRoots
            </h2>
            <div class="navigation">
                <div class="nav-heading">
                    <h3><i class="fa-solid fa-chalkboard-user"></i> dashboard</h3>
                    <a href="analytics.php">• sales analytics</a>
                    <a href="sales.php">• seller profits</a>
                </div>
                <div class="nav-heading">
                    <h3><i class="fa-solid fa-boxes-stacked"></i> products</h3>
                    <a href="product.php">• product grid</a>
                    <a href="product-manage.php">• manage products</a>
                    <a href="product-add.php" class="nav-active">• add new product</a>
                </div>
                <div class="nav-heading">
                    <h3><i class="fa-solid fa-cart-shopping"></i> orders</h3>
                    <a href="orders.php">• orders</a>
                </div>
                <div class="nav-heading">
                    <h3><i class="fa-solid fa-users"></i> customer</h3>
                    <a href="customers.php">• customers</a>
                    <a href="reviews.php">• reviews</a>
                </div>
                <div class="nav-heading">
                    <h3><i class="fa-solid fa-server"></i> about</h3>
                    <a href="gallery.php">• gallery</a>
                    <a href="blogs.php">• blog</a>
                </div>
            </div>
        </section>
        <section class="main">
            <header>
                <h2 class="page-heading">add new product</h2>
                <div class="admin-display">
                    <img src="images/default.png">

                    <div class="admin-info">

                        <?php
                        while($rows=$adminResult->fetch_assoc()){
                            echo "<h3>".$rows['username']."</h3>";
                            echo "<p>".$rows['email']."</p>";
                        }
                        ?>

                    </div>
                    <a href="function/logout.php" class="btn">logout</a>
                </div>
            </header>

            <div class="product-add">
                <form action="function/add-item.php" method="post" class="product-from" enctype="multipart/form-data">
                    <div class="image">
                        <input type="file" name="image" accept="image/*" id="p-img" onchange="loadFile(event)" required>
                        <label for="p-img" id="form-add-label">add image</label>
                        <img src="" id="form-add-image">
                    </div>
                    <div class="content">
                        <div class="input-container">
                            <label for="p-name">product name</label>
                            <input type="text" name="product" id="p-name" required maxlength="20">
                        </div>
                        <div class="input-container">
                            <label for="price">list price</label>
                            <input type="text" name="price" id="price" required maxlength="3">
                        </div>
                        <div class="input-container">
                            <label for="discount">retail price</label>
                            <input type="text" name="discount" id="discount" required maxlength="3">
                        </div>
                        <select name="category" required>
                            <option value="fruits">fruits</option>
                            <option value="vegetables">vegetables</option>
                            <option value="dairy">dairy & eggs</option>
                            <option value="spices">spices</option>
                            <option value="grains">grains</option>
                            <option value="bakery">bakery</option>
                        </select>
                        <input type="submit" value="add product" class="btn">
                    </div>
                </form>
            </div>
        </section>
    </section>
    <script src="lib/script.js"></script>
</body>
</html>