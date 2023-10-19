<?php
include 'connection.php';

$user = $_POST['username'];
$pass = $_POST['password'];

$checkLogin = "SELECT * FROM `admins` WHERE `username`='$user' AND `password`='$pass';";
$checkLoginResult = $mysqli->query($checkLogin);

if(mysqli_num_rows($checkLoginResult) == 1){
    $idLogin = "SELECT * FROM `admins` WHERE `username`='$user' AND `password`='$pass';";
    $idLoginResult = $mysqli->query($idLogin);
    
    while($rows=$idLoginResult->fetch_assoc()){
        $_SESSION['admin_id'] = $rows['admin_id'];
    }
    $_SESSION['salesReport'] = "off";
    $_SESSION['orderReport'] = "off";
    header('Location:../analytics.php');
}
else{
    $_SESSION['login']='on';
    echo "<script>history.back();</script>";
}
$mysqli->close();
?>