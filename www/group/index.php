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

  <title><?php echo $row['name']; ?> | GFMS</title>

  <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>

  <div class="container">
    <div class="row">
      <h3 style="text-align:center;"><?php echo $row['name']; ?></h3>
    </div>
  </div>
  
  <div class="container">

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
      <?PHP echo "<a href=\"/group/transaction/?id=".$id."\">";?>
         <button type="button" class="btn btn-default btn-sm">Create Transacation</button>
      </a>
      <?PHP echo "<a href=\"/group/payment/?id=".$id."\">";?>
         <button type="button" class="btn btn-default btn-sm">Create Payment</button>
      </a>
      </div>
    </div>
  </div>
  
  <?PHP
    //get the ten most recent transactions
    $sql = "SELECT * FROM `transaction`,`user` WHERE transaction_of = '$id' AND transaction_of = user.id ORDER BY date DESC LIMIT 10";
    if($result = $mysqli->query($sql) ) {
      if($result->num_rows > 0) {
        //print out all the rows
        echo "<div class=\"table-responsive\"><table class=\"table\">";
        echo "<thead><tr><th>Date</th><th>Amount</th><th>Created by</th><th>Description</th></thead><tbody>";
        while($transaction = mysqli_fetch_array($result)) {
          echo "<tr><td>".$transaction['date']."</td>".
                   "<td>".$transaction['amount']."</td>".
                   "<td>".$transaction['username']."</td>".
                   "<td>".$transaction['description']."</td></tr>";
        }
        echo "</tbody></table></div>";
      }
    } else {
      $_SESSION['web_alert_danger'] = 'Failed to query group transactions.';
      header("Location: /dashboard/");
      exit;
    }
  ?>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
</body> <!-- BODY END -->
</html>