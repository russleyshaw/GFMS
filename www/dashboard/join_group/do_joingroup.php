<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include($_SERVER['DOCUMENT_ROOT']."/conn.php");
  include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");
  
  //Gather variables
  $group_name = $_POST['group_name'];
  $user_id = $_SESSION['user_id'];
  
  //Check for group name collisions
  $sql = "SELECT id FROM `group` WHERE name = '$group_name' LIMIT 1";
  if( $result = $mysqli->query($sql) ) {
    if($result->num_rows == 0) {
      $_SESSION['web_alert_danger'] = 'Group '.$group_name.' does not exist.';
      header("Location: /dashboard/join_group/");
      exit;
    }
  } else {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /dashboard/join_group/");
    exit;
  }
  
  //get the group id
  $group_id = $result->fetch_row()[0];
  
  //make sure that the user isn't part of the group
  $sql = "SELECT * FROM `group_user` WHERE user_id = '$user_id' AND group_id = '$group_id' LIMIT 1";
  if(! $result = $mysqli->query($sql) ) {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /dashboard/join_group/");
    exit;
  }
  if($result->num_rows > 0)
  {
    $_SESSION['web_alert_danger'] = 'You are already part of this group.';
    header("Location: /dashboard/join_group/");
    exit;
  }
  
  //Connect User and Group
  $sql = "INSERT INTO `group_user` (`user_id`, `group_id`) VALUES ('$user_id', '$group_id')";
  if(! $mysqli->query($sql) ) {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /dashboard/join_group/");
    exit;
  }
  
  //Insert into group user
  include($_SERVER['DOCUMENT_ROOT']."/disconn.php");
  
  $_SESSION['web_alert_success'] = 'Group ' . $name . ' was successfully joined.';
  header("Location: /dashboard/");
  exit;
  
?>