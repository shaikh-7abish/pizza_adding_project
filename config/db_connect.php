<?php

$serverName = 'localhost';
$userName = 'root';
$password = 'password';
$db = 'pizza';

// connect to database
$conn = mysqli_connect($serverName, $userName, $password, $db);

// checking connection
if (!$conn) {
    echo 'error' . '<br>' . mysqli_connect_error();
}
