<?php
include 'connection.php';

$op = $_POST['op'];
$admin_id = $_SESSION['admin_id'];

if($op == 'add'){
    $blog_image = $_FILES["blog_image"]["name"];
    $blog_title = $_POST['blog_title'];
    $blog_data = $_POST['blog_data'];
    
    $blogAdd = "INSERT INTO `blog` (`blog_id`, `admin_id`, `blog_title`, `blog_data`, `blog_image`, `date`) VALUES (NULL, '$admin_id', '$blog_title', '$blog_data', '$blog_image', current_timestamp());";
    $blogAddResult = $mysqli->query($blogAdd);
}
else if($op == 'remove'){
    $blog_id = $_POST['blog_id'];

    $blogDelete = "DELETE FROM `blog` WHERE `blog_id`='$blog_id';";
    $blogDeleteResult = $mysqli->query($blogDelete);
}

$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>