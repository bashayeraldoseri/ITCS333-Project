<?php
include("database/db.php");

$sql = "SELECT DATE(Start_Time) AS date, Room_ID, COUNT(*) AS num_bookings 
FROM bookings 
GROUP BY date, Room_ID 
ORDER BY date, Room_ID;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$bookings = $stmt->fetchAll();

$dataPoints = array();

foreach ($bookings as $booking) {
    $dataPoints[] = array(
        "y" => $booking['num_bookings'], // Number of bookings
        "label" => $booking['date']      // Date of booking
    );
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking Trends</title>
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
</head>

<body>

    <header>
        Room Booking Trends
    </header>

    <main>
        <div class="chart-container">
            <div id="chartContainer"></div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Your Company. All rights reserved.</p>
    </footer>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Room Booking Trends Over Time",
                    fontSize: 20,
                    fontFamily: 'Arial',
                    fontWeight: 'bold'
                },
                axisX: {
                    title: "Dates of Booking",
                    titleFontSize: 16
                },
                axisY: {
                    title: "Number of Bookings",
                    titleFontSize: 16,
                    interval: 1,
                    gridThickness: 1,
                    lineThickness: 2,
                    includeZero: true
                },
                data: [{
                    type: "area",
                    markerSize: 5,
                    xValueFormatString: "YYYY-MM-DD", // Format the x-axis dates
                    yValueFormatString: "#,##0",     // Display y values as whole numbers
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>

</body>

</html>
