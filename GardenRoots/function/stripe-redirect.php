<?php
include 'connection.php';

$credit = $_POST['credit'];
$_SESSION['creds_value'] = $credit;

if($credit == '100'){
    header("Location:https://buy.stripe.com/test_fZe4hQ3ih0XSgFifYZ");
}

else if($credit == '500'){
    header("Location:https://buy.stripe.com/test_aEU15E06521Wcp23ce");
}

else if($credit == '1000'){
    header("Location:https://buy.stripe.com/test_8wM8y67yx4a43SweUX");
}

else if($credit == '5000'){
    header("Location:https://buy.stripe.com/test_fZeeWubON9uoagU4gk");
}
?>