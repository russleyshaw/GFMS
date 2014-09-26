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

  
  <!-- NAVBAR INCLUDE --> <?php 
      $path = $_SERVER['DOCUMENT_ROOT'];
      $path .= "/navbar/default.php";
      include_once($path);
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
      <form role="form">

        <div class="form-group">
          <input type="text" class="form-control" id="signup_username" placeholder="Username">
        </div>

        <div class="form-group">
          <input type="email" class="form-control" id="signup_email" placeholder="Enter email">
        </div>

        <div class="form-group">
          <input type="password" class="form-control" id="signup_password" placeholder="Password">
        </div>

        <div class="form-group">
          <input type="password" class="form-control" id="signup_passwordagain" placeholder="Password (Again)">
        </div>

        <button type="submit" class="btn btn-default">Sign Up</button>
      </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
</body> <!-- BODY END -->
</html>