<?php
// database connection
$pdo = new PDO("mysql:host=localhost;dbname=booking_system", "root", "");

// get the room ID from the URL
$id = $_GET['id'];

// delete the room from the database
$stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
$stmt->execute([$id]);

// redirect to the view rooms page after deletion
header("Location: viewRooms.php");
exit();
?>