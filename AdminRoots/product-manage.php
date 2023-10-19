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
$productDisplay = "SELECT * FROM `product`;";
$productDisplayResult = $mysqli->query($productDisplay);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
                    <a href="product-manage.php" class="nav-active">• manage products</a>
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
                    <a href="blogs.php">• blog</a>
                </div>
            </div>
        </section>
        <section class="main">
            <header>
                <h2 class="page-heading">manage products</h2>
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

            <div class="manage-product">
                <table>
                    <tr>
                        <th><i class="fa-solid fa-image"></i></th>
                        <th>product name</th>
                        <th>ID</th>
                        <th>list price</th>
                        <th>sale price</th>
                        <th>category</th>
                        <th>featured</th>
                        <th>remove</th>
                    </tr>
                    <!-- DB DISPLAY !!!! -->
                    <?php
                        while($rows=$productDisplayResult->fetch_assoc()){
                    ?>
                        <tr>
                            <td>
                                <form action="function/product-change.php" class="manage-form" method="POST" enctype="multipart/form-data">
                                    <label for="productIMG"><img src="../GardenRoots/products/<?php echo $rows['product_image']; ?>"></label>    
                                    <input type="file" accept="image/*" name="productIMG" id="productIMG" onchange="this.closest('form').submit()">
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id']; ?>">
                                    <input type="hidden" name="op" value="image">
                                </form>
                            </td>
                            <td>
                                <form action="function/product-change.php" class="manage-form" method="POST">
                                    <input type="text" name="name" value="<?php echo $rows['product'];?>" required maxlength="20" onchange="this.closest('form').classList.add('i-show')">
                                    <i onclick="this.closest('form').submit()" class="fa-solid fa-arrows-rotate"></i>
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id'];?>">
                                    <input type="hidden" name="op" value="name">
                                </form>
                            </td>
                            <td>
                                <input type="number" value="<?php echo $rows['product_id'];?>" required readonly>
                            </td>
                            <td>
                                <form action="function/product-change.php" class="manage-form" method="POST">
                                    <input type="text" name="price" value="<?php echo $rows['price']; ?>" required onchange="this.closest('form').classList.add('i-show')">
                                    <i onclick="this.closest('form').submit()" class="fa-solid fa-arrows-rotate"></i>
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id'];?>">
                                    <input type="hidden" name="op" value="price">
                                </form>
                            </td>
                            <td>
                                <form action="function/product-change.php" class="manage-form" method="POST">
                                    <input type="text" name="discount" value="<?php echo $rows['discount']; ?>" required onchange="this.closest('form').classList.add('i-show')">
                                    <i onclick="this.closest('form').submit()" class="fa-solid fa-arrows-rotate"></i>
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id'];?>">
                                    <input type="hidden" name="op" value="discount">
                                </form>
                            </td>
                            <td>
                                <form action="function/product-change.php" class="manage-form" method="POST">
                                    <select name="category" onchange="this.closest('form').submit()">
                                        <option value="fruits" <?php if($rows['category']== 'fruits')echo 'selected'; ?>>fruits</option>
                                        <option value="vegetables" <?php if($rows['category']== 'vegetables')echo 'selected'; ?>>vegetables</option>
                                        <option value="dairy" <?php if($rows['category']== 'dairy')echo 'selected'; ?>>dairy & eggs</option>
                                        <option value="spices" <?php if($rows['category']== 'spices')echo 'selected'; ?>>spices</option>
                                        <option value="grains" <?php if($rows['category']== 'grains')echo 'selected'; ?>>grains</option>
                                        <option value="bakery" <?php if($rows['category']== 'bakery')echo 'selected'; ?>>bakery</option>
                                    </select>
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id'];?>">
                                    <input type="hidden" name="op" value="category">
                                </form>
                            </td>
                            <td>
                                <form action="function/product-change.php" class="manage-form" method="POST">
                                    <input type="checkbox" name="featured" <?php if($rows['featured']== 1)echo 'checked'; ?> onchange="this.closest('form').submit()">
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id'];?>">
                                    <input type="hidden" name="op" value="featured">
                                </form>
                            </td>
                            <td>
                                <form action="function/product-change.php" class="manage-form" method="POST">
                                    <a onclick="this.closest('form').submit()" class="fa-solid fa-xmark"></a>
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id'];?>">
                                    <input type="hidden" name="op" value="remove">
                                </form>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    <!-- DB DISPLAY !!!! -->
                </table>
            </div>
        </section>
    </section>
    <script src="lib/script.js"></script>
</body>
</html>