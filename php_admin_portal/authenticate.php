<?php
session_start();

$db = new mysqli('localhost', 'nfc_payment', 'z4d0Xy6iwtFE4SIN', 'nfc_payment');

$login_data = json_decode(file_get_contents("php://input"), true);
$login_username = $login_data["username"];
$login_password = $login_data["password"];

if(!is_string($login_username) || !is_string($login_password)) {
  exit("Bad arguments");
}

$stmt_login = $db->prepare('SELECT user_id, login_hashedpassword FROM users WHERE login_username = ?');
$stmt_login->bind_param('s', $login_username);
$stmt_login->execute();
$login_info = $stmt_login->get_result()->fetch_assoc();
$stmt_login->close();

$user_id = $login_info["user_id"];
$login_hashedpassword = $login_info["login_hashedpassword"];

if (password_verify($login_password, $login_hashedpassword)){
  if (password_needs_rehash($login_hashedpassword, PASSWORD_DEFAULT)){
    {
        $new_hashedpassword = password_hash($login_password, PASSWORD_DEFAULT);
        $stmt_updatepassword = $db->prepare('UPDATE admin_data SET login_hashedpassword = ? WHERE login_username = ?');
        $stmt_updatepassword->bind_param('ss', $new_hashedpassword, $login_username);
        $stmt_updatepassword->execute();
        $stmt_updatepassword->close();
    }
  }
  $db->close();
  $_SESSION['user_id'] = $user_id;
  echo json_encode(array(
    "err" => 0,
    "msg" => "Logged in",
    "location" => "admin_portal.php"
  ));
  exit();
} else {
  $db->close();
  echo json_encode(array(
    "err" => 1000,
    "msg" => "Unable to log in"
  ));
  exit();
}
?>
