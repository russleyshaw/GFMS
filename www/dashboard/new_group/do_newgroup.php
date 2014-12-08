<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include($_SERVER['DOCUMENT_ROOT']."/conn.php");
  include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");

  //Gather variables
  $name = $_POST['group_name'];
  $desc = $_POST["group_desc"];
  $private = isset($_POST["group_private"]);
  $admin_id = $_SESSION['user_id'];

  //Check for group name collisions
  $sql = "SELECT * FROM `group` WHERE name = '$group_name' LIMIT 1";
  if( $result = $mysqli->query($sql) ) {
    if($result->num_rows > 0) {
      $_SESSION['web_alert_danger'] = 'Group '.$name.' already exists.';
      header("Location: /dashboard/new_group/");
      exit;
    }
  } else {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /dashboard/new_group");
    exit;
  }

  //Insert new user
  $sql = "INSERT INTO `group` (`name`, `description`, `admin_id`, `private`) VALUES ('$name', '$desc', '$admin_id', '$private')";
  if($mysqli->query($sql) ) {
    $new_id = $mysqli->insert_id;

    //Connect User and Group
    $sql = "INSERT INTO `group_user` (`user_id`, `group_id`) VALUES ('$admin_id', '$new_id')";
    if(! $mysqli->query($sql) ) {
      $_SESSION['web_alert_danger'] = $mysqli->error;
      header("Location: /dashboard/new_group");
      exit;
    }
  } else {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /dashboard/new_group/");
    exit;
  }

  //Insert into group user
  include($_SERVER['DOCUMENT_ROOT']."/disconn.php");

  $_SESSION['web_alert_success'] = 'Group ' . $name . ' was successfully created.';
  header("Location: /dashboard/");
  exit;
?>