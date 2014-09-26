<?php
  
  //Include connect script.
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/conn.php";
  include_once($path);

  //Check for username collisions
  $username = $_POST["signup_username"];
  if($result = $mysqli->query("SELECT * FROM user WHERE username = '$username'") ) {
    echo "Error: Username collision.";
  }

  //Check for email collisions
  $email = $_POST["signup_email"];
  if( !$mysqli->query("SELECT * FROM user WHERE email = '$email'") ) {
    echo "Error: Email collision.";
  }

  $pwd1 = $_POST["signup_password1"];
  $pwd2 = $_POST["signup_password2"];

  if($pwd1 != $pwd2) {
    echo "Error: Different passwords.";
  }

  $pwd = md5($pwd1);
  $token = md5($pwd . md5($username));

  //Check for token collisions
  if( !$mysqli->query("SELECT * FROM user WHERE token = '$token'") ) {
    echo "Error: Token collision.";
  }

  //Insert new user
  if( !$mysqli->query("INSERT INTO user (username, password, email, token) VALUES ('$username', '$pwd', '$email', '$token')") ) {
    echo "Error: Unable to insert.";
  }


  //Include disconnect script.
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/disconn.php";
  include_once($path);

  //header("Location: /login/");
  //exit;
?>