<?php
include 'Function/connection.php';  

if(empty($_SESSION["admin_id"])){
    header('Location:index.php');
}

$admin_id = $_SESSION['admin_id'];

// get admin info
$admin = "SELECT * FROM `admins` WHERE `admin_id` = '$admin_id';";
$adminResult = $mysqli->query($admin);

// get customer
$customerDisplay = "SELECT * FROM `users`;";
$customerDisplayResult = $mysqli->query($customerDisplay);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
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
                    <a href="customers.php" class="nav-active">• customers</a>
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
                <h2 class="page-heading">customers</h2>
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

            <div class="customers">
                <table>
                    <tr>
                        <th><i class="fa-solid fa-circle-user"></i></th>
                        <th>customer</th>
                        <th>contact no</th>
                        <th colspan="3">addresses</th>
                        <th>action</th>
                    </tr>
                    
                    <!-- DB DISPLAY !!!! -->
                    <?php
                        while($rows=$customerDisplayResult->fetch_assoc()){
                    ?>
                        <tr>
                            <td><img src="../GardenRoots/pfp/<?php echo $rows['profile_pic']; ?>"></td>
                            <td>
                                <div class="review-name">
                                    <h3><?php echo $rows['username']; ?></h3>
                                    <h4><?php echo $rows['email']; ?></h4>
                                </div>
                            </td>
                            <td>
                            <?php echo $rows['phone']; ?>
                            </td>
                            <td>
                                <p><?php echo $rows['add1']; ?></p>
                            </td>
                            <td>
                                <p><?php echo $rows['add2']; ?></p>
                            </td>
                            <td>
                                <p><?php echo $rows['add3']; ?></p>
                            </td>
                            <td>
                                <form action="function/customer-remove.php" method="post">
                                    <a onclick="this.closest('form').submit()">remove</a>
                                    <input type="hidden" name="user_id" value="<?php echo $rows['user_id']; ?>">
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