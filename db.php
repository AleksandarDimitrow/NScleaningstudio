<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "nscleaning_db"; // или името, което избра

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Грешка при връзка с базата: " . mysqli_connect_error());
}
?>