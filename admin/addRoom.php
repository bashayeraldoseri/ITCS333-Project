<?php
// database connection 
include('../database/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'];
    $query = "SELECT COUNT(*) FROM rooms WHERE number = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$number]);

    // Fetch the result
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        echo "Sorry, the room number {$number} already exists!";
    } else {
        $Capacity = $_POST['Capacity'];
        $Type = $_POST['Type'];
        $Description = $_POST['Description'];
        $floor = $_POST['floor'];
        $department = $_POST['department'];

        // insert room into the database
        $stmt = $pdo->prepare("INSERT INTO rooms (number, Capacity, Type, Description, floor, department) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$number, $Capacity, $Type, $Description, $floor, $department]);

        echo "<p>Room added successfully!</p>";
    }
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
            <label for="number" class="form-label">Room Number</label>
            <input type="text" class="form-control" id="number" name="number" required>
        </div>
        <div class="mb-3">
            <label for="Capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="Capacity" name="Capacity" min="5" max="100" required>
        </div>
        <div class="mb-3">
            <label for="Type" class="form-label">Type</label>
            <select id="Type" class="form-select" name="Type" required>
                <option value="room">Room</option>
                <option value="lap">Lab</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <input type="text" class="form-control" id="Description" name="Description" required>
        </div>
        <div class="mb-3">
            <label for="floor" class="form-label">Floor</label>
            <input type="number" class="form-control" id="floor" name="floor" min="0" max="2" required>
        </div>
        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <select id="department" class="form-select" name="department" required>
                <option value="IS">IS</option>
                <option value="CS">CS</option>
                <option value="CE">CE</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Add Room</button>
    </form>
</body>

</html>