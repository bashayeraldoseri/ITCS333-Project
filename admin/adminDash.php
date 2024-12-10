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
    }

    if (isset($_POST['End_Time'])) {
        $end_time = $_POST['End_Time'];
        $sql = "UPDATE rooms SET Available_To = ? WHERE Room_ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$end_time, $room_id]);
    }
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

<body>
    <header>
        <div class="container-fluid p-2">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <img src="../static\UOBLogo.png" alt="UOB" id="UOBLogo" style="height: 80px; 
  width: auto;  
  vertical-align: middle;" />
                    <h2
                        style="font-family: Comic Sans MS, Comic Sans, cursive; margin-left: 10px; display: inline-block;">
                        UOB Booking System
                    </h2>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <div class="me-auto"></div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="../profile/profile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Dashboard/dashboard.php">Dashboard</a>
                            </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Admin</a>
                                </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../AboutUs.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Registration/logout.php">logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="container my-4">
        <!-- Room Management Section -->
        <section>
            <h3 class="mb-3">Manage Rooms</h3>
            <form method="post">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <select name="Room_ID" class="form-select" required>
                            <option value="">Select Room</option>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= $room['Room_ID'] ?>"><?= $room['number'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="get_bookings" class="btn btn-primary w-100">View Bookings</button>
                    </div>

                    <div class="col-md-3">
                    <button type="submit" name="delete_room" class="btn btn-danger">Delete Room</button>


                    </div>

                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label for="Start_Time" class="form-label">Start Time</label>
                        <input type="time" name="Start_Time" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="End_Time" class="form-label">End Time</label>
                        <input type="time" name="End_Time" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" name="modify_availability" class="btn btn-primary me-2">Update
                            Time</button>
                    </div>
                </div>
            </form>

            <div class="mt-4">
                <button type="button" onclick="location.href='addRoom.php'" class="btn btn-success">Add Room</button>
            </div>
        </section>

        <hr class="my-5">

        <!-- Booking Management Section -->
        <section>
            <h3 class="mb-3">Manage Bookings</h3>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
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
                            <td>
                                <?php
                                $stmt = $pdo->prepare("SELECT number FROM rooms WHERE Room_ID = ?");
                                $stmt->execute([$booking['Room_ID']]);
                                echo $stmt->fetchColumn();
                                ?>
                            </td>
                            <td><?= $booking['user_ID'] ?></td>
                            <td><?= $booking['Start_Time'] ?></td>
                            <td><?= $booking['End_Time'] ?></td>
                            <td>
                                <a href="?delete_schedule=<?= $booking['Booking_ID'] ?>"
                                    class="btn btn-danger btn-sm">Cancel</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

</body>

</html>