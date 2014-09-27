<?php
  if( isset( $_SESSION['web_alert_danger'] ) ) {
    $text = $_SESSION['web_alert_danger'];
    unset($_SESSION['web_alert_danger']);
    echo
    "
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
          <strong>Danger:</strong> $text
        </div>
      </div>
    </div>
    ";
  }
?>
<?php
  if( isset( $_SESSION['web_alert_warning'] ) ) {
    $text = $_SESSION['web_alert_warning'];
    unset($_SESSION['web_alert_warning']);
    echo
    "
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
          <strong>Warning:</strong> $text
        </div>
      </div>
    </div>
    ";
  }
?>
<?php
  if( isset( $_SESSION['web_alert_info'] ) ) {
    $text = $_SESSION['web_alert_info'];
    unset($_SESSION['web_alert_info']);
    echo
    "
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"alert alert-info alert-dismissible\" role=\"alert\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
          <strong>Info:</strong> $text
        </div>
      </div>
    </div>
    ";
  }
?>
<?php
  if( isset( $_SESSION['web_alert_success'] ) ) {
    $text = $_SESSION['web_alert_success'];
    unset($_SESSION['web_alert_success']);
    echo
    "
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"alert alert-success alert-dismissible\" role=\"alert\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
          <strong>Success:</strong> $text
        </div>
      </div>
    </div>
    ";
  }
?>


