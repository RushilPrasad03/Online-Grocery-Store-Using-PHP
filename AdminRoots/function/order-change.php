<?php
include 'connection.php';

$orderSet = $_POST['orderSet'];
$status = $_POST['status'];

$orderUpdate = "UPDATE `order` SET `status`='$status' WHERE `order_set`='$orderSet';";
$orderUpdateResult = $mysqli->query($orderUpdate);

echo '<script type="text/JavaScript"> history.back();</script>';
$mysqli->close();
?>