<?php
include("database/db.php");
$sql = "SELECT * FROM rooms WHERE Availability = 1;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$unoccupiedRooms = $stmt->fetchAll();

$sql = "SELECT * FROM rooms WHERE Availability = 0;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$occupiedRooms = $stmt->fetchAll();

$Unoccupied = array();
$Occupied = array();
foreach ($occupiedRooms as $room) {
    $dataPoints[] = array("y" => $booking['num_bookings'], "label" => $booking['room_id']);
}

foreach ($bookings as $booking) {
    $dataPoints[] = array("y" => $booking['num_bookings'], "label" => $booking['room_id']);
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Most Number of Centuries across all Formats till 2017"
                },
                axisX: {
                    reversed: true
                },
                axisY: {
                    includeZero: true
                },
                toolTip: {
                    shared: true
                },
                data: [{
                    type: "stackedBar",
                    name: "Test",
                    dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
                }, {
                    type: "stackedBar",
                    name: "ODI",
                    dataPoints: <?php echo json_encode($odi, JSON_NUMERIC_CHECK); ?>
                }, {
                    type: "stackedBar",
                    name: "T20",
                    indexLabel: "#total",
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 15,
                    indexLabelFontWeight: "bold",
                    dataPoints: <?php echo json_encode($t20, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>