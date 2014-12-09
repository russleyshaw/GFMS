<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/conn.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/check_login.php"); ?>

<?php
  $id = $_GET['id'];
  $sql = "SELECT * FROM `group` WHERE id = '$id'";
  if($result = $mysqli->query($sql) ) {
    if($result->num_rows < 1) {
      $_SESSION['web_alert_danger'] = 'Unable to find group with id '. $id.'.';
      header("Location: /");
      exit;     
    }

    $row = mysqli_fetch_array($result);
  } else {
      $_SESSION['web_alert_danger'] = 'Failed to query group.';
      header("Location: /");
      exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Create Transaction | GFMS</title>

  <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

  <?php include($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

  <?php include($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>
  
  <div class="container">
    <div class="row">
      <h3 style="text-align:center;">New Transaction for <?PHP echo $row['name']?></h3>
    </div>
  </div>
  
  <div class="container">
    <div class="col-md-6 col-md-offset-3">
    <form role="form" method="post" action="do_newtransaction.php/?id=<?PHP echo $id?>">
      
      <div class="form-group">
        <textarea type="text" class="form-control" name="description" id="description" placeholder="Description" rows="3"></textarea>
      </div>
      
      <div class="form-group">
        <input type="number" class="form-control" name="amount" id="amount" min="0" max="999999" step="0.01" placeholder="Amount">
      </div>
      
      <button type="submit" class="btn btn-default">Create Transaction</button>
      
    </form>
    </div>
  </div>
  
  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
  
</body> <!-- BODY END -->
</html>