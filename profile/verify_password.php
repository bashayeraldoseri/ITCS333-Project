<?php
session_start();
include('../database/db.php');

$data = json_decode(file_get_contents('php://input'), true);
$enteredPassword = $data['password'];

$userId = $_SESSION['user_id']; 

$query = "SELECT password FROM users WHERE id = :userId";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$hashedPassword = $stmt->fetchColumn();

if ($hashedPassword && password_verify($enteredPassword, $hashedPassword)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
