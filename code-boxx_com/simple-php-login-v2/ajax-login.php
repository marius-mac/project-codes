<?php
// INIT
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
require PATH_LIB . "lib-db.php";
require PATH_LIB . "lib-users.php";
$libUsr = new Users();

// HANDLE AJAX REQUEST
switch ($_POST['req']) {
  // Invalid request
  default:
    echo "ERR";
    break;

  // Sign In
  case "in":
    // Already signed in
    if (is_array($_SESSION['user'])) {
      die("OK");
    }

    // Check user email/password
    $user = $libUsr->check($_POST['email'], $_POST['password']);
    if ($user===false) { echo "ERR"; }
    else {
      $_SESSION['user'] = [
        "name" => $user['user_name'],
        "email" => $user['user_email'],
        "status" => $user['user_status'],
        "data" => $user['user_data']
      ];
      echo "OK";
    }
    break;

  // Sign out
  case "out":
    unset ($_SESSION['user']);
    echo "OK";
    break;
}
?>