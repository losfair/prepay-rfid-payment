<head>
  <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
  <link rel="stylesheet" href="stylesheet.css">
  <link rel="stylesheet" href="chosen.css">
</head>
<body>
<h1>User Info</h1>
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

$transaction_initializedby_user_id = $_SESSION['user_id'];

$users_query = $db->query('SELECT user_name, user_id FROM users');
while ($user = $users_query->fetch_assoc()){
  $users[] = $user;
}

$terminals_query = $db->query('SELECT terminal_name, terminal_id FROM terminals');
while ($terminal = $terminals_query->fetch_assoc()){
  $terminals[] = $terminal;
}

$db->close();

if (isset($_GET["message"])) {
  $message = $_GET["message"];
  echo '
  <p>'.$message.'</p>
  ';
}

echo '
<a href="logout.php">Log out</a><br>
';

echo '
<form method="post" name="transaction" action="transaction.php">
<fieldset><legend><b>Top-up</b></legend>
<label for="user">Select the target account:</label><br>
<select data-placeholder="Choose a user..." class="chosen-select" name="user" required>
<option value=""></option>
';
foreach ($users as $user){
  echo '<option value="'.$user["user_id"].'">'.$user["user_name"].'</option>';
}
echo '
</select><br>
<label for="amount">Amount: </label>
<input type="number" name="amount" required>
<br>
<button type="submit">Process Payment</button>
</fieldset>
</form>
';

echo '
<form method="get" name="admin_data" action="terminal_config.php">
<fieldset><legend><b>Terminal Config</b></legend>
<label for="user">Select a terminal:</label><br>
<select data-placeholder="Choose a terminal..." class="chosen-select" name="terminal" required>
<option value=""></option>
';
foreach ($terminals as $terminal){
  echo '<option value="'.$terminal["terminal_id"].'">'.$terminal["terminal_name"].'</option>';
}
echo '
</select>

<br>
<button type="submit">Search</button>
</fieldset>
</form>
';

echo '
<form method="post" name="register_user" action="register_user.php">
<fieldset><legend><b>Register User</b></legend>
<label for="user_id">Name: </label>
<input type="text" name="user_name" placeholder="John Doe" required><br>
<label for="login_username">Card ID: </label>
<input type="text" name="card_id" placeholder="8015D4DE" required><br>
<label for="credit_balance">Inital Credit: </label>
<input type="number" name="credit_balance" required>
<br>
<button type="submit">Register</button>
</fieldset>
</form>
';


echo '
<form method="get" name="admin_data" action="admin_data.php">
<fieldset><legend><b>Admin Data</b></legend>
<label for="user">Select a user:</label><br>
<select data-placeholder="Choose a user..." class="chosen-select" name="user" required>
<option value=""></option>
';
foreach ($users as $user){
  echo '<option value="'.$user["user_id"].'">'.$user["user_name"].'</option>';
}
echo '
</select>

<br>
<button type="submit">Search</button>
</fieldset>
</form>
';


if($admin_privilege>=3) {
  echo '
  <fieldset><legend><h2>Experimental</h2></legend>
  ';

  echo '
  <form method="get" name="user_data" action="user_data.php">
  <fieldset><legend><b>User Data</b></legend>
  <label for="user">Select a user:</label><br>
  <select data-placeholder="Choose a user..." class="chosen-select" name="user" required>
  <option value=""></option>
  ';
  foreach ($users as $user){
    echo '<option value="'.$user["user_id"].'">'.$user["user_name"].'</option>';
  }
  echo'
  </select>
  <br>
<button type="submit">Search</button>
  </fieldset>
  </form>
  ';

  echo '
  </fieldset>
  ';
}
?>
</body>
<script src="jquery.js"></script>
<script src="chosen.jquery.js" type="text/javascript"></script>
<script>$(".chosen-select").chosen();</script>
