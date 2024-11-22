
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

// Fetch rooms from the database
$query = "SELECT * FROM rooms";
$stmt = $pdo->query($query);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Browsing</title>
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
        .room {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #d2e3fc;
        }
        .room a {
            text-decoration: none;
            color: #1a73e8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Available Rooms</h1>
        <?php foreach ($rooms as $room): ?>
        <div class="room">
            <h2><?php echo htmlspecialchars($room['Room_ID']); ?></h2>
            <p>Capacity: <?php echo htmlspecialchars($room['Capacity']); ?></p>
            <p>Available Slots: <?php echo htmlspecialchars($room['Availability']); ?></p>
            <a href="room_details.php?id=<?php echo $room['room_id']; ?>">View Details</a>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
