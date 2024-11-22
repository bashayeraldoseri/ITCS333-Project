<?php
// Database Connection
$host = '127.0.0.1';
$user = 'root'; 
$password = ''; 
$dbname = 'booking_system';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get room ID from the query string
$roomId = isset($_GET['Room_ID']) ? intval($_GET['Room_ID']) : 0;

// Fetch room details from the database
$query = "SELECT * FROM rooms WHERE Room_ID = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$roomId]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    die("Room not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f3f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #1a73e8;
        }
        .details {
            background-color: #d2e3fc;
            padding: 15px;
            border-radius: 6px;
        }
        .details p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($room['room_name']); ?></h1>
        <div class="details">
            <p><strong>Capacity:</strong> <?php echo htmlspecialchars($room['Capacity']); ?></p>
            <p><strong>Equipment:</strong> <?php echo htmlspecialchars($room['equipment']); ?></p>
            <p><strong>Availability:</strong> <?php echo htmlspecialchars($room['Availability']); ?></p>
        </div>
        <p><a href="room_browsing.php">Back to Room Browsing</a></p>
    </div>
</body>
</html>
