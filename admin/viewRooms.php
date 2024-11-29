<?php
// database connection
$pdo = new PDO("mysql:host=localhost;dbname=booking_system", "root", "");

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
                <th>ID</th>
                <th>Name</th>
                <th>Capacity</th>
                <th>Equipment</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo $room['id']; ?></td>
                    <td><?php echo $room['name']; ?></td>
                    <td><?php echo $room['capacity']; ?></td>
                    <td><?php echo $room['equipment']; ?></td>
                    <td><?php echo $room['location']; ?></td>
                    <td>
                        <!-- edit and delete actions -->
                        <a href="editRoom.php?id=<?php echo $room['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="deleteRoom.php?id=<?php echo $room['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>