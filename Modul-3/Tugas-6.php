<?php
$array = array("A");

echo 'Array awal: ("A")<br>';

array_push($array, "B");

echo "Hasil array_push: ";
foreach ($array as $data) {
    echo $data . " ";
}
echo "<br><br>";


$array1 = array("A", "B");
$array2 = array("C");

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$array = array_merge($array1, $array2);

echo "Hasil array_merge: ";
foreach ($array as $data) {
    echo $data . " ";
}
echo "<br><br>";


$array = array("x" => 1, "y" => 2);

echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$array = array_values($array);

echo "Hasil array_values: ";
foreach ($array as $data) {
    echo $data . " ";
}
echo "<br><br>";


$array = array("A", "B", "C");

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $array);
echo "<br><br>";


$array = array(0, 1, false, 2, "", 3, "array");

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$hasil = array_filter($array);

echo "Hasil array_filter: ";
foreach ($hasil as $data) {
    echo $data . " ";
}
echo "<br><br>";


$array = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

sort($array);

echo "Hasil sort: ";
foreach ($array as $data) {
    echo $data . " ";
}
echo "<br>";

rsort($array);

echo "Hasil rsort: ";
foreach ($array as $data) {
    echo $data . " ";
}
echo "<br><br>";


$array = array("Peter" => 35, "Ben" => 37, "Joe" => 43);

echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($array);

echo "Hasil asort: ";
foreach ($array as $nama => $umur) {
    echo "$nama=> $umur, ";
}
echo "<br>";

arsort($array);

echo "Hasil arsort: ";
foreach ($array as $nama => $umur) {
    echo "$nama=> $umur, ";
}
echo "<br>";

ksort($array);

echo "Hasil ksort: ";
foreach ($array as $nama => $umur) {
    echo "$nama=> $umur, ";
}
echo "<br>";

krsort($array);

echo "Hasil krsort: ";
foreach ($array as $nama => $umur) {
    echo "$nama=> $umur, ";
}

?>