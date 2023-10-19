<?php
include 'connection.php';

$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

$report = "SELECT * FROM `product` INNER JOIN `order` on `product`.product_id = `order`.`product_id` WHERE `date` BETWEEN '$date1' AND '$date2' GROUP BY `product`.`product_id`";
$reportResult = $mysqli->query($report);

$_SESSION['salesReportNo'] = $report;

$_SESSION['salesReport'] = 'on';

$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>