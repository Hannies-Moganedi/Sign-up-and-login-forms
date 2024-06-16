<?php

$servername = "Your server name";
$dBUsername = "database username";
$dBPassword = "";
$dBName = "database name";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}
?>
