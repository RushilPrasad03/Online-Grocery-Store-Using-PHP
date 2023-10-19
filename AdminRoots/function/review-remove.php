<?php
include 'connection.php';

$review_id = $_POST['review_id'];

$reviewDelete = "DELETE FROM `review` WHERE `review_id`='$review_id';";
$reviewDeleteResult = $mysqli->query($reviewDelete);

echo '<script type="text/JavaScript">history.back();</script>';

$mysqli->close();
?>