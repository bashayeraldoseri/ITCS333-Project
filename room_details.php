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
    'CE' => '#0077b6',
    'IS' => '#e63946',
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
        <style>body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        .details {
            background-color:
                <?php echo htmlspecialchars($bgColor); ?>
            ;
            padding: 20px;
            border-radius: 10px;
            font: 1em sans-serif;
        }

        .details p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .details strong {
            color: #333333;
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
            font: 1em sans-serif;
        }

        a:hover {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <?php
    $roomFloor;
    switch ($room['floor']) {
        case '0': $roomFloor = "Ground Floor" ; break;
        case "1": $roomFloor = "First Floor"; break;
        case "2": $roomFloor = "Second Floor"; break;
        default : $roomFloor = "none";

    }

    ?>
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
            <p><strong>Floor:</strong> <?php echo htmlspecialchars($roomFloor); ?></p>
            <p><strong>Room Equipment:</strong> <?php echo htmlspecialchars($equipment['equipment_list']); ?></p>
        </div>
        <p><a href="index.php">Back to Room Browsing</a></p>
    </div>
</body>

</html>