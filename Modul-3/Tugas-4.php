<?php
// Tugas 4.1
$height = array(
    "Andy" => "176",
    "Barry" => "165",
    "Charlie" => "170",
    "David" => "180",
    "Ethan" => "172",
    "Frank" => "168",
    "George" => "175",
    "Harry" => "182"
);

echo "height = ( ";
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '", ';
}
echo " )<br><br>";

foreach ($height as $nama => $tinggi) {
    echo "$nama is $tinggi cm tall.<br>";
}

echo "<br><br>";

// Tugas 4.2
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

echo "weight = ( ";
foreach ($weight as $nama => $berat) {
    echo '"' . $nama . '"=>"' . $berat . '", ';
}
echo " )<br><br>";

$nama = array_keys($weight);

for ($i = 0; $i < count($weight); $i++) {
    echo $nama[$i] . " is " . $weight[$nama[$i]] . " kg.<br>";
}

?>