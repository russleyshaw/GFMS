<?php
  if(isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
  }
  if(isset($_SESSION['user_token'])) {
    unset($_SESSION['user_token']);
  }
?>