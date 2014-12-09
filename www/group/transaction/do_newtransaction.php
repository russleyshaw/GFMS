<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include($_SERVER['DOCUMENT_ROOT']."/conn.php");
  include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");
  
  //Gather variables
  $desc = $_POST['description'];
  $amount = $_POST['amount'];
  $date = date('Y-m-d H:i:s');
  $groupID = $_GET['id'];
  $owner = $_SESSION['user_id'];
  
  //Insert new transaction
  $sql = "INSERT INTO `transaction` (`description`, `date`, `amount`, `transaction_of`, `owner`) VALUES ('$desc', '$date', '$amount', '$groupID', '$owner')";
  if(!$mysqli->query($sql))
  {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/transaction/");
    exit;
  }

  //Insert into group user
  include($_SERVER['DOCUMENT_ROOT']."/disconn.php");
  
  $_SESSION['web_alert_success'] = 'Transaction succesfully created.';
  header("Location: /group/?id=".$groupID);
  exit;
?>