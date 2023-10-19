<?php
include 'Function/connection.php';  

if(empty($_SESSION["admin_id"])){
    header('Location:index.php');
}

$admin_id = $_SESSION['admin_id'];

// get admin info
$admin = "SELECT * FROM `admins` WHERE `admin_id` = '$admin_id';";
$adminResult = $mysqli->query($admin);

// get orders
$orderDisplay = "SELECT * FROM `order` LEFT JOIN `users` ON order.user_id=users.user_id GROUP BY(order_set) ORDER BY `date`;";
$orderDisplayResult = $mysqli->query($orderDisplay);

// get order views
if($_SESSION['orderReport'] == 'on'){
    $order_report_no = $_SESSION['orderReportNo'];
    $orderSetDisplay = "SELECT * FROM `order` INNER JOIN `product` ON product.product_id=order.product_id WHERE `order_set`='$order_report_no';";
    $orderSetDisplayResult = $mysqli->query($orderSetDisplay);

    $orderSetDisplay2 = "SELECT * FROM `order` INNER JOIN `product` ON product.product_id=order.product_id WHERE `order_set`='$order_report_no' GROUP BY(order_set) ORDER BY `date`;";
    $orderSetDisplayResult2 = $mysqli->query($orderSetDisplay2);
}

// get delivered
$deliveredDisplay = "SELECT DISTINCT `order_set`, `status` FROM `order` WHERE `status`='delivered';";
$deliveredDisplayResult = $mysqli->query($deliveredDisplay);
$delivered = mysqli_num_rows($deliveredDisplayResult);

// get confirmed
$confirmedDisplay = "SELECT DISTINCT `order_set`, `status` FROM `order` WHERE `status`!='pending';";
$confirmedDisplayResult = $mysqli->query($confirmedDisplay);
$confirmed = mysqli_num_rows($confirmedDisplayResult);

// get delivering
$deliveringDisplay = "SELECT DISTINCT `order_set`, `status` FROM `order` WHERE `status`='on delivery';";
$deliveringDisplayResult = $mysqli->query($deliveringDisplay);
$delivering = mysqli_num_rows($deliveringDisplayResult);

// get cancelled
$cancelDisplay = "SELECT DISTINCT `order_set`, `status` FROM `order` WHERE `status`='canceled';";
$cancelDisplayResult = $mysqli->query($cancelDisplay);
$cancelled = mysqli_num_rows($cancelDisplayResult);

// get total
$total = "SELECT DISTINCT `order_set` FROM `order`";
$totalResult = $mysqli->query($total);
$total = mysqli_num_rows($totalResult);

