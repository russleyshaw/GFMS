<?php
  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  include($_SERVER['DOCUMENT_ROOT']."/conn.php");
  include($_SERVER['DOCUMENT_ROOT']."/logged_in_only.php");
  
  //Gather variables
  $groupID = $_GET['id'];
  $cur_date = date('Y-m-d H:i:s');
  
  //get the newest summary
  $sql = "SELECT * FROM `summary` WHERE belongs_to = '$groupID' ORDER BY date DESC LIMIT 2";
  if(!($result = $mysqli->query($sql))) {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  $amount_payed = array();
  $total_payed = 0;
  //format is [payer, reciever, amount]
  $summary_payments = array();
  
  //put all members of the group in the array
  $sql = "SELECT user_id FROM `group_user` WHERE group_id = '$groupID'";
  if(!($result2 = $mysqli->query($sql))){
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  //must have at least two members
  if($result2->num_rows < 2) {
    $_SESSION['web_alert_danger'] = "Must have at least two members to generate a summary.";
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  while($row = mysqli_fetch_array($result2)) {
    $amount_payed[$row['user_id']] = 0;
    $offsets[$row['user_id']] = 0;
  }
  
  if($result->num_rows > 0) {
    //there is an old date; extract it and use it
    $row = mysqli_fetch_array($result);
    $date = $row['date'];
    $summary_id = $row['id'];
    $sql_payment = "SELECT * FROM `payment` WHERE payment_of = '$groupID' AND payment.date > '$date'";
    $sql_transaction = "SELECT * FROM `transaction` WHERE transaction_of = '$groupID' AND transaction.date > '$date'";
    
    //Now read the old data
    $sql = "SELECT * FROM `summary_user` WHERE summary_id = '$summary_id'";
    if(!($result = $mysqli->query($sql))) {
      $_SESSION['web_alert_danger'] = $mysqli->error;
      header("Locatoin: /group/?id=".$groupID);
      exit;
    }
    while($row = mysqli_fetch_array($result)) {
      //Whoever is recieving money has already spend that much
      $summary_payments = array_merge($summary_payments, [[intval($row['user_id']),intval($row['payment_to']), floatval($row['amount'])]]);
    }
    
  } else {
    //there is no summary; don't need a date field
    $sql_payment = "SELECT * FROM `payment` WHERE payment_of = '$groupID'";
    $sql_transaction = "SELECT * FROM `transaction` WHERE transaction_of = '$groupID'";
  }
  
  if(!($payments = $mysqli->query($sql_payment) AND $transactions = $mysqli->query($sql_transaction))) {
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  //if no new payments or transactions then everything's alright
  if($payments->num_rows == 0 AND $transactions->num_rows == 0) {
    $_SESSION['web_alert_success'] = "Latest summary already up to date.";
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  //sum the amount of money each user has payed
  while($row = mysqli_fetch_array($transactions)) {
    $amount = $row['amount'];
    $amount_payed[$row['transaction_of']] += $amount;
    $total_payed += $amount;
  }
  
  //adjust amounts payed
  while($row = mysqli_fetch_array($payments)) {
    $amount = $row['amount'];
    //person paying has their amount incread
    $amount_payed[$row['payment_from']] += $amount;
    //recepient of money has their amount decreased
    $amount_payed[$row['payment_to']] -= $amount;
  }
  
  //the amount each user should have
  $wanted_amount = round($total_payed/count($amount_payed), 2);
  
  asort($amount_payed);
  
  $pos = 1;
  
  foreach($amount_payed as $payer => $base_amount) {
    //look through everyone that hasn't been processed
    $second_half = array_slice($amount_payed,$pos, NULL, true);
    arsort($second_half);
    //if not within two cents of the wanted amount
    if(abs($base_amount-$wanted_amount) > .02 AND $wanted_amount > $base_amount) {
      $to_give = $wanted_amount - $base_amount;
      //go through everyone else trying to give as much as possible
      //starting at the person with the highest amount
      foreach($second_half as $reciever => $reciever_amount) {
        if($to_give == 0) {
          break;
        }
        $going_to_give = 0;
        //the amount the other person can recieve
        $to_recieve = $reciever_amount - $wanted_amount;
        //give everything if possible
        if($to_recieve >= $to_give) {
          $going_to_give = $to_give;
        } else {
          //otherwise just give as much as possible
          $going_to_give = $to_recieve;
        }
        if($going_to_give > 0) {
          //adjust values
          $to_give -= $going_to_give;
          $amount_payed[$payer] += $going_to_give;
          $second_half[$reciever] -= $going_to_give;
          //mark payment
          $summary_payments = array_merge($summary_payments, [[$payer, $reciever, $going_to_give]]);
          
        }
      }
    }
    //resort the array
    asort($second_half);
    $amount_payed = array_slice($amount_payed, 0, $pos, true) + $second_half;
    $pos += 1;
  }
  
  sort($summary_payments);
  
  //follows money flow for keys [payer -> reciver], can be negative
  $final_payments = array();
  
  //sum up the payments
  foreach($summary_payments as $pay) {
    $payer = $pay[0];
    $reciever = $pay[1];
    $amount = $pay[2];
    $key = [$payer, $reciever];
    sort($key);
    $loc = -1;
    //look for the pair
    $i = 0;
    foreach($final_payments as $searching) {
      if($searching[0] == $key[0] AND $searching[1] == $key[1]) {
        $loc = $i;
        break;
      }
      $i++;
    }
    if($loc != -1) {
      if($payer == $key[0]) {
        $final_payments[$loc][2] += $amount;
      } else {
        $final_payments[$loc][2] -= $amount;
      }
    } else {
      if($payer != $key[0]) {
        $amount = -$amount;
      }
      $final_payments = array_merge($final_payments, [[$key[0], $key[1], $amount]]);
    }
  }
  
  //mark the summary as made
  $sql = "INSERT INTO `summary` (`date`, `belongs_to`) VALUES ('$cur_date', '$groupID')";
  if(!$mysqli->query($sql)){
    $_SESSION['web_alert_danger'] = $mysqli->error;
    header("Location: /group/?id=".$groupID);
    exit;
  }
  
  $new_id = $mysqli->insert_id;
  
  //insert payments
  foreach($final_payments as $pay) {
    if($pay[2] > 0) {
      $payer = $pay[0];
      $reciever = $pay[1];
      $amount = $pay[2];
    } else if($pay[2] < 0) {
      $payer = $pay[1];
      $reciever = $pay[0];
      $amount = -$pay[2];
    } else {
      continue;
    }
    $sql = "INSERT INTO `summary_user` (`user_id`, `summary_id`, `payment_to`, `amount`) VALUES ('$payer', '$new_id', '$reciever', '$amount')";
    if(!($mysqli->query($sql))) {
      $_SESSION['web_alert_danger'] = $mysqli->error;
      header("Location: /group/?id=".$groupID);
      exit;
    }
  }
  
  $_SESSION['web_alert_success'] = "Summary successfully created.";
  header("Location: /group/?id=".$groupID);
  exit;
  
?>