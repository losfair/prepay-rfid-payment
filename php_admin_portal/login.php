<?php
session_start();
session_destroy();
if (isset($_GET["message"])) {
  $message = $_GET["message"];
  echo '
  <p>'.$message.'</p>
  ';
}
?>
<h1>Admin Login</h1>
<fieldset>
<legend>Login Info</legend>
<form method="post" name="login" action="authenticate.php">
<label for="username">Username: </label><input type="text" name="username" required><br>
<label for="password">Password: </label><input type="password" name="password" required><br>
<button>Login</button>
</form>
</fieldset>
