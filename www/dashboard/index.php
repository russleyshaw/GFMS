<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/conn.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/check_login.php"); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/logged_in_only.php"); ?>

<?php
$userid = $_SESSION['user_id'];
$sql = "SELECT * FROM `group` WHERE id IN (SELECT group_id FROM `group_user` WHERE user_id = '$userid')";
if (!$result = $mysqli->query($sql)) {
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

    <title>Dashboard | GFMS</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/custom.css" rel="stylesheet">
</head>

<body> <!-- BODY START -->

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/navbar/chooser.php"); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/web_alerts/base.php"); ?>

<div class="container">
    <div class="row text-center">
        <h3>Dashboard</h3>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Groups
                    <span class="badge"><?php echo $num_groups ?></span>
                    <div class="btn-group pull-right">
                        <a href="/dashboard/join_group" class="btn btn-default btn-success btn-xs">
                            <span class="glyphicon glyphicon-plus"></span> Join
                        </a>
                        <a href="/dashboard/new_group" class="btn btn-default btn-success btn-xs">
                            <span class="glyphicon glyphicon-edit"></span> Create
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                <?php while ($row = $result->fetch_array()) {

                    echo '<div class="btn-group btn-block">';
                    echo '<a class="btn btn-default btn-sm" href="/group?id='.$row['id'].'">';
                    if($row['private']){
                        echo '<span class="glyphicon glyphicon-lock"></span>';
                    }
                    echo $row['name'];
                    echo '</a>';
                    if($row['admin_id'] == $userid) {
                        echo '
                        <a href="/group/admin?id='.$row['id'].'" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>';
                    }
                    echo '</div>';
                } ?>
                </div>
            </div>
        </div>
    <!-- col-md-6 -->
    </div>
</div><!-- container -->

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
<!-- BODY END -->
</html>