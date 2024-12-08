<?php
include('database/db.php');

session_start();

// Retrieve the username from session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // If the username is not set, you might want to redirect to login page
    header('Location: login.php');
    exit();
}

// Query to get the user ID from the 'users' table
$sql = "SELECT ID FROM users WHERE name = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$userID = $stmt->fetch();

if ($userID === false) {
    // Handle case when no user is found
    echo "User not found.";
    exit;
}

// First, get the total number of bookings for the user
$sqlTotalBookings = "SELECT COUNT(*) AS total_bookings FROM bookings WHERE user_ID = ?";
$stmtTotal = $pdo->prepare($sqlTotalBookings);
$stmtTotal->execute([$userID['ID']]);
$totalBookings = $stmtTotal->fetch()['total_bookings'];

// Query to get the room ID and booking count for each room
$sql = "SELECT Room_ID, COUNT(*) AS booking_count 
        FROM bookings 
        WHERE user_ID = ? 
        GROUP BY Room_ID 
        ORDER BY booking_count DESC";  // You can order by count descending if you want to get the most booked rooms

$stmt = $pdo->prepare($sql);
$stmt->execute([$userID['ID']]);

$bookings = $stmt->fetchAll();
$dataPoints = array();

// Loop through each booking and calculate the percentage for each room
foreach ($bookings as $booking) {
    $percentage = ($booking['booking_count'] / $totalBookings) * 100; // Calculate percentage
    $sql = "SELECT number FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$booking['Room_ID']]);  // Pass the Room_ID dynamically
    $roomNum = $stmt->fetchColumn();
    $dataPoints[] = array(
        "label" => "Room " . $roomNum, // Label for the room
        "y" => round($percentage, 2)  // Round percentage to two decimal places
    );
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking Statistics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }

        main {
            padding: 20px;
        }

        #userRoomContainer {
            height: 400px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 8px;
            margin-top: 20px;
        }

        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            header {
                font-size: 20px;
            }

            #userRoomContainer {
                height: 300px;
            }

            footer {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <header>
        Room Usage Statistics
    </header>

    <main>
        <div class="chart-container">
            <div id="userRoomContainer"></div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 UOB Booking System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("userRoomContainer", {
                animationEnabled: true,
                title: {
                    text: "Rooms Usage (Percentage)",
                    fontSize: 20,
                    fontFamily: 'Arial',
                    fontWeight: 'bold'
                },
                subtitles: [{
                    text: "Booking Data - Percentage Representation"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y}%)",  // Display percentage next to label
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>

</body>

</html>