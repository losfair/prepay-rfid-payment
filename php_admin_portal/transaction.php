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

$transaction_user_id = $_POST["user"];
$transaction_amount = $_POST["amount"];

$transaction_initializedby_user_id = $_SESSION['user_id'];

$stmt_transaction = $db->prepare('UPDATE users SET credit_balance = credit_balance + ? WHERE user_id = ?');
$stmt_transaction->bind_param('is', $transaction_amount, $transaction_user_id);
if($stmt_transaction->execute()){
  $stmt_transaction->close();
  $stmt_log = $db->prepare('INSERT INTO transaction_log (transaction_user_id, transaction_initializedby_user_id, transaction_amount) VALUES (?, ?, ?)');
  $stmt_log->bind_param('iid', $transaction_user_id, $transaction_initializedby_user_id, $transaction_amount);
  $stmt_log->execute();
  $stmt_log->close();
  $db->close();
  header('Location: admin_portal.php?message='.htmlentities("Transaction Done"));
  exit;
} else {
  $db->close();
  header('Location: admin_portal.php?message='.htmlentities("Transaction failed"));
  exit;
}
?>
