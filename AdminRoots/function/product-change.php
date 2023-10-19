<?php
include 'connection.php';

$product_id = $_POST['product_id'];
$op = $_POST['op'];

if($op == "image"){
    $image = $_FILES["productIMG"]["name"];

    $productUpdate = "UPDATE `product` SET `product_image`='$image' WHERE `product_id`='$product_id';";
    $productUpdateResult = $mysqli->query($productUpdate);
}
else if($op == "name"){
    $name = $_POST['name'];

    $productUpdate = "UPDATE `product` SET `product`='$name' WHERE `product_id`='$product_id';";
    $productUpdateResult = $mysqli->query($productUpdate);
}
else if($op == "price"){
    $price = $_POST['price'];

    $productUpdate = "UPDATE `product` SET `price`='$price' WHERE `product_id`='$product_id';";
    $productUpdateResult = $mysqli->query($productUpdate);
}
else if($op == "discount"){
    $discount = $_POST['discount'];

    $productUpdate = "UPDATE `product` SET `discount`='$discount' WHERE `product_id`='$product_id';";
    $productUpdateResult = $mysqli->query($productUpdate);
}
else if($op == "category"){
    $category = $_POST['category'];

    $productUpdate = "UPDATE `product` SET `category`='$category' WHERE `product_id`='$product_id';";
    $productUpdateResult = $mysqli->query($productUpdate);
}
else if($op == "featured"){
    $featured = $_POST['featured'];

    $productUpdate = "UPDATE `product` SET `featured`='$featured' WHERE `product_id`='$product_id';";
    $productUpdateResult = $mysqli->query($productUpdate);
}
else if($op == "remove"){
    $productUpdate = "DELETE FROM `product` WHERE `product_id`='$product_id';";
    $productUpdateResult = $mysqli->query($productUpdate);
}
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>