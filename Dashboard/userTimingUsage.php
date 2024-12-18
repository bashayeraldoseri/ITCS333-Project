<?php

include('../database/db.php');

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: ../Registeration/login.php');
    exit();
}

$sql = "SELECT ID FROM users WHERE name = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$userID = $stmt->fetch();

if ($userID === false) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Statistics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <link rel="stylesheet" href="css/styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #a0b8cf;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }

        main {
            padding: 20px;
        }

        #userTimingContainer {
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
            background-color: #a0b8cf;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .btn-primary {
      background-color: #a0b8cf;
      border-color: #EFF1F3;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #004085;
    }
        /* Responsive design */
        @media screen and (max-width: 768px) {
            header {
                font-size: 20px;
            }

            #userTimingContainer {
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
        Timing Booking Statistics
    </header>

    <main>
        <div class="chart-container">
            <div id="userTimingContainer"></div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 UOB Booking System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("userTimingContainer", {
                animationEnabled: true,
                title: {
                    text: "Number of Bookings Over Time",
                    fontSize: 20,
                    fontFamily: 'Arial',
                    fontWeight: 'bold'
                },
                axisY: {
                    title: "Number of bookings",
                    titleFontSize: 16,
                    gridThickness: 1,
                    lineThickness: 2,
                    interval: 1,
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
<div class="text-center mb-7">
      <p><a href="../profile/profile.php" class="btn btn-primary">Return to Dashboard</a></p>
    </div>
</body>

</html>