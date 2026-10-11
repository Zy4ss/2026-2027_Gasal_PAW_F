<?php
// Tugas 3.1
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height = ( ";
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '", ';
}
echo " )";

echo "<br>Nilai dengan indeks terakhir: " . end($height) . "<br><br>";

unset($height["Barry"]);

foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '", ';
}

echo "<br>Nilai dengan indeks terakhir setelah dihapus: " . end($height);

echo "<br><br>";

// Tugas 3.2
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

echo 'weight = ( "Andy"=>"70", "Barry"=>"65", "Charlie"=>"75" )<br>';
echo "Data kedua: " . $weight["Barry"];

?>