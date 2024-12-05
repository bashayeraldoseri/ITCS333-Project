<?php
// database connection
include('database/db.php');

// get the room ID from the URL
$Room_ID = $_GET['Room_ID'];

// delete the room from the database
$stmt = $pdo->prepare("DELETE FROM rooms WHERE Room_ID = ?");
$stmt->execute([$Room_ID]);

// redirect to the view rooms page after deletion
header("Location: viewRooms.php");
exit();
?>