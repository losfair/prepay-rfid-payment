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

$terminal_id = $_GET["terminal"];

$stmt_terminalconfig = $db->prepare('SELECT * FROM terminals WHERE terminal_id = ?');
$stmt_terminalconfig->bind_param('i', $terminal_id);
$stmt_terminalconfig->execute();
$terminal_config = $stmt_terminalconfig->get_result()->fetch_assoc();
$stmt_terminalconfig->close();
$db->close();

if($terminal_config['terminal_enabled']){
  $terminal_enabled_checked = 'checked';
}else{
  $terminal_enabled_checked = '';
}
echo '
<form method="post" name="admin_data" action="update_terminal_config.php">
<fieldset><legend><b>Terminal Configuration</b></legend>
<label for="terminal_id">Terminal ID: </label>
<input type="text" name="terminal_id" value="'.$terminal_id.'" readonly><br>
<label for="terminal_name">Terminal Name: </label>
<input type="text" name="terminal_name" value="'.$terminal_config["terminal_name"].'" readonly><br>
<label for="terminal_enabled">Enabled: </label>
<input type="checkbox" value="1" name="terminal_enabled" '.$terminal_enabled_checked.'><br>
<label for="terminal_amount">Amount: </label>
<input type="number" min="-5" max="0" step="0.25" name="terminal_amount" placeholder="'.$terminal_config["terminal_amount"].'"><br>
<label for="terminal_message">Message: </label>
<input type="text" name="terminal_message" placeholder="'.$terminal_config["terminal_message"].'"><br>
<button type="submit">Change</button>
';
echo '
</form>
';
?>
