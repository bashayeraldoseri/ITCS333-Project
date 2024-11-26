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

$query = "SELECT DATE(Start_Time) AS booking_date, COUNT(*) AS booking_count FROM bookings WHERE user_ID = ?
GROUP BY booking_date
ORDER BY booking_date;";

$stmt = $pdo->prepare($query);
$stmt->execute([$userID['ID']]);
$result = $stmt->fetchAll();

$dataPoints = array();

foreach ($result as $timing) {
    // Convert booking_date to Unix timestamp in milliseconds
    $timestamp = strtotime($timing['booking_date']) * 1000;  // Convert to milliseconds
    $dataPoints[] = array(
        "x" => $timestamp,  // Use Unix timestamp
        "y" => $timing['booking_count']
    );
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("userTimingContainer", {
                animationEnabled: true,
                title: {
                    text: "Bookings during a month"
                },
                axisY: {
                    title: "Number of bookings",
                },
                data: [{
                    type: "spline",
                    markerSize: 5,
                    xValueType: "dateTime",  // This tells CanvasJS to interpret x values as dates
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });

            chart.render();

        }
    </script>

</head>

<body>
    <div id="userTimingContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>