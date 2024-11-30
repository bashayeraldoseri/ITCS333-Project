<?php

include("database/db.php");
$sql = "SELECT room_id, COUNT(*) AS num_bookings FROM bookings GROUP BY Room_ID ORDER BY num_bookings DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$bookings = $stmt->fetchAll();
$dataPoints = array();

// Loop through each booking and calculate the percentage for each room
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
                title: {
                    text: "Number of Bookings for each Room"
                },
                axisY: {
                    title: "Number of bookings",
                    minimum: 0,        
                    interval: 1,
                    includeZero: true,
                },
                axisX: {
                    title: "Room's Number"
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
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>