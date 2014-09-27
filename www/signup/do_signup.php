<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include_once($_SERVER['DOCUMENT_ROOT']."/conn.php");

  //Gather variables
  $username = $_POST["signup_username"];
  $email = $_POST["signup_email"];
  $pwd1 = $_POST["signup_password1"];
  $pwd2 = $_POST["signup_password2"];

  //Check for username collisions
  if($result = $mysqli->query("SELECT * FROM user WHERE username = '$username'") ) {
    if($result->num_rows > 0) {
      $_SESSION['web_alert_danger'] = 'Username already exists.';
      header("Location: /signup/");
      exit;
    }
  } else {
    $_SESSION['web_alert_danger'] = 'Database username query failed.';
    header("Location: /signup/");
    exit;
  }

  //Check for email collisions
  if($result = $mysqli->query("SELECT * FROM user WHERE email = '$email'") ) {
    if($result->num_rows > 0) {
      $_SESSION['web_alert_danger'] = 'Email already exists.';
      header("Location: /signup/");
      exit;
    }
  } else {
    $_SESSION['web_alert_danger'] = 'Database email query failed.';
    header("Location: /signup/");
    exit;
  }

  //Check password consistency
  if($pwd1 != $pwd2) {
      $_SESSION['web_alert_danger'] = 'Passwords are different.';
      header("Location: /signup/");
      exit;
  }

  //Generate hashed password and token
  $pwd = md5($pwd1);
  $token = md5($pwd . md5($username));

  //Check for token collisions
  if($result = $mysqli->query("SELECT * FROM user WHERE token = '$token'") ) {
    if($result->num_rows > 0) {
      $_SESSION['web_alert_danger'] = 'Token already exists.';
      header("Location: /signup/");
      exit;
    }
  } else {
    $_SESSION['web_alert_danger'] = 'Database token query failed.';
    header("Location: /signup/");
    exit;
  }

  //Insert new user
  if(! $mysqli->query("INSERT INTO user (username, password, email, token) VALUES ('$username', '$pwd', '$email', '$token')") ) {
    $_SESSION['web_alert_danger'] = 'Failed to insert new user.';
    header("Location: /signup/");
    exit;
  }

  include_once($_SERVER['DOCUMENT_ROOT']."/disconn.php");

  $_SESSION['web_alert_success'] = 'User ' . $username . ' was successfully created.';
  header("Location: /login/");
  exit;
?>