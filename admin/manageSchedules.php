<?php
// database connection
include('../database/db.php');

// fetch rooms and schedules from bookings table
$rooms = $pdo->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
$bookings = $pdo->query("SELECT * FROM bookings")->fetchAll(PDO::FETCH_ASSOC);


// add a new schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_schedule'])) {
        $room_id = $_POST['Room_ID'];
        $user_id = $_POST['user_ID'];
        $start_time = $_POST['Start_Time'];
        $end_time = $_POST['End_Time'];
        $sql = "INSERT INTO bookings (Room_ID, user_ID, Start_Time, End_Time) VALUES (:Room_ID, :user_ID, :Start_Time, :End_Time)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':Room_ID' => $room_id,
            ':user_ID' => $user_id,
            ':Start_Time' => $start_time,
            ':End_Time' => $end_time,
        ]);
    header("Location: manageSchedules.php");
}
//for delete schedule
if (isset($_GET['delete_schedule'])) {
    $schedule_id = $_GET['delete_schedule'];
    $sql = "DELETE FROM bookings WHERE Booking_ID = :Booking_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':Booking_ID' => $schedule_id]);
    header("Location: manageSchedules.php");
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
    <h1 class="text-center mb-4">Manage Schedules</h1>

    <!-- add schedule form -->
    <h3>Add Schedules</h3>
    <form method="post" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="Room_ID" class="form-select" required>
                    <option value="">Select Room</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['Room_ID'] ?>"><?= $room['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="user_ID" placeholder="User ID" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="datetime-local" name="Start_Time" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="datetime-local" name="End_Time" class="form-control" required>
            </div>
        </div>
        <button type="submit" name="add_schedule" class="btn btn-primary mt-2">Add Schedule</button>
    </form>

    <!-- display schedules -->
    <h3>All Schedules</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Schedule ID</th>
            <th>Room Name</th>
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
                <td><?= $booking['Room_ID'] ?></td>
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
