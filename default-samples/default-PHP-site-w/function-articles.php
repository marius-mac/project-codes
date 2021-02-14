<?php

// uzduotis 1.1
// sukurti f-ja getArticle($id);

// uzduotis 1.2
 // grazina  straipnsni pagal autoriaus ID. Pirma, jeigu ju yra daugiau
// sukurti f-ja getArticleByUserId($id);

 // uzduotis 2
 // sukurti f-ja createArticle( )

 // uzduotis 3
 // sukurti f-ja deleteArticle( )

 // uzduotis 4
 // sukurti f-ja editeArticle(  );
 // uzduotis 5
 // sukurti f-ja getArticles();




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
function getArticle($id) {
    $sql = "SELECT * FROM articles
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

   // $straipsnis = getArticle(1);
   // echo "ID: " . $straipsnis['id'] . "<br />";
   // echo "<h2>Antraste: " . $straipsnis['title'] . "</h2><br />";
   // echo "<i> " . $straipsnis['content'] . "</i><br />";
   // echo "Data: " . $straipsnis['date'] . "<br />";
   // echo "Autoriaus id: " . $straipsnis['user_id'] . "<br />";



// uzduotis 2
// sukurti f-ja createUser($uname, $password, $elpastas, $teises)
function createArticle($antraste, $turinys, $user_id ) {
    $sql_string = sprintf("INSERT INTO articles
                       VALUES ('', '%s', '%s', NOW(), $user_id)",
                         mysqli_real_escape_string (getConnection(), $antraste),
                         mysqli_real_escape_string (getConnection(),  $turinys)
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

// createArticle('Antraste - kala medi', 'Turinys tratata' , 1);

function deleteArticle ($x) {
    $sql_text =  "DELETE FROM articles WHERE id = $x";
    $arPavykoSQL = mysqli_query(getConnection(), $sql_text);
    if (!$arPavykoSQL) {  //  ($arVeikia == false)
        echo "ERROR: " . mysqli_error(getConnection());
    }
}
// deleteArticle(2);


function editArticle($id, $antraste, $turinys, $data, $vart_id) {
    $sql_text = sprintf("UPDATE articles
                            SET
                                title = '%s',
                                content = '%s',
                                user_id = '$vart_id'
                            WHERE id = $id
                         ",
                              mysqli_real_escape_string (getConnection(), $antraste),
                              mysqli_real_escape_string (getConnection(),  $turinys)
                       );
    $arPavykoSQL = mysqli_query(getConnection(), $sql_text);
    if (!$arPavykoSQL) {  //  ($arVeikia == false)
        echo "ERROR: " . mysqli_error(getConnection());
    }
}
// $tt = getArticle(4);
// editArticle($tt['id'], 'Kaunas svencia Rudeni', $tt['content'],  $tt['date'], $tt['user_id']);
// editArticle($tt['id'], 'Kaunas svencia Rudeni', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",  $tt['date'], 2);


// uzduotis 5 getUsers()
function getArticles($kiekis = 999999) {
    $sql_text = "SELECT * FROM articles
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

$allArticles = getArticles();
// tikriname ar DB radome vartotoju - ar turime duomenu
if ($allArticles != null) {
                                //     // mysqli_fetch_row -  duomenis (is sekancios eilutes) sudeda i masyva (paprasta [0])
                                //     // mysqli_fetch_assoc - duomenis (is sekancios eilutes) sudeda i  masyva  ['id']
                                //     // mysqli_fetch_array - duomenis (is sekancios eilutes) sudeda i  masyva  ['id'] ir paprasta [0]
    $straipsnis = mysqli_fetch_assoc($allArticles);
     while ($straipsnis) {
             echo "ID: " . $straipsnis['id'] . "<br />";
             echo "<h2>Antraste: " . $straipsnis['title'] . "</h2><br />";
             echo "<i>" . $straipsnis['content'] . "</i><br />";
             echo "Data: " . $straipsnis['date'] . "<br />";
             echo "Autoriaus id: " . $straipsnis['user_id'] . "<br />";
             echo " ===============================================<br /><br />";
              $straipsnis = mysqli_fetch_array(  $allArticles  ); // imame sekancios eilutes duomenis
     }
}
// atsijunget nuo DB
mysqli_close(getConnection());
