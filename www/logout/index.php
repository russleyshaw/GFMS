<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); } 
  include_once($_SERVER['DOCUMENT_ROOT']."/logout_protocol.php");
  if (session_status() == PHP_SESSION_NONE) { session_start(); } 

  $_SESSION['web_alert_success'] = 'Logout successful.';
    header("Location: /login/");
  exit;
  

?>