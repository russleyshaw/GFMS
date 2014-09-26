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
      <form role="form" method="post" action="do_signup.php">

        <div class="form-group">
          <input type="text" class="form-control" name="signup_username" id="signup_username" placeholder="Username">
        </div>

        <div class="form-group">
          <input type="email" class="form-control" name="signup_email" id="signup_email" placeholder="Enter email">
        </div>

        <div class="form-group">
          <input type="password" class="form-control" name="signup_password1" id="signup_password1" placeholder="Password">
        </div>

        <div class="form-group">
          <input type="password" class="form-control" name="signup_password2" id="signup_password2" placeholder="Password (Again)">
          <span class="help-block"></span>
        </div>

        <button type="submit" class="btn btn-default">Sign Up</button>
      </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>

  <script>

  function check_same_pass() {
    var pwd1 = $("#signup_password1");
    var pwd2 = $("#signup_password2");
    if( pwd1.val() === pwd2.val() ) {
      pwd2.parent().removeClass("has-error");
      pwd2.parent().addClass("has-success");
      pwd2.siblings("span").html("");
      return true;
    } else {
      pwd2.parent().removeClass("has-success");
      pwd2.parent().addClass("has-error");
      pwd2.siblings("span").html("Please re-type the same password.");
      return false;
    }
  }

  $("#signup_password1").change(function() {
    check_same_pass();
  });
  $("#signup_password2").change(function() {
    check_same_pass();
  });
  </script>

</body> <!-- BODY END -->
</html>