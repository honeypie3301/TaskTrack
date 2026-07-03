<?php

$conn = new mysqli("localhost", "root", "", "tasktrack");

if ($conn->connect_error) {
    die("DB Error");
}

/* You can move logic here later if required */

?>