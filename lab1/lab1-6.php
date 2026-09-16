<?php

/* Частина 1 */
echo "Hello World!";

echo "<br><br>";

/* Частина 2 */
$newString = "bob";
$newInteger = 12;
$newFloat = 12.5;
$newBool = true;

echo "Data: $newString, $newInteger, $newFloat, $newBool";
echo "<br>";
echo "Data types:", gettype($newString), ", ", gettype($newInteger), ", ", gettype($newFloat), ", ", gettype($newBool);

echo "<br><br>";

/* Частина 3 */
$string1 = "Mi ";
$string2 = "bombo";
echo $string1 . $string2;

echo "<br><br>";

/* Частина 4 */
$integer1 = 5;
if(($integer1 % 2) == 0) {
    echo "number $integer1 is even";
}
else {
    echo "number $integer1 is odd";
}
define ("PI", 3.14);

echo "<br><br>";

/* Частина 5 */
$i = 1;
for ( $i; $i <= 10; $i++ ) {
    echo $i;
    echo "<br>";
}

echo "<br><br>";

while ( $i > 1 ) {
    $i--;
    echo $i;
    echo "<br>";
}

echo "<br><br>";

/* Частина 6 */
$student = array ("name" => "Andrii", "surname" => "Korol", "speciality" => "Комп'ютерні науки");

foreach ($student as $key => $value) {
    $echoValue = $key != "speciality" ? $value . ", " : $value;
    echo $echoValue;
}

$student["grade"] = "85";
echo "<br><br>";

foreach ($student as $key => $value) {
    $echoValue = $key != "grade" ? $value . ", " : $value;
    echo $echoValue;
}
