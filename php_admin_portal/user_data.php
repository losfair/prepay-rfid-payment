<?php
echo "TEST ONLY<br>";
error_reporting(E_ALL);
ini_set('display_errors', 'on');

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

$user_id = $_GET["user"];

$stmt_checkadmin = $db->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt_checkadmin->bind_param('i', $user_id);
$stmt_checkadmin->execute();
$admin_data = $stmt_checkadmin->get_result()->fetch_assoc();
$stmt_checkadmin->close();
$db->close();

$user_admin_privilege = $admin_data["admin_privilege"];
if($user_admin_privilege >= 1){
  echo '<p style="color:green">This user is admin ('.$user_admin_privilege.')</p>';
}else{
  echo '<p style="color:red">This user is not an admin ('.$user_admin_privilege.').</p>';
}
echo '<br>';

if(isset($admin_data["login_username"])){
  $placeholder_login_username = $admin_data["login_username"];
  $placeholder_login_password = "••••••••";
} else {
  $placeholder_login_username = "Username";
  $placeholder_login_password = "Password";
}

echo '
<form method="post" name="admin_data" action="update_admin_data.php">
<fieldset><legend><b>User Data</b></legend>
<label for="user_id">User ID: </label>
<input type="text" name="user_id" value="'.$user_id.'" readonly><br>
<label for="admin_enabled">Name: </label>
<input type="text" min="0" max="3" step="1" name="name" value="'.$user_admin_privilege.'"><br>
<button type="submit">Change</button>
';

echo '
</form>
';
?>
