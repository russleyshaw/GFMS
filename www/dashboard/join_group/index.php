<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/conn.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/check_login.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php"); ?>

<?php
  $userid = $_SESSION['user_id'];
  $sql = "SELECT * FROM `group` WHERE id IN (SELECT group_id FROM `group_user` WHERE user_id = '$userid')";
  if(!$result = $mysqli->query($sql) ) {
      $_SESSION['web_alert_danger'] = 'Unable to query group or group_user.';
      header("Location: /");
      exit;  
  }
  $num_groups = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Join Group | GFMS</title>

  <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>
  
  <div class="container">
    <div class="row">
      <h3 style="text-align:center;">Join Group</h3>
    </div>
  </div>
  
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
      <form role="form" method="post" action="do_joingroup.php">

        <div class="form-group">
          <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Group Name">
        </div>
        
        <button type="submit" class="btn btn-default">Join Group</button>
      </form>
      </div>
    </div>
  </div>
   
   <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
  
</body>
</html>