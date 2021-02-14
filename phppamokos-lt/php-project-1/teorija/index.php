<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php

//-----------4. Pradžia ir pirmieji PHP skriptai
//------------Pirmasis PHP skriptas

//echo "Labas rytas";

//-----------Funkcija include() ir projekto suskirstymas

/*
...
include('header.php');
include('template/footer.php');
*/

//-------------5. Kintamieji ir matematika
//------------ Kintamųjų išvedimas į ekraną

/*
$text = "Labas rytas";
echo $text . ", Lietuva!";
$price = 1.23;
$amount = 3;
$sum = $price * $amount;
echo "Suma: " . $sum . " Lt (" . $price . " Lt x" . $amount . ")";
*/

//-----------6. Darbas su tekstais
//----------- Funkcijos darbui su tekstais

//$kaina = 3.14;
//echo "Kaina parduotuvėje buvo $kaina Lt";

//$eilute = "Lietuva";
//echo substr($eilute, -5); // išves "etuva" - penkis simbolius nuo galo



//-----------7. Sąlygos sakiniai: IF...ELSE
//-----------IF .. ELSE

/*
$line = "Labas rytas";
$line2 = "Labas rytas tik du kartus";
$length = strlen($line);
if ($length > 20) {
  echo "eilutė ilgesnė už 20 simbolių (".$length.")";
} else {
  echo "eilutė trumpesnė už 20 simbolių (".$length.")";
}
*/

//-----------Operatorius SWITCH .. CASE

//$vieta = "1";

/*
if ($vieta == 1) { echo "Pirma vieta"; }
else if ($vieta == 2) { echo "Antra vieta"; }
else if ($vieta == 3) { echo "Trečia vieta"; }
// ... dar kitos sąlygos
else if ($vieta == 10) { echo "Dešimta vieta"; }
else { echo "Nebaigė trasos"; }
*/

/*
switch ($vieta) {
  case 1: echo "Pirma vieta"; break;
  case 2: echo "Antra vieta"; break;
  case 3: echo "Trečia vieta"; break;
  // ... dar kitos sąlygos
  case 10: echo "Ketvirta vieta"; break;
  default: echo "Nebaigė trasos"; break;
}
*/


//-------------8. Ciklai: WHILE, FOR ir FOREACH
//-----------Ciklas WHILE

/*
$hour = 0;
while ($hour <= 24) {
  echo $hour . "-a valanda<br />";
  $hour = $hour + 1;
}
*/

//------------Atvirkščias ciklas DO .. WHILE

/*
$hour = 0;
do {
  echo $hour . "-a valanda<br />";
  $hour = $hour + 1;
} while ($hour <= 24);
*/

//---------Ciklas FOR

/*
echo "<select name='pasirinkimas'>";
for ($i=1; $i <= 100; $i++) {
  echo "<option value=$i>$i</option>";
}
echo "</select>";
*/

//------------Ciklas FOREACH

/*
...
foreach (MASYVAS as MASYVO_ELEMENTAS) {
  // atliekami veiksmai su masyvo elementu
}
arba
foreach (MASYVAS as RAKTAS => REIKŠMĖ) {
  // atliekami veiksmai su raktu ir/arba reikšme
}
*/

//---------Ciklai cikluose

/*
...
for ($i=1; $i <= 10; $i++) {
  for ($j=1; $j <= 5; $j++) {
    if ($i > 5 && $j > 2) echo $i . " - " . $j;
  }
}
*/

//--------------9. Masyvai ir jų naudojimas

// $masyvas = array();
// $stud = array(15, 10, 5); // =*
// $stud = [15, 10, 5]; // =*

/*
$masyvas = [10, 8, 9, 7];
$masyvas[] = 2; // prideda dar 2
echo count($masyvas);
// į ekraną bus išvestas skaičius 5, nes masyve yra penki elementai
*/

//---------------Vidurkio skaičiavimas: masyvo apdorojimas cikle FOR

/*
$pazymiai = array(10, 8, 7, 2, 4, 10, 9, 8, 7, 5, 6, 7, 8, 9, 10, 3);
// užpildome duomenis
$suma = 0; // pažymių suma - pradžioje ji lygi nuliui
$pazymiu_skaicius = count($pazymiai); // kiek iš viso turime pažymių
for ($i=0; $i < $pazymiu_skaicius; $i++) {
  $suma = $suma + $pazymiai[$i];
  // prie sumos pridedame einamąjį pažymį su elementu $i
}
$vidurkis = $suma / $pazymiu_skaicius; // skaičiuojame vidurkį
echo $vidurkis; // rodomas galutinis atsakymas
*/

//-----------Masyvai su tekstiniais raktais: ciklas FOREACH

/*
$pazymiai['petriukas'] = 10;
$pazymiai['maryte'] = 8;
$pazymiai['blogas_mokinys'] = 2;
foreach ($pazymiai as $vardas => $pazymys) { // foreach ($masyvas as $raktas => $reiksme)
  echo $vardas . " --- " . $pazymys . "<br />";
}
*/

/*
$pazymiai = array(10, 9, 10, 7);
for ($i=0; $i < count($pazymiai); $i++) {
  echo $pazymiai[$i] . " ";
}
*/


//$masyvas = array(9,8,7,9,5,2,8,10);
//if (in_array(10, $masyvas)) { echo "Yra dešimtukų"; }



//-----------Masyvas masyve, arba multidimensional arrays

/*
$mokiniai = array(
  array(
    'name' => 'Petriukas',
    'surname' => 'Jonaitis',
    'average' => '7.98'
  ),
  array(
    'name' => 'Joniukas',
    'surname' => 'Petraitis',
    'average' => '8.43'
  ),
  array(
    'name' => 'Marytė',
    'surname' => 'Marytaitė',
    'average' => '9.72'
  )
);

foreach ($mokiniai as $mok) {
  echo $mok['name'] . ' ' . $mok['surname'] . ': ' . $mok['average'] . '<br />';
}
*/

//--------------10. $_GET ir skripto parametrai


?>

<br><br>

<?php

?>

<br><br>

<?php

?>

</body>
</html>
