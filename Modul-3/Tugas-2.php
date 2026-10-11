<?php
// Tugas 2.1
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Buah Tambahan 1";
$fruits[] = "Buah Tambahan 2";
$fruits[] = "Buah Tambahan 3";
$fruits[] = "Buah Tambahan 4";
$fruits[] = "Buah Tambahan 5";

$arrlength = count($fruits);

echo "Panjang array saat ini: " . $arrlength . "<br><br>";

for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x] . "<br>";
}

echo "<br><br>";

// Tugas 2.2
$vegies = array("Carrot", "Broccoli", "Spinach");

$arrlength = count($vegies);

for ($x = 0; $x < $arrlength; $x++) {
    echo $vegies[$x] . "<br>";
}
?>