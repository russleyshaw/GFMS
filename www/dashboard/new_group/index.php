<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/conn.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/check_login.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>New Group | GFMS</title>

  <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>


  <div class="container">
    <div class="row">
      <h3 style="text-align:center;">New Group</h3>
    </div>
  </div>

  <div class="container">

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
      <form role="form" method="post" action="do_newgroup.php">

        <div class="form-group">
          <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Group Name">
        </div>

        <div class="form-group">
          <textarea class="form-control" name="group_desc" id="group_desc" placeholder="Descriptions" rows="3"></textarea>
        </div>

        <div class="checkbox">
          <label>
            <input type="checkbox"  name="group_private" id="group_private">
            Private Group (Non-members will not be able to see group)
          </label>
        </div>

        <button type="submit" class="btn btn-default">Create Group</button>
      </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
</body> <!-- BODY END -->
</html>