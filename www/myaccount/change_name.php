<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include($_SERVER['DOCUMENT_ROOT']."/conn.php");
include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");

$name = $_GET['form_name'];
$userid = $_SESSION['user_id'];

$sql = "UPDATE `user` SET user.name = '$name' WHERE user.id = '$userid'";

if($mysqli->query($sql)){
    $_SESSION['web_alert_success'] = "Successfully changed name.";
} else {
    $_SESSION['web_alert_danger'] = $mysqli->error;
}
header("Location: /myaccount");
exit;
