<?php
// database connection
$pdo = new PDO("mysql:host=localhost;dbname=booking_system", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $equipment = $_POST['equipment'];
    $location = $_POST['location'];

    // insert room into the database
    $stmt = $pdo->prepare("INSERT INTO rooms (name, capacity, equipment, location) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $capacity, $equipment, $location]);
    
    echo "<p>Room added successfully!</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Manage Rooms</h1>

    <!-- form to manage a new room -->
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Room Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required>
        </div>
        <div class="mb-3">
            <label for="equipment" class="form-label">Equipment</label>
            <textarea class="form-control" id="equipment" name="equipment" rows="2"></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Add Room</button>
    </form>
</body>
</html>