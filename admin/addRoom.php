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
    <h1 class="text-center mb-4">Add Rooms</h1>

    <!-- form to manage a new room -->
    <form method="POST" class="p-4 border rounded shadow-sm bg-light">
        <div class="row g-3">
            <!-- Room Number -->
            <div class="col-md-6">
                <label for="number" class="form-label">Room Number</label>
                <input type="text" class="form-control" id="number" name="number" placeholder="Enter room number"
                    required>
            </div>

            <!-- Capacity -->
            <div class="col-md-6">
                <label for="Capacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="Capacity" name="Capacity" min="5" max="100"
                    placeholder="Enter room capacity" required>
            </div>

            <!-- Floor -->
            <div class="col-md-6 mt-4">
                <label for="floor" class="form-label">Floor</label>
                <input type="number" class="form-control" id="floor" name="floor" min="0" max="2" 
                    placeholder="Enter floor number" required>
            </div>

            <!-- Department -->
            <div class="col-md-6 mt-4">
                <label for="department" class="form-label">Department</label>
                <select class="form-select" id="department" name="department" required>
                    <option value="IS">IS</option>
                    <option value="CS" selected>CS</option>
                    <option value="CE">CE</option>
                </select>
            </div>
        </div>

        <!-- Description -->
        <div class="col-md-12 mt-4">
            <label for="Description" class="form-label">Description</label>
            <textarea class="form-control" id="Description" name="Description" rows="3"
                placeholder="Provide a brief description of the room" required></textarea>
        </div>

        <!-- Type -->
        <div class="col-md-6 mt-4 ">
            <label for="Type" class="form-label">Type</label>
            <select class="form-select" id="Type" name="Type" required>
                <option value="room" selected>Room</option>
                <option value="lab">Lab</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-4">Add Room</button>
            <br>
            <a href="adminDash.php">Go back to admin panel</a>

        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>