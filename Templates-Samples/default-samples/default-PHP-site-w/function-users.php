<?php


// uzduotis 1
// sukurti f-ja getUser($id);
 // uzduotis 2
 // sukurti f-ja createUser($uname, $password, $elpastas, $teises)
 // uzduotis 3
 // sukurti f-ja deleteUser($id)
 // uzduotis 4
 // sukurti f-ja editeUser($id, $uname, $password, $elpastas, $teises);
 // uzduotis 5
 // sukurti f-ja getUsers();



    // define - konstantos
   define( "DB_NAME", 'savaite4');
   define( "HOST", 'localhost');
   define( "DB_USERNAME", 'tautvydasDelete');  // root
   define( "DB_PASS", 'tratata');            // root


   $connection = mysqli_connect( HOST, DB_USERNAME, DB_PASS, DB_NAME);

   if ($connection) {
       echo "Prisijungti prie DB pavyko <br>";
   } else {
       die ("ERROR: prisijungti napavyko, nes: " . mysqli_connect_error());
   }
   // Change character set to utf8
   // ijungima lietuvyves
   mysqli_set_charset($connection,"utf8"); 


   function getConnection() {
       global $connection;
       return $connection;
   }

   // paimti konkretu vartotoja pagal jo id
   function getUser($id) {
       $sql = "SELECT * FROM users
              WHERE id = $id";
       $rezultatai = mysqli_query(getConnection(), $sql);
       if ($rezultatai) {
           //    echo "getUser Suveike";
           // gryzusisu duomenis is DB sudedame i masyva
           $rezultatai = mysqli_fetch_assoc($rezultatai);
           return $rezultatai;
       } else {
           echo "ERROR: getUser nesuveike!!!!!!";
           return null;
       }
   }

      $vartotojas = getUser(7);
      echo "Vartotojo id: " . $vartotojas['id'] . "<br />";
      echo "Vartotojo vardas: " . $vartotojas['username'] . "<br />";
      echo "Vartotojo slaptazodis: " . $vartotojas['pass'] . "<br />";
      echo "Vartotojo el. pastas: " . $vartotojas['email'] . "<br />";
      echo "Vartotojo el. teises: " . $vartotojas['rights'] . "<br />";


   // paimti konkretu vartotoja pagal jo id
   function getNewestUser() {
       $sql = "SELECT * FROM users
              ORDER BY id DESC
              LIMIT 1";
       $rezultatai = mysqli_query(getConnection(), $sql);
       if ($rezultatai) {
           //    echo "getUser Suveike";
           // gryzusisu duomenis is DB sudedame i masyva
           $rezultatai = mysqli_fetch_assoc($rezultatai);
           return $rezultatai;
       } else {
           echo "ERROR: getUser nesuveike!!!!!!" . mysqli_error(getConnection());
           return null;
       }
   }


   $vartotojas = getNewestUser();
   echo "Vartotojo id: " . $vartotojas['id'] . "<br />";
   echo "Vartotojo vardas: " . $vartotojas['username'] . "<br />";
   echo "Vartotojo slaptazodis: " . $vartotojas['pass'] . "<br />";
   echo "Vartotojo el. pastas: " . $vartotojas['email'] . "<br />";
   echo "Vartotojo el. teises: " . $vartotojas['rights'] . "<br />";




   // uzduotis 2
   // sukurti f-ja createUser($uname, $password, $elpastas, $teises)
   function createUser($uname, $password, $elpastas ) {
    //    $sql_string = "INSERT INTO users
    //                   VALUES ('', '$uname', '$password', '$elpastas')";
       // ARBA SAUGIAU
       $sql_string = sprintf("INSERT INTO users
                          VALUES ('', '%s', '%s', '%s', 'subscriber')",
                            mysqli_real_escape_string (getConnection(), $uname),
                            // mysqli_real_escape_string (getConnection(), md5($password)),
                            mysqli_real_escape_string (getConnection(),  password_hash($password, PASSWORD_DEFAULT) ),
                            mysqli_real_escape_string (getConnection(), $elpastas)
                     );
      // https://www.w3schools.com/php/func_mysqli_real_escape_string.asp
     // mysqli_real_escape_string - Required. The string to be escaped. Characters encoded are NUL (ASCII 0), \n, \r, \, ', ", and Control-Z.

     // $first_name = htmlspecialchars( $first_name );
     // $first_name = strip_tags( $first_name );
        $arVeikia = mysqli_query(getConnection(), $sql_string);
        if (!$arVeikia) {  //  ($arVeikia == false)
            echo "ERROR: " . mysqli_error(getConnection());
        }
   }
   // createUser('Kasdf/is', 'blaslal' , 'aaa@a.lt' );
     $vartotojas = getNewestUser();
   echo "Vartotojo id: " . $vartotojas['id'] . "<br />";
   echo "Vartotojo vardas: " . $vartotojas['username'] . "<br />";
   echo "Vartotojo slaptazodis: " . $vartotojas['pass'] . "<br />";
   echo "Vartotojo el. pastas: " . $vartotojas['email'] . "<br />";
   echo "Vartotojo el. teises: " . $vartotojas['rights'] . "<br />";

   function deleteUser ($x) {
       $sql_text =  "DELETE FROM users WHERE id = $x";
       $arPavykoSQL = mysqli_query(getConnection(), $sql_text);
       if (!$arPavykoSQL) {  //  ($arVeikia == false)
           echo "ERROR: " . mysqli_error(getConnection());
       }
   }
   // deleteUser(3);


   function editUser($id, $name, $password, $email, $rights) {
       $sql_text = " UPDATE users
                     SET id = '$id',
                         username = '$name',
                        pass = '$password',
                        email = '$email',
                        rights = '$rights'
                    WHERE id = $id " ;
       $arPavykoSQL = mysqli_query(getConnection(), $sql_text);
       if (!$arPavykoSQL) {  //  ($arVeikia == false)
           echo "ERROR: " . mysqli_error(getConnection());
       }
   }
   $petras = getUser(10);
   editUser($petras['id'], 'karlosas', $petras['pass'], "kaunas@info.lt", $petras['rights']);
   // editUser(5, 'Karolis','Karolis','Karolis','Karolis');


   // uzduotis 5 getUsers()
   function getUsers($kiekis = 999999) {
       $sql_text = "SELECT * FROM users
                    ORDER BY id DESC
                    LIMIT $kiekis;";
       $rezultatai = mysqli_query(getConnection(), $sql_text);
       // patikriname ar radome vartotoju
       // mysqli_num_rows - suskaiciuoja kiek rado rezultatu
       if (mysqli_num_rows($rezultatai) > 0 ) {
            return $rezultatai;
       } else {
           echo "ERROR: " . mysqli_error(getConnection());
           return null;
       }
   }

   $allUsers = getUsers(4);
   // tikriname ar DB radome vartotoju - ar turime duomenu
   if ($allUsers != null) {
       // mysqli_fetch_row -  duomenis (is sekancios eilutes) sudeda i masyva (paprasta [0])
       // mysqli_fetch_assoc - duomenis (is sekancios eilutes) sudeda i  masyva  ['id']
       // mysqli_fetch_array - duomenis (is sekancios eilutes) sudeda i  masyva  ['id'] ir paprasta [0]
       $userData = mysqli_fetch_array($allUsers);
        while ($userData) {
                echo " vartotojo id: " . $userData['id'] . "<br />";
                echo " vartotojo vardas: " . $userData['username'] . "<br />";
                echo " vartotojo slaptazodis: " . $userData['pass'] . "<br />";
                echo " vartotojo el pastas: " . $userData['email'] . "<br />";
                echo " vartotojo teises: " . $userData['rights'] . "<br />";
                echo " ===============================================<br /><br />";
                // mysqli_fetch_row -  duomenis (is sekancios eilutes) sudeda i masyva (paprasta [0])
                // mysqli_fetch_assoc - duomenis (is sekancios eilutes) sudeda i  masyva  ['id']       // mysqli_fetch_array - duomenis (is sekancios eilutes) sudeda i  masyva  ['id'] ir paprasta [0]
                $userData = mysqli_fetch_array($allUsers); // imame sekancios eilutes duomenis
        }
   }
   // atsijunget nuo DB
   mysqli_close(getConnection());













// if( mysqli_num_rows($result) > 0 ) {






   //
