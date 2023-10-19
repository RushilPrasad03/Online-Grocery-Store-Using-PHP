<?php
include 'connection.php';

$op = $_POST['op'];
$admin_id = $_SESSION['admin_id'];

if($op == 'add'){
    $gallery_image = $_FILES["gallery_image"]["name"];

    $galleryAdd = "INSERT INTO `gallery` (`gallery_id`, `admin_id`, `gallery_image`, `date`) VALUES (NULL, '$admin_id', '$gallery_image', current_timestamp());";
    $galleryAddResult = $mysqli->query($galleryAdd);
}
else if($op == 'remove'){
    $gallery_id = $_POST['gallery_id'];

    $galleryDelete = "DELETE FROM `gallery` WHERE `gallery_id`='$gallery_id';";
    $galleryDeleteResult = $mysqli->query($galleryDelete);
}

$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>