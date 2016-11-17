<?php
session_start();

if(isset($_SESSION['user_id'])) {
  echo("Logged in as ".$_SESSION['user_id']);
} else {
  echo("Not logged in yet");
}
?>
