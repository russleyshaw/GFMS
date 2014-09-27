<?php

  if(isset($_SESSION['user_id']) and isset($_SESSION['user_token'])) {
    $user_id = $_SESSION['user_id'];
    if($result = $mysqli->query("SELECT * FROM user WHERE id = '$user_id'") ) {
      if($result->num_rows < 1) {
        include($_SERVER['DOCUMENT_ROOT']."/logout_protocol.php");
        $_SESSION['web_alert_danger'] = 'Unable to find user id.';
        header("Location: /");
        exit;         
      } elseif($result->num_rows > 1) {
        include($_SERVER['DOCUMENT_ROOT']."/logout_protocol.php");
        $_SESSION['web_alert_danger'] = 'Found multiple user ids.';
        header("Location: /");
        exit;      
      }
    } else {
      include($_SERVER['DOCUMENT_ROOT']."/logout_protocol.php");
      $_SESSION['web_alert_danger'] = 'Database id query failed.';
      header("Location: /");
      exit;   
    }

    $row = mysqli_fetch_array($result);

    if($_SESSION['user_token'] != $row['token']) {
    include($_SERVER['DOCUMENT_ROOT']."/logout_protocol.php");

      $_SESSION['web_alert_danger'] = 'Invalid token.';
      header("Location: /");
      exit;
    }
  } else {
    include($_SERVER['DOCUMENT_ROOT']."/logout_protocol.php");
  }

?>