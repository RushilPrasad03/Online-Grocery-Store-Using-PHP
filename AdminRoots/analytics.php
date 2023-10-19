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
$orders = "SELECT * FROM `order` WHERE `status` = 'pending' GROUP BY(order_set);";
$ordersResult = $mysqli->query($orders);
$orderNo = mysqli_num_rows($ordersResult);

$products = "SELECT * FROM `product`;";
$productsResult = $mysqli->query($products);
$productNo = mysqli_num_rows($productsResult);

$sales = "SELECT * FROM `product`;";
$salesResult = $mysqli->query($sales);

$salesNo = 0;
while($rows=$salesResult->fetch_assoc()){
    $salesNo += $rows['sales'];
}

$customer = "SELECT * FROM `users`;";
$customerResult = $mysqli->query($customer);
$customerNo = mysqli_num_rows($customerResult);

$revenue = "SELECT * FROM `product`;";
$revenueResult = $mysqli->query($revenue);

$revenueNo = 0;
while($rows=$revenueResult->fetch_assoc()){
    $revenueNo += ($rows['sales'] * $rows['discount']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
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
                    <a href="analytics.php" class="nav-active">• sales analytics</a>
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
                    <a href="blogs.php">• blog</a>
                </div>
            </div>
        </section>
        <section class="main">
            <header>
                <h2 class="page-heading">sales analytics</h2>
                
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

            <div class="analytics">
                <div class="dashboard">
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $orderNo?></p>
                            <span>new order<?php if($orderNo!=1){echo "s";}?></span>
                        </h3>
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $productNo?></p>
                            <span>products</span>
                        </h3>
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $salesNo?></p>
                            <span>sales made</span>
                        </h3>
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $customerNo?></p>
                            <span>customers</span>
                        </h3>
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                <div class="profit">
                    <img src="images/sales.png">
                    <h3 class="profit-info">
                        <p>₹ <?php echo $revenueNo?></p>
                        <span>total revenue</span>
                    </h3>
                </div>
            </div>
        </section>
    </section>
    <script src="lib/script.js"></script>
</body>
</html>