<?php
// Init - redirect user to home page if already signed in
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
if (is_array($_SESSION['user'])) {
	header("Location: index.php");
	die();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>
      Login Page Example
    </title>
    <link href="public/login.css" rel="stylesheet">
    <script src="public/login.js"></script>
  </head>
  <body>
    <form id="login-form" onsubmit="return login();">
      <h1>
        PLEASE SIGN IN
      </h1>
      <label for="login_email">Email</label>
      <input type="email" id="login-email" required value="admin@test.com"/>
      <label for="login_password">Password</label>
      <input type="password" id="login-password" required value="123456"/>
      <input type="submit" value="Sign In"/>
    </form>
  </body>
</html>