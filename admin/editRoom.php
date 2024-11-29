<?php
// database connection
$pdo = new PDO("mysql:host=localhost;dbname=booking_system", "root", "");

// get the room ID from the URL
$id = $_GET['id'];

// fetch the room data
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

// update room data if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $equipment = $_POST['equipment'];
    $location = $_POST['location'];

    // update room in the database
    $stmt = $pdo->prepare("UPDATE rooms SET name = ?, capacity = ?, equipment = ?, location = ? WHERE id = ?");
    $stmt->execute([$name, $capacity, $equipment, $location, $id]);

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
            <label for="name" class="form-label">Room Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $room['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo $room['capacity']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="equipment" class="form-label">Equipment</label>
            <input type="text" class="form-control" id="equipment" name="equipment" value="<?php echo $room['equipment']; ?>">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo $room['location']; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update Room</button>
    </form>
</body>
</html>