<?php
// Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'booking_system';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
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

// Fetch room equipment details from the database
$equipmentQuery = "SELECT GROUP_CONCAT(equipment.equipment_name SEPARATOR ', ') AS equipment_list
                   FROM room_equipment
                   JOIN equipment ON room_equipment.Room_equipment_id = equipment.equipment_id
                   WHERE room_equipment.room_id = ?";
$stmt2 = $pdo->prepare($equipmentQuery);
$stmt2->execute([$roomId]);
$equipment = $stmt2->fetch(PDO::FETCH_ASSOC);

// Determine background color based on department
$departmentColors = [
    'CS' => '#ffd60a',
    'CE' => '#003566',
    'IS' => '#c1121f',
    // Add more departments as needed
];

$department = $room['department'];
$bgColor = isset($departmentColors[$department]) ? $departmentColors[$department] : '#f1f3f4';
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
            background-color: #EFF1F3;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: <?php echo htmlspecialchars($bgColor); ?>;
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
        <h1><?php echo htmlspecialchars($room['Room_ID']); ?></h1>
        <div class="details">
            <p><strong>Room ID:</strong> <?php echo htmlspecialchars($room['Room_ID']); ?></p>
            <p><strong>Room Number:</strong> <?php echo htmlspecialchars($room['number']); ?></p>
            <p><strong>Capacity:</strong> <?php echo htmlspecialchars($room['Capacity']); ?></p>
            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($room['Type']); ?></p>
            <p><strong>Room Availability:</strong> <?php echo htmlspecialchars($room['Availability']); ?></p>
            <p><strong>Room Description:</strong> <?php echo htmlspecialchars($room['Description']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($room['department']); ?></p>
            <p><strong>Floor:</strong> <?php echo htmlspecialchars($room['floor']); ?></p>
            <p><strong>Room Equipment:</strong> <?php echo htmlspecialchars($equipment['equipment_list']); ?></p>
        </div>
        <p><a href="index.php">Back to Room Browsing</a></p>
    </div>
</body>
</html>
