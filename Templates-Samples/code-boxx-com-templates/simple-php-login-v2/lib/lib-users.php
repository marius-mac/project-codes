<?php
class Users extends DB {
  function get($email = "") {
    // get() : get specified user by email

    $user = $this->fetch(
      "SELECT * FROM `users` WHERE `user_email`=?", [$email]
    );
    return count($user) == 0 ? false : $user[0];
  }

  function check($email, $password) {
    // check() : check if the given user/password is valid
    // Get user
    $user = $this->get($email);

    // Not found
    if ($user === false) {
      return false;
    }

    // Password check fail
    if ($user['user_password'] != md5($password)) {
      return false;
    }

    // OK - return user
    return $user;
  }
}
?>