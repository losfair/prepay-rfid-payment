<?php
$db = new mysqli('localhost', 'nfc_payment', 'z4d0Xy6iwtFE4SIN', 'nfc_payment');

session_start();
if (!isset($_SESSION['user_id'])){
  header('Location: login.php?message='.htmlentities("Please login"));
  exit;
}
$stmt_checkadmin = $db->prepare('SELECT admin_privilege FROM users WHERE user_id = ?');
$stmt_checkadmin->bind_param("i", $_SESSION['user_id']);
$stmt_checkadmin->execute();
$admin_privilege = $stmt_checkadmin->get_result()->fetch_array(MYSQLI_NUM)[0];
$stmt_checkadmin->close();
if (!($admin_privilege>=1)){
  header('Location: login.php?message='.htmlentities("Permission Denied"));
  exit;
}

$user_name = $_POST["user_name"];
$card_id = strtoupper(preg_replace("/[^a-fA-F0-9]/", "", $_POST["card_id"]));
$credit_balance = $_POST["credit_balance"];

$stmt_updateuserdata = $db->prepare('INSERT INTO users (user_name, card_id, credit_balance) VALUES (?, ?, ?)');
$stmt_updateuserdata->bind_param('ssd', $user_name, $card_id, $credit_balance);

if($stmt_updateuserdata->execute()){
  $stmt_updateuserdata->close();
  $stmt_getuserid = $db->prepare('SELECT user_id FROM users WHERE card_id = ?');
  $stmt_getuserid->bind_param('s', $card_id);
  $stmt_getuserid->execute();
  $getuserid_result = $stmt_getuserid->get_result()->fetch_assoc();
  $stmt_getuserid->close();
  $transaction_user_id = $getuserid_result["user_id"];
  $transaction_amount = $credit_balance;
  $transaction_initializedby_user_id = $_SESSION['user_id'];
  $stmt_log = $db->prepare('INSERT INTO transaction_log (transaction_user_id, transaction_initializedby_user_id, transaction_amount) VALUES (?, ?, ?)');
  $stmt_log->bind_param('iid', $transaction_user_id, $transaction_initializedby_user_id, $transaction_amount);
  $stmt_log->execute();
  $stmt_log->close();
  $db->close();
  header('Location: admin_portal.php?message='.htmlentities("Register Done"));
  exit;
} else {
  $stmt_updateuserdata->close();
  $db->close();
  header('Location: admin_portal.php?message='.htmlentities("Register Failed"));
  exit;
}
?>
