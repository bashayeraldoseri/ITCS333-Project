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

$roomFloor;
    switch ($room['floor']) {
        case '0': $roomFloor = "Ground Floor" ; break;
        case "1": $roomFloor = "First Floor"; break;
        case "2": $roomFloor = "Second Floor"; break;
        default : $roomFloor = "none";
    }



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
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
            color: #272727;
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
    <div class="container mt-4 details">
        <h1 class="text-center mb-4 details-text">Room Details: <?php echo htmlspecialchars($room['number']); ?></h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Details in a horizontal layout -->
                <div class="row text-center">
                    <div class="col-md-6">
                        <p><strong>Room ID:</strong> <?php echo htmlspecialchars($room['Room_ID']); ?></p>
                        <p><strong>Room Number:</strong> <?php echo htmlspecialchars($room['number']); ?></p>
                        <p><strong>Capacity:</strong> <?php echo htmlspecialchars($room['Capacity']); ?></p>
                        <p><strong>Room Type:</strong> <?php echo htmlspecialchars($room['Type']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($room['Description']); ?></p>
                        <p><strong>Department:</strong> <?php echo htmlspecialchars($room['department']); ?></p>
                        <p><strong>Floor:</strong> <?php echo htmlspecialchars($roomFloor); ?></p>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row text-center">
                    <div class="col-md-6">
                        <h5 class="card-title">Availability</h5>
                        <ul class="list-unstyled">
                            <li><strong>From:</strong> <?php echo htmlspecialchars($room['Available_From']); ?></li>
                            <li><strong>To:</strong> <?php echo htmlspecialchars($room['Available_To']); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title">Equipment</h5>
                        <p><?php echo htmlspecialchars($equipment['equipment_list'] ?: 'None'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Back to Room Browsing</a>
        </div>
    </div>
</body>

</html>
