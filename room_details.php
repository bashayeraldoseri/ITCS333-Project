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
    'CS' => '#F8DE7E',
    'CE' => '#A3BFEF',
    'IS' => '#D35B6B',
];

$department = $room['department'];
$bgColor = isset($departmentColors[$department]) ? $departmentColors[$department] : '#f1f3f4';

// Room availability and floor information
$roomFloor = match ($room['floor']) {
    '0' => 'Ground Floor',
    '1' => 'First Floor',
    '2' => 'Second Floor',
    default => 'Not Specified',
};

$roomAvailability = $room['Availability'] == '1' ? 'Available' : 'Not Available';
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 90%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .details {
            padding: 20px;
            border-radius: 8px;
            background-color: <?php echo htmlspecialchars($bgColor); ?>;
            color: #272727;
        }

        .details p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .details strong {
            font-weight: bold;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Room <?php echo htmlspecialchars($room['number']); ?></h1>
        <div class="details">
            <p><strong>Room ID:</strong> <?php echo htmlspecialchars($room['Room_ID']); ?></p>
            <p><strong>Room Number:</strong> <?php echo htmlspecialchars($room['number']); ?></p>
            <p><strong>Capacity:</strong> <?php echo htmlspecialchars($room['Capacity']); ?></p>
            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($room['Type']); ?></p>
            <p><strong>Availability:</strong> <?php echo htmlspecialchars($roomAvailability); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($room['Description']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($room['department']); ?></p>
            <p><strong>Floor:</strong> <?php echo htmlspecialchars($roomFloor); ?></p>
            <p><strong>Equipment:</strong> <?php echo htmlspecialchars($equipment['equipment_list'] ?: 'None'); ?></p>
        </div>
        <a href="index.php">Back to Room Browsing</a>
    </div>
</body>

</html>
