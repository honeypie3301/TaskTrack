<?php

$conn = new mysqli("localhost", "root", "", "tasktrack");

if ($conn->connect_error) {
    die("DB Error");
}


?>
