<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

// Tugas 1.1
$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo "fruits = ( ";
foreach ($fruits as $buah) {
    echo '"' . $buah . '", ';
}
echo ")<br>";

$highest_index = max(array_keys($fruits));
echo "Nilai dengan indeks tertinggi: " . $fruits[$highest_index];

echo "<br><br>";

// Tugas 1.2
echo "Data " . $fruits[1] . " dihapus<br>";
unset($fruits[1]);

echo "fruits = ( ";
foreach ($fruits as $buah) {
    echo '"' . $buah . '", ';
}
echo ")<br>";

$highest_index = max(array_keys($fruits));
echo "Nilai dengan indeks tertinggi: " . $fruits[$highest_index];

?>