<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include($_SERVER['DOCUMENT_ROOT']."/conn.php");
  include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");
  
  //Gather variables
  $groupID = $_GET['id'];
  $date = date('Y-m-d H:i:s');
  
  //get the newest summary
  $sql = "SELECT * FROM `summary` WHERE belongs_to = '$groupID' ORDER BY date DESC";
  if(!($result = $mysqli->query($sql))) {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/?id=".$groupID);
    exit;
  }
  if($result->num_rows > 0) {
    //there is an old date; extract it and use it
    $date = mysqli_fetch_array($result)['date'];
    $sql_payment = "SELECT * FROM `payment` WHERE payment_of = '$groupID' AND payment.date > '$date'";
    $sql_transaction = "SELECT * FROM `transaction` WHERE transaction_of = '$groupID' AND transaction.date > '$date'";
  } else {
    //there is no summary; don't need a date field
    $sql_payment = "SELECT * FROM `payment` WHERE payment_of = '$groupID'";
    $sql_transaction = "SELECT * FROM `transaction` WHERE transaction_of = '$groupID'";
  }
  
  if(!($payments = $mysqli->query($sql_payment) AND $transactions = $mysqli->query($sql_transaction))) {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  //if no new payments or transactions then everything's alright
  if($payments->num_rows == 0 AND $transactions->num_rows == 0) {
    $_SESSION['web_alert_success'] = "Latest summary already up to date.";
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  //put a dummy summary in for now
  $sql = "INSERT INTO `summary` (`date`, `belongs_to`) VALUES ('$date', '$groupID')";
  if(!$mysqli->query($sql)){
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  $_SESSION['web_alert_success'] = "Summary created.";
  header("Location: /group/?id=".$groupID);
  exit;
  
?>