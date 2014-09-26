<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/secret_conn.php";
  include_once($path);

  $mysqli = new mysqli($DB_URL, $DB_USER, $DB_PASS, $DB_NAME); 

  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
?>