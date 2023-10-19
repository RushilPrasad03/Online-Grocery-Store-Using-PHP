<?php
include 'connection.php';

$user_id = $_POST['user_id'];

$customerDelete = "DELETE FROM `users` WHERE `user_id`='$user_id';";
$customerDeleteResult = $mysqli->query($customerDelete);

echo '<script type="text/JavaScript">history.back();</script>';

$mysqli->close();
?>