<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include($_SERVER['DOCUMENT_ROOT']."/conn.php");

  include($_SERVER['DOCUMENT_ROOT']."/logout_protocol.php");

  $username = $_POST['login_username'];
  $password = $_POST['login_password'];
  $passwordMD5 = md5($password);

  $token = md5( $passwordMD5.md5($username) );

  if($result = $mysqli->query("SELECT * FROM user WHERE username = '$username'") ) {
    if($result->num_rows < 1) {
      $_SESSION['web_alert_danger'] = 'Unable to find user'. $username.'.';
      header("Location: /login/");
      exit;
    } elseif($result->num_rows > 1) {
      $_SESSION['web_alert_danger'] = 'Found multiple instances of user'.$username.'.';
      header("Location: /login/");
      exit;
    }
  } else {
    $_SESSION['web_alert_danger'] = 'Database username query failed.';
    header("Location: /login/");
    exit;
  }

  $row = mysqli_fetch_array($result);

  //Check password
  if( md5($password) != $row['password'] ) {
    $_SESSION['web_alert_danger'] = 'Invalid password.';
    header("Location: /login/");
    exit;
  }
  //Check token
  if( $token != $row['token'] ) {
    $_SESSION['web_alert_danger'] = 'Invalid token.';
    header("Location: /login/");
    exit;
  }

  $_SESSION['user_id'] = $row['id'];
  $_SESSION['user_token'] = $token;

  include($_SERVER['DOCUMENT_ROOT']."/disconn.php");

  $_SESSION['web_alert_success'] = 'Login successful.';
  header("Location: /dashboard/");
  exit;

?>