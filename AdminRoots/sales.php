<?php
include 'Function/connection.php';  

if(empty($_SESSION["admin_id"])){
    header('Location:index.php');
}

$admin_id = $_SESSION['admin_id'];

// get admin info
$admin = "SELECT * FROM `admins` WHERE `admin_id` = '$admin_id';";
$adminResult = $mysqli->query($admin);

// get sales information
if($_SESSION['salesReport'] == 'on'){
    $salesReportDisplay = $_SESSION['salesReportNo'];
    $salesReportDisplayResult = $mysqli->query($salesReportDisplay);
}
else{
    $salesDisplay = "SELECT * FROM `product` WHERE `sales`!='0' ORDER BY `sales` DESC;";
    $salesDisplayResult = $mysqli->query($salesDisplay);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
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
                    <a href="sales.php" class="nav-active">• seller profits</a>
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
                <h2 class="page-heading">seller profits</h2>
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

            <form action="function/report.php" method="POST" class="report-date">
                <span>report date: </span>
                <label for="date1">from</label>
                <input type="date" name="date1" id="date1" onchange="this.closest('form').classList.add('apply-show');" required>
                <label for="date2">to</label>
                <input type="date" name="date2" id="date2" onchange="this.closest('form').classList.add('apply-show');" required>
                <input type="submit" value="apply" class="btn">
            </form>

            <div class="seller-profits">
                <table>
                    <tr>
                        <th>product</th>
                        <th>total orders</th>
                        <th>income value</th>
                        <th>total sales</th>
                        <th>category</th>
                    </tr>
                    <!-- DB DISPLAY !!!! -->

                    <?php
                    if($_SESSION['salesReport'] == 'on'){
                        while($rows=$salesReportDisplayResult->fetch_assoc()){
                                $product_id = $rows['product_id'];
                                $productSales = "SELECT * FROM `order` WHERE `product_id`='$product_id';";
                                $productSalesResult = $mysqli->query($productSales);
                                $sales = 0;
                                while($rowos=$productSalesResult->fetch_assoc()){
                                    $sales += $rowos['quantity'];
                                }
                                $productOrders = "SELECT * FROM `order` WHERE `product_id`='$product_id';";
                                $productOrdersResult = $mysqli->query($productOrders);
                                $orders = 0;
                                while($rowos=$productOrdersResult->fetch_assoc()){
                                    $orders += 1;
                                }
                            ?>
                                <tr>
                                    <td><img src="../GardenRoots/products/<?php echo $rows['product_image']; ?>"><?php echo $rows['product']; ?></td>
                                    <td><?php echo $orders; ?><span>orders</span></td>
                                    <td><?php echo $rows['discount'] * $sales; ?><span>income</span></td>
                                    <td><?php echo $sales; ?><span>sales</span></td>
                                    <td><?php echo $rows['category']; ?></td>
                                </tr>
                            <?php
                        }
                    }
                    else{
                        while($rows=$salesDisplayResult->fetch_assoc()){
                        ?>
                            <tr>
                                <td><img src="../GardenRoots/products/<?php echo $rows['product_image']; ?>"><?php echo $rows['product']; ?></td>
                                <td><?php echo $rows['ordered']; ?><span>orders</span></td>
                                <td><?php echo $rows['discount'] * $rows['sales']; ?><span>income</span></td>
                                <td><?php echo $rows['sales']; ?><span>sales</span></td>
                                <td><?php echo $rows['category']; ?></td>
                            </tr>
                        <?php
                        }
                    }
                    ?>

                    <!-- DB DISPLAY !!!! -->
                </table>
            </div>
        </section>
    </section>
    <?php
        $_SESSION['salesReport'] = 'off';
    ?>
    <script src="lib/script.js"></script>
</body>
</html>