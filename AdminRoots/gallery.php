<?php
include 'function/connection.php';  

if(empty($_SESSION["admin_id"])){
    header('Location:index.php');
}

$admin_id = $_SESSION['admin_id'];

// get admin info
$admin = "SELECT * FROM `admins` WHERE `admin_id` = '$admin_id';";
$adminResult = $mysqli->query($admin);

// get blog data
$galleryDisplay = "SELECT * FROM `users` INNER JOIN `gallery` ON users.user_id=gallery.admin_id;";
$galleryDisplayResult = $mysqli->query($galleryDisplay);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
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
                    <a href="product-add.php">• add new product</a>
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
                    <a href="gallery.php" class="nav-active">• gallery</a>
                    <a href="blogs.php">• blog</a>
                </div>
            </div>
        </section>
        <section class="main">
            <header>
                <h2 class="page-heading">gallery</h2>
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

            <div class="blogs">
                <div class="box-container">
                        <form class="box blog-add" action="function/gallery-change.php" method="POST" enctype="multipart/form-data">
                            <div class="image">
                                <input type="file" accept="image/*" name="gallery_image" id="gallery_image" style="display:none;" onchange="loadFile(event)">
                                <label for="gallery_image" id="form-add-label">add image</label>
                                <img src="" id="form-add-image">
                            </div>
                            <div class="gallery-submit">
                                <input type="hidden" name="op" value="add">
                                <input type="submit" value="add">
                            </div>
                        </form>
                    <!-- DB DISPLAY !!!! -->
                        <?php
                            while($rows=$galleryDisplayResult->fetch_assoc()){
                        ?>

                        <div class="box">
                            <div class="image">
                                <img src="../GardenRoots/gallery/<?php echo $rows['gallery_image']; ?>">
                            </div>
                            <div class="content gallery-content">
                                <div class="icons">
                                    <a href="#" class="blog-icon"> <i class="fas fa-calendar"></i> <?php echo $rows['date']; ?></a>
                                    <a href="#" class="blog-icon"> <i class="fas fa-user"></i> by <?php echo $rows['username']; ?></a>
                                </div>
                            </div>
                            <form action="function/gallery-change.php" method="post" class="gallery-form">
                                <input type="hidden" name="gallery_id" value="<?php echo $rows['gallery_id']; ?>">
                                <input type="hidden" name="op" value="remove">
                                <input type="submit" value="delete">
                            </form>
                        </div>
                        
                        <?php
                            }
                        ?>
                    <!-- DB DISPLAY !!!! -->
                </div>
            </div>
        </section>
    </section>
    <script src="lib/script.js"></script>
</body>
</html>