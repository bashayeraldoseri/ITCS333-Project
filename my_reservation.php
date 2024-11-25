<?php
// my_reservations.php

// PDO connection
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'booking_system';
$port = 3306;

try {
    $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get current date for classification
$current_date = date('Y-m-d H:i:s');

// Fetch all reservations
$sql = "SELECT * FROM bookings";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Classify reservations into current and past
$current_reservations = [];
$past_reservations = [];
foreach ($reservations as $reservation) {
    if ($reservation['End_Time'] >= $current_date) {
        $current_reservations[] = $reservation;
    } else {
        $past_reservations[] = $reservation;
    }
}

// Calculate total reservations
$total_reservations = count($reservations);
?>




<!DOCTYPE html>
<html lang="en">
<<head>
  <title>My Reservation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>My Reservations</h1>
  <p>Booking total: <?php echo $total_reservations; ?> </p> 
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <h2>Current Reservations</h2>
  <?php if (count($current_reservations) > 0): ?>
    <table class="table">
      <thead>
        <tr>
          <th>Room</th>
          <th>Title</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Capacity</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($current_reservations as $reservation): ?>
          <tr>
            <td><?php echo $reservation['Room_ID']; ?></td>
            <td><?php echo $reservation['Title']; ?></td>
            <td><?php echo $reservation['Start_Time']; ?></td>
            <td><?php echo $reservation['End_Time']; ?></td>
            <td><?php echo $reservation['Capacity']; ?></td>
            <td>
              <a href="update_reservation.php?id=<?php echo $reservation['Booking_ID']; ?>" class="btn btn-info">Update</a>
              <a href="delete_reservation.php?id=<?php echo $reservation['Booking_ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No current reservations found.</p>
  <?php endif; ?>
    </div>

    <div class="col-sm-6">
    <h2>Past Reservations</h2>
  <?php if (count($past_reservations) > 0): ?>
    <table class="table">
      <thead>
        <tr>
          <th>Room</th>
          <th>Title</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Capacity</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($past_reservations as $reservation): ?>
          <tr>
            <td><?php echo $reservation['Room_ID']; ?></td>
            <td><?php echo $reservation['Title']; ?></td>
            <td><?php echo $reservation['Start_Time']; ?></td>
            <td><?php echo $reservation['End_Time']; ?></td>
            <td><?php echo $reservation['Capacity']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No past reservations found.</p>
  <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
<?php
// Close the connection
$pdo = null;
?>