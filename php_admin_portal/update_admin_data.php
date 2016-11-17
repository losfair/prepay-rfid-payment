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
if (!($admin_privilege>=2)){
  header('Location: admin_portal.php?message='.htmlentities("Permission Denied"));
  exit;
}

$user_id = $_POST["user_id"];
$admin_privilege = $_POST["admin_privilege"];
$login_username = $_POST["login_username"];
$login_password = $_POST["login_password"];

$error_in_execution = False;

$stmt_updateadmindata = $db->prepare('UPDATE users SET admin_privilege = ? WHERE user_id = ?');
$stmt_updateadmindata->bind_param('ii', $admin_privilege, $user_id);
if ($stmt_updateadmindata->execute()){
  $stmt_updateadmindata->close();
} else {
  $stmt_updateadmindata->close();
  $error_in_execution = True;
}

if ($login_username){
  $stmt_updateadmindata = $db->prepare('UPDATE users SET login_username = ? WHERE user_id = ?');
  $stmt_updateadmindata->bind_param('si', $login_username, $user_id);
  if($stmt_updateadmindata->execute()){
    $stmt_updateadmindata->close();
  } else {
    $stmt_updateadmindata->close();
    $error_in_execution = True;
  }
}

if ($login_password){
  $login_hashedpassword = password_hash($login_password, PASSWORD_DEFAULT);
  $stmt_updateadmindata = $db->prepare('UPDATE users SET login_hashedpassword = ? WHERE user_id = ?');
  $stmt_updateadmindata->bind_param('si', $login_hashedpassword, $user_id);
  if($stmt_updateadmindata->execute()){
    $stmt_updateadmindata->close();
  } else {
    $stmt_updateadmindata->close();
    $error_in_execution = True;
  }
}

$db->close();

if ($error_in_execution){
  header('Location: admin_portal.php?message='.htmlentities("Something went wrong..."));
  exit;
} else {
  header('Location: admin_portal.php?message='.htmlentities("Admin Info Updated"));
  exit;
}
?>
