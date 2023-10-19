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

// get star rating
$ratingDisplay1 = "SELECT * FROM `review` WHERE `rating`='1';";
$rating1Result = $mysqli->query($ratingDisplay1);
$ratingP1 = mysqli_num_rows($rating1Result);

$ratingDisplay2 = "SELECT * FROM `review` WHERE `rating`='2';";
$rating2Result = $mysqli->query($ratingDisplay2);
$ratingP2 = mysqli_num_rows($rating2Result);

$ratingDisplay3 = "SELECT * FROM `review` WHERE `rating`='3';";
$rating3Result = $mysqli->query($ratingDisplay3);
$ratingP3 = mysqli_num_rows($rating3Result);

$ratingDisplay4 = "SELECT * FROM `review` WHERE `rating`='4';";
$rating4Result = $mysqli->query($ratingDisplay4);
$ratingP4 = mysqli_num_rows($rating4Result);

$ratingDisplay5 = "SELECT * FROM `review` WHERE `rating`='5';";
$rating5Result = $mysqli->query($ratingDisplay5);
$ratingP5 = mysqli_num_rows($rating5Result);

$total = "SELECT * FROM `review`";
$totalResult = $mysqli->query($total);
$total = mysqli_num_rows($totalResult);

$rating1 = intval(($ratingP1/$total)*100);
$rating2 = intval(($ratingP2/$total)*100);
$rating3 = intval(($ratingP3/$total)*100);
$rating4 = intval(($ratingP4/$total)*100);
$rating5 = intval(($ratingP5/$total)*100);

$avg = 0;
$score = 0;

// get average rating
$average = "SELECT * FROM `review`";
$averageResult = $mysqli->query($average);

while($rows=$averageResult->fetch_assoc()){
    $avg += $rows['rating'];
    $score += $rows['rating'];
}
$avg /= $total;
$avgFlag = $avg;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
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
                    <a href="reviews.php" class="nav-active">• reviews</a>
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
                <h2 class="page-heading">reviews</h2>
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

            <div class="reviews">
                <div class="review-dashboard">
                    <div class="review-box">
                        <div>
                            <?php
                                for($i=0; $i<5; $i++){
                                    if($i>$avg){
                                        ?>
                                        <i class="far fa-star"></i>
                                        <?php
                                    }
                                    else if($avgFlag > 0 && $avgFlag < 1){
                                        ?>
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <i class="fas fa-star"></i>
                                        <?php
                                        $avgFlag-=1;
                                    }
                                }
                            ?>
                        </div>
                        <h3><?php echo number_format($avg, 1)?></h3>
                        <span>review score</span>
                    </div>
                    <div class="review-box">
                        <i class="fa-solid fa-users"></i>
                        <h3><?php echo $score?>/<?php echo $total * 5?></h3>
                        <span>customer score</span>
                    </div>
                    <div class="review-box">
                        <i class="fa-solid fa-user-plus"></i>
                        <h3>25%</h3>
                        <span>new customers</span>
                    </div>
                    <div class="review-box">
                        <i class="fa-solid fa-user-group"></i>
                        <h3>75%</h3>
                        <span>regular customers</span>
                    </div>

                    <div class="rating">
                        <div class="rating-bar">
                            <h3>5<i class="fa-solid fa-star"></i></h3>
                            <p id="starbar5"></p>
                            <span id="star5"><?php echo $rating5?>%</span>
                        </div>
                        <div class="rating-bar">
                            <h3>4<i class="fa-solid fa-star"></i></h3>
                            <p id="starbar4"></p>
                            <span id="star4"><?php echo $rating4?>%</span>
                        </div>
                        <div class="rating-bar">
                            <h3>3<i class="fa-solid fa-star"></i></h3>
                            <p id="starbar3"></p>
                            <span id="star3"><?php echo $rating3?>%</span>
                        </div>
                        <div class="rating-bar">
                            <h3>2<i class="fa-solid fa-star"></i></h3>
                            <p id="starbar2"></p>
                            <span id="star2"><?php echo $rating2?>%</span>
                        </div>
                        <div class="rating-bar">
                            <h3>1<i class="fa-solid fa-star"></i></h3>
                            <p id="starbar1"></p>
                            <span id="star1"><?php echo $rating1?>%</span>
                        </div>
                    </div>
                </div>

                <div class="review-table">
                    <table>
                        <tr>
                            <th colspan="5">latest reviews</th>
                        </tr>

                        <!-- DB DISPLAY !!!! -->
                        <?php
                            while($rows=$reviewDisplayResult->fetch_assoc()){
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
                                <?php 
                                    $rating = $rows['rating'];
                                    for($i=0; $i<5; $i++){
                                        if($i<$rating){
                                            ?>
                                            <i class="fas fa-star"></i>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <i class="far fa-star"></i>
                                            <?php
                                        }
                                    }
                                ?>
                                </td>
                                <td>
                                    <p><?php echo $rows['review']; ?></p>
                                </td>
                                <td>
                                    <form action="function/review-remove.php" method="post">
                                        <a onclick="this.closest('form').submit()">remove</a>
                                        <input type="hidden" name="review_id" value="<?php echo $rows['review_id']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                        <!-- DB DISPLAY !!!! -->
                    </table>
                </div>
            </div>
        </section>
    </section>
    <script src="lib/script.js"></script>
</body>
</html>