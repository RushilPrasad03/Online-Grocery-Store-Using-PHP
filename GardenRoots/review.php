<?php
include 'Function/connection.php';  

if($_SESSION["user_id"]==null){
    $_SESSION["user_id"]="0";
}
$user_id=$_SESSION["user_id"];

// get cart products
$cartDisplay = "SELECT * FROM `product` INNER JOIN `cart` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
$cartDisplayResult = $mysqli->query($cartDisplay);

// get reviews
$reviewDisplay = "SELECT * FROM `users` INNER JOIN `review` ON users.user_id=review.user_id;";
$reviewDisplayResult = $mysqli->query($reviewDisplay);

// check user review
$reviewUserDisplay = "SELECT * FROM `review` WHERE `user_id`='$user_id'";
$reviewUserDisplayResult = $mysqli->query($reviewUserDisplay);

//cart total
$cartTotal = "SELECT * FROM `cart` INNER JOIN `product` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
$cartTotalResult = $mysqli->query($cartTotal);
$subtotal = 0;

while($rows=$cartTotalResult->fetch_assoc()){
    $subtotal += $rows['discount']*$rows['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="lib/style.css">
</head>
<body>

    <!-- header section starts -->
    <header class="header">
        <a href="" class="logo">
            <img src="images/icon.png">
            GardenRoots
        </a>

        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="shop.php">shop</a>
            <a href="about.php">about</a>
            <a href="review.php">review</a>
            <a href="blog.php">blog</a>
            <a href="contact.php">contact</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="cart-btn" class="fas fa-shopping-cart"></div>
        <?php
            if($_SESSION["user_id"]=="0"){
                ?><div id="login-btn" class="fas fa-user"></div><?php
            }
            else{
                ?><div onclick="location.href='account.php'" class="fas fa-user"></div><?php
            }
        ?>
        </div>
        
        <form action="search.php" class="search-form">
            <input type="search" placeholder="Search Here..." name="search" id="search-box" pattern="[A-Za-z]+" required maxlength="20">
            <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="shopping-cart">
            <div class="cart-overflow">
                <!-- DB DISPLAY !!!! -->
                <?php
                    while($rows=$cartDisplayResult->fetch_assoc()){
                ?>
                    <form action="function/cart-change.php" method="POST" class="box">
                        <a onclick="this.closest('form').submit()" class="fas fa-times"></a>
                        <input type="hidden" name="op" value="remove">
                        <input type="hidden" name="product" value="<?php echo $rows['product_id']; ?>">
                        <img src="products/<?php echo $rows['product_image']; ?>">
                        <div class="content">
                            <h3><?php echo $rows['product']; ?></h3>
                            <span class="quantity"><?php echo $rows['quantity']; ?></span>
                            <span class="multiply">x</span>
                            <span class="price">₹<?php echo $rows['discount']; ?></span>
                        </div>
                    </form>
                <?php
                    }
                ?>
                <!-- DB DISPLAY !!!! -->
            </div>
            <h3 class="total">subtotal : <span>₹<?php echo $subtotal;?></span></h3>
            <?php
                if($user_id !=0){
                    echo'<a href="cart.php" class="btn">checkout cart</a>';
                }
                else{
                    echo'<a onclick="alert(`You Need To Login First !!`)" class="btn">checkout cart</a>';
                }
            ?>
        </div>

        <form action="function/login.php" method="POST" class="login-form">
            <h3>login</h3>
            <input type="text" placeholder="Username" name="username" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <input type="password" placeholder="Password" name="password" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <div class="remember">
                <input type="checkbox" name="remember" id="login-remember-me">
                <label for="login-remember-me">remember me</label>
            </div>
            <input type="hidden" name="op" value="login">
            <input type="submit" value="Log In" class="btn">
            <p class="login-func">forgot password? <a href="#">click here</a></p>
            <p class="login-func">don't have an account? <a id="register-btn">create one</a></p>
        </form>

        <form action="function/login.php" method="POST" class="register-form">
            <h3>register</h3>
            <input type="text" placeholder="Username" name="username" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <input type="password" placeholder="Password" name="password" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <input type="email" placeholder="Email ID" name="email" class="box" required maxlength="50">
            <input type="number" placeholder="Phone No" name="phone" class="box" required maxlength="10">
            <div class="remember">
                <input type="checkbox" name="remember" id="register-remember-me">
                <label for="register-remember-me">remember me</label>
            </div>
            <input type="hidden" name="op" value="register">
            <input type="submit" value="Sign Up" class="btn">
            <p class="login-func">already a user? <a id="register-close-btn">login</a></p>
        </form>
    </header>
    <!-- header section ends -->

    <!-- reivew section starts -->
    <div class="heading">
        <h1>client reviews</h1>
        <p class="heading-url"><a href="index.php">home </a>>> review </p>
    </div>
    <section class="info-container">
        <div class="info">
            <img src="images/feature-1.png">
            <div class="content">
                <h3>fast delivery</h3>
                <span>within 30 minutes</span>
            </div>
        </div>
        <div class="info">
            <img src="images/feature-2.png">
            <div class="content">
                <h3>24 / 7 availability</h3>
                <span>call us any time</span>
            </div>
        </div>
        <div class="info">
            <img src="images/feature-3.png">
            <div class="content">
                <h3>easy payments</h3>
                <span>cash or credits</span>
            </div>
        </div>
    </section>

    <section class="review">

        <?php
            if(mysqli_num_rows($reviewUserDisplayResult) == 0 && $user_id != '00'){
        ?>
        <form action="function/review-change.php" method="POST" class="box review-form add">
            <div class="user">
                <div class="info">
                    <span>
                        <i class="far fa-star" id="s1" onclick="rate(this.id);"></i>
                        <i class="far fa-star" id="s2" onclick="rate(this.id);"></i>
                        <i class="far fa-star" id="s3" onclick="rate(this.id);"></i>
                        <i class="far fa-star" id="s4" onclick="rate(this.id);"></i>
                        <i class="far fa-star" id="s5" onclick="rate(this.id);"></i>
                    </span>
                </div>
            </div>
            <textarea name="reviewDesc" maxlength="225" required></textarea>
            <input type="hidden" name="rating" id="rating" required>
            <input type="submit" value="add" name="op" class="btn">
            <div class="overlay"><i class="fa-solid fa-plus" onclick="this.closest('form').classList.remove('add')"></i></div>
        </form>
        <?php
            }
        ?>

        <!-- DB DISPLAY !!!! -->
            <?php
                while($rows=$reviewDisplayResult->fetch_assoc()){
            ?>

        <?php 
            if($rows['user_id'] == $user_id){
        ?>
            <form action="function/review-change.php" method="POST" class="box">
                <div class="user">
                    <img src="pfp/<?php echo $rows['profile_pic']; ?>">
                    <div class="info">
                        <h3><?php echo $rows['username']; ?></h3>
                        <span>
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
                        </span>
                    </div>
                </div>
                <p><?php echo $rows['review']; ?></p>
                <div class="delete-overlay">
                    <input type="hidden" name="op" value="remove">
                    <i class="fa-solid fa-ban" onclick="this.closest('form').submit()"></i>
                </div>
            </form>
        <?php
            }
            else{
        ?>
            <div class="box">
                <div class="user">
                    <img src="pfp/<?php echo $rows['profile_pic']; ?>">
                    <div class="info">
                        <h3><?php echo $rows['username']; ?></h3>
                        <span>
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
                        </span>
                    </div>
                </div>
                <p><?php echo $rows['review']; ?></p>
            </div>
        <?php 
            }
        ?>
            <?php
                }
            ?>
        <!-- DB DISPLAY !!!! -->
    </section>
    <!-- reivew section ends -->

    <!-- footer section starts -->
    <footer class="footer">
        <div class="box-container">
            <div class="box">
                <h3>quick links</h3>
                <a href="index.php"><i class=" footer-arrow fas fa-arrow-right"></i> index</a>
                <a href="shop.php"><i class=" footer-arrow fas fa-arrow-right"></i> shop</a>
                <a href="about.php"><i class=" footer-arrow fas fa-arrow-right"></i> about</a>
                <a href="review.php"><i class=" footer-arrow fas fa-arrow-right"></i> review</a>
                <a href="blog.php"><i class=" footer-arrow fas fa-arrow-right"></i> blog</a>
                <a href="contact.php"><i class=" footer-arrow fas fa-arrow-right"></i> contact</a>
            </div>

            <div class="box">
                <h3>extra links</h3>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>orders</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>favorites</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>wishlist</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>account</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>terms and policies</a>
            </div>

            <div class="box">
                <h3>follow us</h3>
                <a><i class=" footer-arrow fab fa-facebook-f"></i>facebook</a>
                <a><i class=" footer-arrow fab fa-twitter"></i>twitter</a>
                <a><i class=" footer-arrow fab fa-instagram"></i>instagram</a>
                <a><i class=" footer-arrow fab fa-linkedin"></i>linkedin</a>
                <a><i class=" footer-arrow fab fa-twitter"></i>twitter</a>
            </div>

            <div class="box">
                <h3>newsletter</h3>
                <p>subscribe for latest updates</p>
                <form action="" class="newsletter">
                    <input type="email" placeholder="Enter Your Email" name="newsletterMail" >
                    <input type="submit" value="subscribe" class="btn">
                </form>
            </div>
        </div>
    </footer>
    <div class="border"></div>

    <!-- footer section ends -->
    <?php
    if($_SESSION['cart']=='on'){
        echo "<script>document.querySelector('.shopping-cart').classList.add('cart-active');</script>";
        $_SESSION['cart']='off';
    }
    
    if($_SESSION['login']=='on'){
        echo "<script>document.querySelector('.login-form').classList.add('login-active');</script>";
        echo "<script>setTimeout(() => {alert('Username Or Password Incorrect');}, 500);</script>";
        $_SESSION['login']='off';
    }
    
    if($_SESSION['register']=='on'){
        echo "<script>document.querySelector('.register-form').classList.add('login-active');</script>";
        echo "<script>setTimeout(() => {alert('Username Already Taken');}, 500);</script>";
        $_SESSION['register']='off';
    }
    ?>
    <script src="lib/script.js"></script>
</body>
</html>