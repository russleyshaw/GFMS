<?php
  if(!(isset($_SESSION['user_id']) and isset($_SESSION['user_token'])) ) {
      $_SESSION['web_alert_info'] = 'Page only accessable when logged in.';
      header("Location: /");
      exit;
  }
?>