<?php
include("../database/db.php");

// Fetch unoccupied rooms
$sql = "SELECT Room_ID FROM rooms WHERE Room_ID NOT IN (
    SELECT Room_ID FROM bookings WHERE NOW() BETWEEN Start_Time AND End_Time
)";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$unoccupiedRooms = $stmt->fetchAll();

// Fetch occupied rooms
$sql = "SELECT Room_ID FROM bookings WHERE NOW() BETWEEN Start_Time AND End_Time;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$occupiedRooms = $stmt->fetchAll();

// Prepare data for occupied rooms
$Occupied = array();
foreach ($occupiedRooms as $room) {
    $sql = "SELECT number FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room['Room_ID']]);
    $roomNum = $stmt->fetchColumn();
    $Occupied[] = array("y" => 1, "label" => "Room " . $roomNum); // 'y' is 1 indicating occupied
}

// Prepare data for unoccupied rooms
$Unoccupied = array();
foreach ($unoccupiedRooms as $room) {
    $sql = "SELECT number FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room['Room_ID']]);
    $roomNum = $stmt->fetchColumn();
    $Unoccupied[] = array("y" => 1, "label" => "Room " . $roomNum); // 'y' is 0 indicating available
}

?>
<!DOCTYPE HTML>
<html>

<head> 
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
        Room Status Statistics
    </header>
    <main>
        <div class="chart-container">
            <div id="chartContainer"></div>
        </div>
    </main>

    <div class="text-center mb-7">
      <p><a href="dashboard.php" class="btn btn-primary">Return to Dashboard</a></p>
    </div>   
    
    <footer>
        <p>&copy; 2024 UOB Booking System. All rights reserved.</p>
    </footer>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Current Room Occupancy Status"
                },
                axisX: {
                    title: "Rooms"
                },
                axisY: {
                    includeZero: true,
                    minimum: 0,
                    maximum: 1,
                    interval: 1,
                },
                toolTip: {
                    shared: false
                },
                data: [
                    {
                        type: "stackedBar",
                        name: "Occupied",
                        color: "red",
                        dataPoints: <?php echo json_encode($Occupied, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "stackedBar",
                        name: "Unoccupied",
                        color: "blue",
                        dataPoints: <?php echo json_encode($Unoccupied, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart.render();
        }
    </script>

    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>  

    <div class="text-center mb-7">
      <p><a href="dashboard.php" class="btn btn-primary">Return to Dashboard</a></p>
    </div>  

  </body>

</html>