$perc1 = intval(($delivered/$total)*100);
$perc2 = intval(($confirmed/$total)*100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
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
                    <a href="orders.php" class="nav-active">• orders</a>
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
                <h2 class="page-heading">orders</h2>
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

            <div class="orders">
                <div class="graph">
                    <h3>completion rate</h3>
                    <div class="graph-data">
                        <div class="graph-info">
                            <h4>orders completion</h4>
                            <p id="oComp"></p>
                        </div>
                        <span id="oCompValue"><?php echo $perc1?>%</span>
                    </div>
                    <div class="graph-data">
                        <div class="graph-info">
                            <h4>orders confirmed</h4>
                            <p id="oConf"></p>
                        </div>
                        <span id="oConfValue"><?php echo $perc2?>%</span>
                    </div>
                </div>
                <div class="dashboard">
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $delivered?></p>
                            <span>completed</span>
                        </h3>
                        <i class="fa-solid fa-square-check"></i>
                    </div>
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $confirmed?></p>
                            <span>confirmed</span>
                        </h3>
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $delivering?></p>
                            <span>on delivery</span>
                        </h3>
                        <i class="fa-solid fa-dolly"></i>
                    </div>
                    <div class="data">
                        <h3 class="data-info">
                            <p><?php echo $cancelled?></p>
                            <span>cancelled</span>
                        </h3>
                        <i class="fa-solid fa-square-xmark"></i>
                    </div>
                </div>
            </div>
            <div class="order-table">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>customer</th>
                        <th>products</th>
                        <th>total</th>
                        <th>order status</th>
                        <th>method</th>
                        <th>date</th>
                        <th>action</th>
                    </tr>

                    <!-- DB DISPLAY !!!! -->
                        <?php
                            while($rows=$orderDisplayResult->fetch_assoc()){
                                $order_set = $rows['order_set'];
                                $orderCount = "SELECT * FROM `order` WHERE `order_set`='$order_set';";
                                $orderCountResult = $mysqli->query($orderCount);
                        ?>
                        <tr>
                            <td>#<?php echo $rows['order_set']; ?></td>
                            <td><?php echo $rows['username']; ?></td>
                            <td><?php echo mysqli_num_rows($orderCountResult);?> items</td>
                            <td><?php echo $rows['total']; ?></td>
                            <td>
                                <form action="function/order-change.php" method="post">
                                    <select name="status" <?php if($rows['status']== 'refund')echo 'disabled'; ?> onchange="this.closest('form').submit()">
                                        <?php
                                            if($rows['status'] !='refund'){
                                                ?>
                                                    <option value="pending" <?php if($rows['status']== 'pending')echo 'selected'; ?>>pending</option>
                                                    <option value="confirmed" <?php if($rows['status']== 'confirmed')echo 'selected'; ?>>confirmed</option>
                                                    <option value="on delivery" <?php if($rows['status']== 'on delivery')echo 'selected'; ?>>on delivery</option>
                                                    <option value="delivered" <?php if($rows['status']== 'delivered')echo 'selected'; ?>>delivered</option>
                                                    <option value="canceled" <?php if($rows['status']== 'canceled')echo 'selected'; ?>>canceled</option>
                                                <?php
                                            }
                                            else if($rows['status'] =='refund'){
                                                ?>
                                                    <option value="refund" selected>refund</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" name="orderSet" value="<?php echo $rows['order_set']; ?>">
                                </form>
                            </td>
                            <td><?php echo $rows['payment_method']; ?></td>
                            <td><?php echo $rows['date']; ?></td>
                            <td>
                                <form action="function/order-view.php" method="post">
                                    <input type="hidden" name="orderReportNo" value="<?php echo $rows['order_set']?>">
                                    <a onclick = "this.closest('form').submit()">view</a>
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
    <?php
        if($_SESSION['orderReport'] == 'on'){
    ?>
    <div class="order-overlay
    <?php if($_SESSION['orderReport'] == 'on'){echo 'order-overlay-active';}?>">
        <div class="order-container">
            <form action="function/refund.php" class="order-display">
                <table onscroll="disableScrolling()" onmousewheel="enableScrolling()" onmouseout="disableScrolling()" onmousemove="enableScrolling()">
                    <tr>
                        <th colspan="2">product</th>
                        <th>unit price</th>
                        <th>quantity</th>
                        <th>total</th>
                    </tr>
                    <!-- DB DISPLAY !!!! -->
                        <?php
                            while($rows=$orderSetDisplayResult->fetch_assoc()){
                        ?>

                        <tr>
                            <td class="cart-table-data"><img src="../GardenRoots/products/<?php echo $rows['product_image']; ?>"></td>
                            <td class="cart-table-data"><?php echo $rows['product']; ?></td>
                            <td class="cart-table-data">₹<?php echo $rows['discount']; ?></td>
                            <td class="cart-table-data"><?php echo $rows['quantity']; ?></td>
                            <td class="cart-table-data">₹<?php echo ($rows['discount'] * $rows['quantity']); ?></td>
                        </tr>

                        <?php
                            }
                        ?>
                    <!-- DB DISPLAY !!!! -->
                </table>
                <div class="cart-total">
                    <!-- DB DISPLAY !!!! -->
                    <?php
                        while($rows=$orderSetDisplayResult2->fetch_assoc()){
                    ?>
                    <span>
                        delivery address : 
                    </span>
                    <textarea id="address-display" rows="4" maxlength="100" disabled><?php echo $rows['address']; ?></textarea>
                    <div class="total-calc">
                        <p class="total-display">order status: <span><?php echo $rows['status']; ?></span></p>
                    </div>
                    <div class="total-calc">
                        <p class="total-display">total: <span>₹<?php echo $rows['total']; ?></span></p>
                    </div>
                    <?php
                        if($rows['status']=='canceled' || $rows['status']=='refund' && $rows['payment_method']!='cash on delivery'){
                    ?>
                        <input type="submit" value="refund order" class="btn">
                        <input type="hidden" name="paymentType" value="refund">
                    <?php
                        }
                        else if($rows['status']=='canceled' || $rows['status']=='refund' && $rows['payment_method']=='cash on delivery'){
                    ?>
                        <input type="submit" value="delete order" class="btn">
                        <input type="hidden" name="paymentType" value="cash">
                    <?php
                        }
                    ?>
                    <?php
                            }
                        ?>
                    <!-- DB DISPLAY !!!! -->
                </div>
                <a class="order-close-btn" onclick="document.querySelector('.order-overlay').classList.remove('order-overlay-active')">close</a>
            </form>
        </div>
    </div>
    <?php
        }
    $_SESSION['orderReport'] = 'off';
    ?>
    <script src="lib/script.js"></script>
</body>
</html>