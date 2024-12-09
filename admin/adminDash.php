<?php
// database connection
include('../database/db.php');

// fetch rooms and schedules from bookings table
$rooms = $pdo->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
$bookings = array();

// add a new schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['get_bookings'])) {
    $room_id = $_POST['Room_ID'];
    $sql = "SELECT * FROM bookings WHERE Room_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room_id]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_room'])) {
    $room_id = $_POST['Room_ID'];
    $query = "DELETE FROM rooms WHERE Room_ID = ?";
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute([$room_id]);
        echo "Room with ID {$room_id} has been deleted successfully.";
    } catch (PDOException $e) {
        echo "Error deleting room: " . $e->getMessage();
    }
    header("Location: adminDash.php");
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modify_availability'])) {
    $room_id = $_POST['Room_ID'];
    if (isset($_POST['Start_Time'])) {
        $start_time = $_POST['Start_Time'];
        $sql = "UPDATE rooms SET Available_From = ? WHERE Room_ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$start_time, $room_id]);
        echo "Room with ID {$room_id} has been updated successfully.";
    }

    if (isset($_POST['End_Time'])) {
        $end_time = $_POST['End_Time'];
        $sql = "UPDATE rooms SET Available_To = ? WHERE Room_ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$end_time, $room_id]);
        echo "Room with ID {$room_id} has been updated successfully.";
    }
    header("Location: adminDash.php");
}

//for delete schedule
if (isset($_GET['delete_schedule'])) {
    $schedule_id = $_GET['delete_schedule'];
    $sql = "DELETE FROM bookings WHERE Booking_ID = :Booking_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':Booking_ID' => $schedule_id]);
    header("Location: adminDash.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h1 class="text-center mb-4">Manage Rooms' Schedule</h1>

    <!-- add schedule form -->
    <h3>Manage Rooms</h3>
    <form method="post" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="Room_ID" class="form-select" required>
                    <option value="">Select Room</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['Room_ID'] ?>"><?= $room['number'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" name="get_bookings" value="update" class="btn btn-primary">Get Bookings</button>
            </div>
            <div class="col-md-3">
                <!-- Redirect to addRoom.php -->
                <button type="button" onclick="location.href='addRoom.php'" class="btn btn-success">Add Room</button>
            </div>
            <div class="col-md-3">
                <button type="submit" name="delete_room" value="delete" class="btn btn-danger">Delete Room</button>
            </div>
        </div>
    </form>


    <h2>Manage Room's Availability</h2>
    <form method="POST">
        <div class="col-md-3">
            <label for="Start_Time"> Start Time</label>
            <input type="time" name="Start_Time" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="End_Time"> End Time</label>
            <input type="time" name="End_Time" class="form-control">
        </div>

        <div class="col-md-3">
            <button type="submit" name="modify_availability" value="update" class="btn btn-primary">Modify Time</button>
        </div>
    </form>

    <!-- display schedules -->
    <h3>All Bookings</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Schedule ID</th>
                <th>Room Number</th>
                <th>User ID</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['Booking_ID'] ?></td>
                    <td><?php $sql = "SELECT number FROM rooms WHERE Room_ID = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$booking['Room_ID']]);  // Pass the Room_ID dynamically
                    $roomNum = $stmt->fetchColumn();
                    echo $roomNum; ?></td>
                    <td><?= $booking['user_ID'] ?></td>
                    <td><?= $booking['Start_Time'] ?></td>
                    <td><?= $booking['End_Time'] ?></td>
                    <td>
                        <a href="?delete_schedule=<?= $booking['Booking_ID'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>

</html>