<?php
include("database/db.php");
$sql = "SELECT Room_ID, COUNT(*) AS num_bookings FROM bookings GROUP BY Room_ID ORDER BY Room_ID";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$bookings = $stmt->fetchAll();

$dataPoints = array();

// Loop through the fetched bookings and add each to the dataPoints array
foreach ($bookings as $booking) {
    // Use a parameterized query to fetch the room number for each Room_ID
    $sql = "SELECT number FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$booking['Room_ID']]);  // Pass the Room_ID dynamically
    $roomNum = $stmt->fetchColumn();  // Fetch the room number

    // Add the booking count and room number to the dataPoints array
    $dataPoints[] = array("y" => $booking['num_bookings'], "label" => "Room " . $roomNum);
}


$sql = "
SELECT Room_ID
FROM rooms
WHERE Room_ID NOT IN (
    SELECT Room_ID
    FROM bookings
    GROUP BY Room_ID
)
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$noBookingsRooms = $stmt->fetchAll();

foreach ($noBookingsRooms as $booking) {
    $sql = "SELECT number FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$booking['Room_ID']]);  // Pass the Room_ID dynamically
    $roomNum = $stmt->fetchColumn();  // Fetch the room number
    // Add each room's booking count to the dataPoints array
    $dataPoints[] = array("y" => 0, "label" => "Room " . $roomNum);
}


?>
<!DOCTYPE HTML>
<html>

<head>
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

        #chartContainer {
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

            #chartContainer {
                height: 300px;
            }

            footer {
                font-size: 14px;
            }
        }
    </style>
    <header>
        Room Usage Statistics
    </header>

    <main>
        <div class="chart-container">
            <div id="chartContainer"></div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 UOB Booking System. All rights reserved.</p>
    </footer>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Number of bookings for each room"
                },
                axisX: {
                    title: "Rooms"
                },
                axisY: {
                    title: "Number of bookings",
                    includeZero: true,
                    minimum: 0,
                    interval: 1,
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## ",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>

</html>