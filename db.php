<?php

$host = 'localhost';
$user = 'root'; // default username for XAMPP/MAMP
$password = ''; // default password for XAMPP/MAMP
$dbname = 'booking_system';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>