<?php
// process-new_reservation.php

// PDO connection 
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'booking_system';
$port = 3306; 

try {
    // Create PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the data from the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $room_id = $_POST['room_id'];
    $title = $_POST['title'];
    $Sdatetime = $_POST['Sdatetime'];
    $Edatetime = $_POST['Edatetime'];
    $capacity = $_POST['capacity'];

    // Fetch the room's capacity based on room_id
    $query = "SELECT capacity FROM rooms WHERE room_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$room_id]);
    $room = $stmt->fetch();

     // If room exists, check if the entered capacity is less than or equal to room capacity
     if ($room) {
        $roomCapacity = $room['capacity'];
        if ($capacity > $roomCapacity) {
            // Capacity does not fit
            echo "The entered capacity exceeds the room's capacity of " . $roomCapacity . ". Please adjust the capacity.";
        } else {
            // Proceed with inserting the reservation into the bookings table
            $sql = "INSERT INTO bookings (Room_ID, Title, Start_Time, End_Time, Capacity)
                    VALUES (:room_id, :title, :Sdatetime, :Edatetime, :capacity)";

             // Prepare the statement for execution
             $stmt = $pdo->prepare($sql);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':room_id', $Room_ID, PDO::PARAM_INT);
    $stmt->bindParam(':title', $Title, PDO::PARAM_STR);
    $stmt->bindParam(':Sdatetime', $Start_Time, PDO::PARAM_STR);
    $stmt->bindParam(':Edatetime', $End_Time, PDO::PARAM_STR);
    $stmt->bindParam(':capacity', $Capacity, PDO::PARAM_INT); 

             // Execute the query
             if ($stmt->execute()) {
                 echo "Reservation successful!";
             } else {
                echo "Error occurred during reservation.";
            }
        }
    } else {
        echo "Room not found!";
    }

    // Close the connection
    $pdo = null;

    // Redirect to home page
    header('Location: index.php');
}
?>

<?php
// Get room data (e.g., room name and room_id)
$room_id = $_GET['room_id']; // Assuming you are passing the room_id via the URL or session
$query = "SELECT * FROM rooms WHERE room_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$room_id]);
$room = $stmt->fetch();
?>


<!DOCTYPE html>
<html lang="en">
<<head>
  <title>New Reservation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

 <div class="jumbotron text-center">
  <h1>New reservation</h1>
  <p>Kindly fill this form required to ensure your reservation!</p> 
 </div>
 <h1>Reserve Room: <?php echo $room['room_name']; ?></h1>

 <div class="container">
  <form action="new_reservation.php" method="POST">

  <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">

 <div class="form-group">
    <label for="title">Event title:</label>
    <input type="text" class="form-control" id="title" required>
   </div>

   <div class="form-group">
    <label for="Sdatetime">Start Date / Time:</label>
    <input type="datetime-local" class="form-control" id="Sdatetime" required>
   </div>

   <div class="form-group">
    <label for="Edatetime">End Date / Time:</label>
    <input type="datetime-local" class="form-control" id="Edatetime" required>
   </div>

   <div class="form-group">
    <label for="capacity">Capacity:</label>
    <input type="number" class="form-control" id="capacity" required>
   </div>

  <button type="submit" class="btn btn-default" value="Reserve">Submit</button>
  </form>
 </div>

</body>


</html>
