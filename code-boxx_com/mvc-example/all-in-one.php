<?php
// CONNECT TO DATABASE
$pdo = new PDO(
  "mysql:host=localhost;dbname=users;charset=utf8", 
  "root", "123456", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]
);

// GET ALL USERS
$stmt = $pdo->query('SELECT * FROM `users`');

// OUTPUT HTML ?>
<!DOCTYPE htm>
<html>
<body>
<ul><?php
  while ($row = $stmt->fetch()){
    echo "<li>" . $row['name'] . "</li>";
  }
?></ul>
</body>
</html>
<?php
// COLOSE CONNECTION
$stmt = null;
$pdo = null;
?>