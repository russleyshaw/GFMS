<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/conn.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/check_login.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php"); ?>

<?php
$userid = $_SESSION['user_id'];

$sql = "SELECT * FROM `user` WHERE user.id = '$userid' LIMIT 1";
if($result = $mysqli->query($sql)){
    if($row = mysqli_fetch_array($result)){
        //Good
    } else {
        $_SESSION['web_alert_danger'] = "Could not find user id in database.";
        header("Location: /");
        exit;
    }
} else {
    $_SESSION['web_alert_danger'] = $mysqli->error;
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

    <title>My Account | GFMS</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

<?php include_once($_SERVER['DOCUMENT_ROOT']."/navbar/chooser.php"); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/web_alerts/base.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="text-center">
                <h3>
                    <?php if($row['name']){
                        echo $row['name']."'s";
                    } else {
                        echo 'My';
                    }?> Account
                </h3>
            </div>


            <form method="get" action="/myaccount/change_name.php">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Modify Your Name Here" name="form_name">
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control">Change Name</button>
                </div>
            </form>
        </div>



    </div>
</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</body> <!-- BODY END -->
</html>