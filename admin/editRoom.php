<?php
// database connection
include('../database/db.php');

// get the room ID from the URL
$Room_ID = $_GET['Room_ID'];

// fetch the room data
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE Room_ID = ?");
$stmt->execute([$Room_ID]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

// update room data if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'];
    $Capacity = $_POST['Capacity'];
    $Type = $_POST['Type'];
    $Availability = $_POST['Availability'];
    $Description = $_POST['Description'];
    $floor = $_POST['floor'];
    $department = $_POST['department'];

    // update room in the database
    $stmt = $pdo->prepare("UPDATE rooms SET number = ?, Capacity = ?, Type = ?, Availability = ?, Description = ?, floor = ? department = ? WHERE $Room_ID = ?");
     $stmt->execute([$number, $Capacity, $Type, $Availability, $Description, $floor, $department, $Room_ID]);

    // redirect to the view rooms page after update
    header("Location: viewRooms.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Edit Room</h1>

    <!-- form to edit room -->
    <form method="POST">
    <div class="mb-3">
            <label for="number" class="form-label">Room Number</label>
            <input type="text" class="form-control" id="number" name="number" required>
        </div>
        <div class="mb-3">
            <label for="Capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="Capacity" name="Capacity" min="5" max="999" required>
        </div>
        <div class="mb-3">
            <label for="Type" class="form-label">Type</label>
            <input type="text" class="form-control" id="Type" name="Type" required>
        </div>
        <div class="mb-3">
            <label for="Availability" class="form-label">Availability</label>
            <input type="text" class="form-control" id="Availability" name="Availability" required>
        </div>
        <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <input type="text" class="form-control" id="Description" name="Description" required>
        </div>
        <div class="mb-3">
            <label for="floor" class="form-label">Floor</label>
            <input type="number" class="form-control" id="floor" name="floor" required>
        </div>
        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" class="form-control" id="department" name="department" required>
        </div>
        <button type="submit" class="btn btn-success">Update Room</button>
    </form>
</body>
</html>
