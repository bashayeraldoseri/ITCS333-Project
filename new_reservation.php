<!-- process-new_reservation.php -->

<?php
// Database connection
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'booking_system';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch the room details
$roomId = isset($_GET['Room_ID']) ? intval($_GET['Room_ID']) : 1;

function getRoomDetails($roomId, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE Room_ID = :Room_ID");
    $stmt->bindParam(':Room_ID', $roomId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$room = getRoomDetails($roomId, $pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $title = $_POST['title'];
    $Sdatetime = $_POST['Sdatetime'];
    $Edatetime = $_POST['Edatetime'];
    $capacity = $_POST['capacity'];

    // Check capacity
    $query = "SELECT capacity FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$room_id]);
    $roomData = $stmt->fetch();

    if ($roomData && $capacity <= $roomData['capacity']) {
        // Insert booking
        $sql = "INSERT INTO bookings (Room_ID, Title, Start_Time, End_Time, Capacity)
                VALUES (:room_id, :title, :Sdatetime, :Edatetime, :capacity)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':Sdatetime', $Sdatetime, PDO::PARAM_STR);
        $stmt->bindParam(':Edatetime', $Edatetime, PDO::PARAM_STR);
        $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Reservation successful!";
            header('Location: index.php');
            exit;
        } else {
            echo "Error occurred during reservation.";
        }
    } else {
        echo "Capacity exceeds room's capacity of " . $roomData['capacity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Reservation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="jumbotron text-center">
    <h1>Reserve Room: <?php echo htmlspecialchars($room['number']); ?></h1>
    <p>Kindly fill this form required to ensure your reservation!</p> 
    </div>

    <div class="container">
    <form action="new_reservation.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $room['Room_ID']; ?>">

        <div>
            <label for="title">Event Title:</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div>
            <label for="Sdatetime">Start Date / Time:</label>
            <input type="datetime-local" name="Sdatetime" id="Sdatetime" required>
        </div>

        <div>
            <label for="Edatetime">End Date / Time:</label>
            <input type="datetime-local" name="Edatetime" id="Edatetime" required>
        </div>

        <div>
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" id="capacity" required>
        </div>

        <button type="submit">Submit Reservation</button>
        
    </form>
    </div>


</body>
</html>
