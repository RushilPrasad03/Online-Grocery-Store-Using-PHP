<?php
session_start();
$user = 'root';
$password = ''; 
$database = 'garden_roots'; 
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user, $password, $database);  

$name=$_POST['product'];
$price=$_POST['price'];
$discount=$_POST['discount'];
$type=$_POST['category'];
$image=$_FILES['image']['name'];

$sql = "INSERT INTO `product` (`product_id`, `product`, `price`, `discount`, `product_image`, `description`, `category`, `sales`, `ordered`, `featured`) VALUES (NULL, '$name', '$price', '$discount', '$image', ' ', '$type', '0', '0', '0')";
$mysqli->query($sql);
?>
<script>
    history.back()
</script>