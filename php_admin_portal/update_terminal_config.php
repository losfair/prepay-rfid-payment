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

var_dump($_POST);
$terminal_id = $_POST["terminal_id"];
$terminal_enabled = (isset($_POST["terminal_enabled"]) && $_POST["terminal_enabled"]);
$terminal_amount = $_POST["terminal_amount"];
$terminal_message = $_POST["terminal_message"];

$error_in_execution = False;

$stmt_updateterminalconfig = $db->prepare('UPDATE terminals SET terminal_enabled = ? WHERE terminal_id = ?');
$stmt_updateterminalconfig->bind_param('ii', $terminal_enabled, $terminal_id);
if ($stmt_updateterminalconfig->execute()){
  $stmt_updateterminalconfig->close();
} else {
  $stmt_updateterminalconfig->close();
  $error_in_execution = True;
}

if ($terminal_amount){
  $stmt_updateterminalconfig = $db->prepare('UPDATE terminals SET terminal_amount = ? WHERE terminal_id = ?');
  $stmt_updateterminalconfig->bind_param('di', $terminal_amount, $terminal_id);
  if($stmt_updateterminalconfig->execute()){
    $stmt_updateterminalconfig->close();
  } else {
    $stmt_updateterminalconfig->close();
    $error_in_execution = True;
  }
}

if ($terminal_message){
  $stmt_updateterminalconfig = $db->prepare('UPDATE terminals SET terminal_message = ? WHERE terminal_id = ?');
  $stmt_updateterminalconfig->bind_param('si', $terminal_message, $terminal_id);
  if($stmt_updateterminalconfig->execute()){
    $stmt_updateterminalconfig->close();
  } else {
    $stmt_updateterminalconfig->close();
    $error_in_execution = True;
  }
}

$db->close();

if ($error_in_execution){
  header('Location: admin_portal.php?message='.htmlentities("Something went wrong..."));
  exit;
} else {
  header('Location: admin_portal.php?message='.htmlentities("Terminal Config Updated"));
  exit;
}
?>
