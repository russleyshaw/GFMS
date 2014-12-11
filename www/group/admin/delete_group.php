<?php
    if (session_status() == PHP_SESSION_NONE) { session_start(); }
    include($_SERVER['DOCUMENT_ROOT']."/conn.php");
    include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");

    $userid = $_SESSION['user_id'];
    $groupid = $_GET['id'];

    $sql = "SELECT * FROM `group` WHERE group.id = '$groupid' LIMIT 1";

    //Check if calling user is admin
    if($result = $mysqli->query($sql)){
        if($row = mysqli_fetch_array($result)) {
            if($row['admin_id'] == $userid) {
                //Good
            } else {
                $_SESSION['web_alert_danger'] = "You do not have permissions to perform this operation.";
                header("Location: /group/?id=".$groupid);
                exit;
            }
        } else {
            $_SESSION['web_alert_danger'] = "No group found.";
            header("Location: /dashboard");
            exit;
        }
    } else {
        $_SESSION['web_alert_danger'] = $mysqli->error;
        header("Location: /group/admin/?id=".$groupid);
        exit;
    }

    //Commence with deleting
    $sql = "
        DELETE FROM `group` WHERE group.id = '$groupid'
    ";

    if($result = $mysqli->query($sql)){
        $_SESSION['web_alert_success'] = "Successfully deleted the group.";
        header("Location: /dashboard");
        exit;
    } else {
        $_SESSION['web_alert_danger'] = $mysqli->error;
        header("Location: /group/admin/?id=".$groupid);
        exit;
    }