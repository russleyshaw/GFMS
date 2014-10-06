<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/conn.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login | GFMS</title>

  <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

  <?php include($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

  <?php include($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>

  <div class="container">
    <div class="row">
      <h3 style="text-align:center;">Login</h3>
    </div>
  </div>

  <div class="container">

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
      <form role="form" method="post" action="do_login.php">

        <div class="form-group">
          <input type="text" class="form-control" name="login_username" id="login_username" placeholder="Username">
        </div>

        <div class="form-group">
          <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-default">Login</button>
      </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
</body> <!-- BODY END -->
</html>