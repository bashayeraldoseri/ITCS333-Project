<?php

$host = 'localhost';
$user = 'root'; // default username for XAMPP/MAMP
$password = ''; // your password for the database
$dbname = 'booking_system';
$port = 3306; // Default MySQL port is 3306, use 8080 if it's a non-standard port for your database server

try {
    // Create PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
    $conn = new PDO($dsn, $user, $password);

    // Set PDO error mode to exception for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection failure
    die("Connection failed: " . $e->getMessage());
}
?>