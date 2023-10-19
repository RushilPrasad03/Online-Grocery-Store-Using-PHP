<?php
include 'Function/connection.php';  

if(empty($_SESSION["admin_id"])){
    header('Location:index.php');
}

$admin_id = $_SESSION['admin_id'];

// get admin info
$admin = "SELECT * FROM `admins` WHERE `admin_id` = '$admin_id';";
$adminResult = $mysqli->query($admin);

// get blog data
$blogDisplay = "SELECT * FROM `users` INNER JOIN `blog` ON users.user_id=blog.admin_id;";
$blogDisplayResult = $mysqli->query($blogDisplay);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
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
                    <a href="gallery.php">• gallery</a>
                    <a href="blogs.php" class="nav-active">• blog</a>
                </div>
            </div>
        </section>
        <section class="main">
            <header>
                <h2 class="page-heading">blogs</h2>
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
                        <form class="box blog-add" action="function/blog-change.php" method="POST" enctype="multipart/form-data">
                            <div class="image">
                            <input type="file" accept="image/*" name="blog_image" id="blog_image" style="display:none;" onchange="loadFile(event)">
                                <label for="blog_image" id="form-add-label">add image</label>
                                <img src="" id="form-add-image">
                            </div>
                            <div class="content">
                                <input type="text" name="blog_title" class="heading" placeholder="Blog Title">
                                <textarea name="blog_data" rows="4" class="data" placeholder="Blog Description Goes Here..."></textarea>
                            </div>
                            <div>
                                <input type="hidden" name="op" value="add">
                                <input type="submit" value="add">
                            </div>
                        </form>
                    <!-- DB DISPLAY !!!! -->
                        <?php
                            while($rows=$blogDisplayResult->fetch_assoc()){
                        ?>

                        <div class="box">
                            <div class="image">
                                <img src="../GardenRoots/blogs/<?php echo $rows['blog_image']; ?>">
                            </div>
                            <div class="content">
                                <div class="icons">
                                    <a href="#" class="blog-icon"> <i class="fas fa-calendar"></i> <?php echo $rows['date']; ?></a>
                                    <a href="#" class="blog-icon"> <i class="fas fa-user"></i> by <?php echo $rows['username']; ?></a>
                                </div>
                                <h3><?php echo $rows['blog_title']; ?></h3>
                                <p><?php echo $rows['blog_data']; ?></p>
                            </div>
                            <form action="function/blog-change.php" method="post">
                                <input type="hidden" name="blog_id" value="<?php echo $rows['blog_id']; ?>">
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