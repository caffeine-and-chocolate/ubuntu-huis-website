<?php

$host = "sql203.infinityfree.com";
$user = "if0_39178103";
$password = "SheIsPower1";
$database = "if0_39178103_ubuntu_huis";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

?>