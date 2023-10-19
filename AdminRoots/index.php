<?php
if(empty($_SESSION["login"])){
    $_SESSION["login"]="login";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="lib/style.css">
</head>
<body>
    <section class="login">
        <form action="function/login.php" method="post">
            <h3>welcome</h3>
            <div class="logo"><img src="images/icon.png"></div>
            <div class="input">
                <input type="text" name="username" id="username" class="input-field" required maxlength="20">
                <label for="">username</label>
            </div>
            <div class="input">
                <input type="password" name="password" id="password" class="input-field" required maxlength="20">
                <label for="">password</label>
            </div>
            <input type="submit" value="LOGIN" class="btn">
        </form>
    </section>
    <?php
    if($_SESSION['login']=='on'){
        echo "<script>setTimeout(() => {alert('Username Or Password Incorrect');}, 500);</script>";
        $_SESSION['login']='off';
    }
    ?>
    <script src="lib/script.js"></script>
</body>
</html>