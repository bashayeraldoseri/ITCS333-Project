<?php
include("../database/db.php");
$sql = "SELECT room_id, COUNT(*) AS num_bookings FROM bookings GROUP BY room_id ORDER BY num_bookings DESC LIMIT 3 ;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$bookings = $stmt->fetchAll();
$dataPoints = array();

foreach ($bookings as $booking) {
    $sql = "SELECT number FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$booking['room_id']]);  // Pass the Room_ID dynamically
    $roomNum = $stmt->fetchColumn();  // Fetch the room number
    $dataPoints[] = array("y" => $booking['num_bookings'], "label" => $roomNum);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Room Statistics</title>
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
        Top Room Booking Statistics
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
                title: {
                    text: "Top Three Rooms",
                    fontSize: 20,
                    fontFamily: 'Arial',
                    fontWeight: 'bold'
                },
                axisY: {
                    title: "Number of Bookings",
                    titleFontSize: 16,
                    gridThickness: 1,
                    lineThickness: 2,
                    interval: 1,
                    includeZero: true
                },
                axisX: {
                    title: "Room Number",
                    titleFontSize: 16
                },
                data: [{
                    type: "bar",
                    indexLabel: "{y}",
                    indexLabelPlacement: "inside",
                    indexLabelFontWeight: "bolder",
                    indexLabelFontColor: "white",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>

</body>

</html>