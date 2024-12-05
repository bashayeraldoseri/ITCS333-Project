<?php
// database connection
include('database/db.php');

// fetch rooms from the database
$stmt = $pdo->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rooms</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">View Rooms</h1>

    <!-- display the rooms in a table -->
    <table class="table">
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Room Number</th>
                <th>Capacity</th>
                <th>Type</th>
                <th>Availability</th>
                <th>Description</th>
                <th>Availability</th>
                <th>Floor</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo $room['Room_ID']; ?></td>
                    <td><?php echo $room['number']; ?></td>
                    <td><?php echo $room['Capacity']; ?></td>
                    <td><?php echo $room['Type']; ?></td>
                    <td><?php echo $room['Availability']; ?></td>
                    <td><?php echo $room['Description']; ?></td>
                    <td><?php echo $room['floor']; ?></td>
                    <td><?php echo $room['department']; ?></td>
                    <td>
                        <!-- edit and delete actions -->
                        <a href="editRoom.php?Room_ID=<?php echo $room['Room_ID']; ?>" class="btn btn-warning">Edit</a>
                        <a href="deleteRoom.php?Room_ID=<?php echo $room['Room_ID']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>