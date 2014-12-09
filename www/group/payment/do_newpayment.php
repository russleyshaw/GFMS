<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include($_SERVER['DOCUMENT_ROOT']."/conn.php");
  include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");
  
  //Gather variables
  $amount = $_POST['amount'];
  $date = date('Y-m-d H:i:s');
  $groupID = $_GET['id'];
  $fromuser = $_SESSION['user_id'];
  $touser = $_POST['toid'];
  
  //Insert new payment
  $sql = "INSERT INTO `payment` (`date`, `amount`, `payment_to`, `payment_from`, `payment_of`) VALUES ('$date', '$amount', '$touser', '$fromuser', '$groupID')";
  if(!$mysqli->query($sql)){
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/payment/");
    exit;
  }
  
  include($_SERVER['DOCUMENT_ROOT']."/disconn.php");
  
  $_SESSION['web_alert_success'] = 'Payment successfully created.';
  header("Location: /group/?id=".$groupID);
  exit;
?>