<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/conn.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/check_login.php"); ?>

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM `group` WHERE id = '$id'";
if($result = $mysqli->query($sql) ) {
    if($result->num_rows < 1) {
        $_SESSION['web_alert_danger'] = 'Unable to find group with id '. $id.'.';
        header("Location: /");
        exit;
    }

    $row = mysqli_fetch_array($result);
} else {
    $_SESSION['web_alert_danger'] = 'Failed to query group.';
    header("Location: /");
    exit;
}
$isPrivate = $row['private'];
if(!array_key_exists('user_id', $_SESSION)) {
    $inGroup = false;
} else {
    $sql = "SELECT * FROM `group_user` WHERE group_id='$id' AND user_id='".$_SESSION['user_id']."'";
    if($result = $mysqli->query($sql) ) {
        $inGroup = true;
    } else {
        $_SESSION['web_alert_danger'] = 'Failed to query group.';
        header("Location: /");
        exit;
    }
}
//forbid access if private
if(!$inGroup AND $isPrivate) {
    $_SESSION['web_alert_danger'] = 'That group is private.';
    header("Location: /");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $row['name']; ?> | GFMS</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

<?php include_once($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>

<div class="container">
    <div class="row text-center">
        <h3>
            <?php echo $row['name']; ?><br/>
            <small>
                <?php echo $row['description']; ?>
            </small>
        </h3>
    </div>

<?PHP
if($inGroup) {
    echo
'
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a href="/group/payment/?id='.$id.'" class="btn btn-default btn-block">Create Payment</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a href="/group/do_newsummary.php/?id='.$id.'" class="btn btn-default btn-block">Create Summary</a>
        </div>
    </div>
';
}
?>

<?php

?>

<?php
//get the ten most recent transactions
$sql = "SELECT * FROM `transaction`,`user` WHERE transaction_of = '$id' AND owner = user.id ORDER BY date DESC LIMIT 10";
if($result = $mysqli->query($sql) ) {
    if($result->num_rows > 0) {
        //print out all the rows
        echo
'
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <span class="pull-left">Transactions</span>
                    <a href="/group/transaction/?id='.$id.'" class="btn btn-success btn-xs pull-right">+ Create Transaction</span></a>
                </div>
                <table class="table">
                    <thead>
                        <tr><th>Date</th><th>Amount</th><th>Created by</th><th>Description</th>
                    </thead>
                    <tbody>
';
        while($transaction = mysqli_fetch_array($result)) {
            $realdate = date("Y-m-d", strtotime($transaction['date']));
            echo
'
                        <tr>
                            <td>'.$realdate.'</td>
                            <td>'.$transaction["amount"].'</td>
                            <td>'.$transaction['username'].'</td>
                            <td>'.$transaction['description'].'</td>
                        </tr>
';
        }
        echo '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
';
    }
} else {
    $_SESSION['web_alert_danger'] = 'Failed to query group transactions.';
}
?>

</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</body> <!-- BODY END -->
</html>