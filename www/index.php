<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/conn.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/check_login.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Home | GFMS</title>

  <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>

  <div class="container">
    <div class="row text-center">
        <h1>Group Finance Management System</h1>
    </div>
    <div class="row text-center">
        <a href="/imgs/money.gif" target="_blank">
            <img src="/imgs/money.gif" width="25%" />
            <img src="/imgs/money.gif" width="25%" />
        </a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
</body> <!-- BODY END -->
</html>