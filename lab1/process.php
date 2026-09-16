<?php
/* Частина 7 */
$name = $_POST['fname'];
$surname = $_POST['lname'];

if ($name == "" || $surname == "") {
    echo "Error: One of the fields is empty!";
    echo "<br><br>";
    echo '<a href="index.html"><button type="button">Return</button></a>';
} else if (is_numeric($name) || is_numeric($surname)) {
    echo "Error: Name or Surname can't be a number";
    echo "<br><br>";
    echo '<a href="index.html"><button type="button">Return</button></a>';
} else {
    echo "Hello, $name $surname!";
}
