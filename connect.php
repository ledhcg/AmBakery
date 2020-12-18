<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "db_bakery";
$connect = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
if ($connect) {
    $setLang = mysqli_query($connect, "SET NAMES 'utf8'");
} else {
    die("Connection Refused" . mysqli_connect_error());
}
