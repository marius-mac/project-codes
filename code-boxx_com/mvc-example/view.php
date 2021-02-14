<!DOCTYPE htm>
<html>
<body>
<ul><?php
  require "database.php";
  require "users.php";
  $users = new Users();
  foreach ($users->get() as $u) {
    echo "<li>" . $u['name'] . "</li>";
  }
?></ul>
</body>
</html>