<?php
  include_once($_SERVER['DOCUMENT_ROOT']."/secret_conn.php");

  if(!isset($mysqli)) {
    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); 
  }

  if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
  }
?>