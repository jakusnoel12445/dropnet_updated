<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dropnet_db";

// Kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
