<?php
  if(isset($_SESSION['user_token']) and isset($_SESSION['user_token'])) {
    include($_SERVER['DOCUMENT_ROOT']."/navbar/login.php");
  } else {
    include($_SERVER['DOCUMENT_ROOT']."/navbar/default.php");
  }
?>