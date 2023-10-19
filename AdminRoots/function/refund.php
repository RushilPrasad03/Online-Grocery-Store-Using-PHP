<?php
include 'connection.php';

$orderReportNo = $_SESSION['orderReportNo'];
$paymentType = $_POST['paymentType'];

$orderCancel = "SELECT * FROM `order` INNER JOIN `product` ON order.product_id = product.product_id WHERE `order_set` = '$orderReportNo'";
$orderCancelResult = $mysqli->query($orderCancel);
$sales = 0;
$ordered = 0;
$total = 0;

while($rows=$orderCancelResult->fetch_assoc()){
    $sales = $rows['sales'] - $rows['quantity'];
    $ordered = $rows['ordered'] - 1;
    $total = $rows['total'];
    $user_id = $rows['user_id'];
    $product_id = $rows['product_id'];

    $updateSales = "UPDATE `product` SET `sales` = '$sales' WHERE `product`.`product_id` = '$product_id';";
    $updateSalesResult = $mysqli->query($updateSales);

    $updateOrdered = "UPDATE `product` SET `ordered` = '$ordered' WHERE `product`.`product_id` = '$product_id';";
    $updateOrderedResult = $mysqli->query($updateOrdered);
    $sales = 0;
    $ordered = 0;
}

if($paymentType !='cash'){
    $userCredits = "SELECT * FROM `users` WHERE `user_id` = '$user_id';";
    $userCreditsResult = $mysqli->query($userCredits);
    
    while($rows=$userCreditsResult->fetch_assoc()){
        $credits = $rows['credits'] + $total;
    }
    
    $creditUpdate = "UPDATE `users` SET `credits` = '$credits' WHERE `user_id` = '$user_id';";
    $creditUpdateResult = $mysqli->query($creditUpdate);
}

$removeOrder = "DELETE FROM `order` WHERE `order_set` = '$orderReportNo';";
$removeOrderResult = $mysqli->query($removeOrder);

$_SESSION['accountOrders'] = 'on';
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>