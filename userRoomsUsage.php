<?php
include('database/db.php');

// Define the username
$username = "Instructor Name"; // Make sure this matches an actual user in the database

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
    $dataPoints[] = array(
        "label" => "Room " . $booking['Room_ID'],  // Label for the room
        "y" => round($percentage, 2)  // Round percentage to two decimal places
    );
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("userRoomContainer", {
                animationEnabled: true,
                title: {
                    text: "Rooms Usage (Percentage)"
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
</head>

<body>
    <div id="userRoomContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>