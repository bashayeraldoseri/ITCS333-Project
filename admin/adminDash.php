<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5"> <!-- container adds padding and centers the content -->
    <h1 class="text-center mb-4">Admin Dashboard</h1> 

    <!-- two options for admin actions: manage rooms and manage schedules -->
    <div class="row">
        <!-- manage rooms button -->
        <div class="col-md-4"> 
            <a href="manageRooms.php" class="btn btn-primary w-100 mb-3">Manage Rooms</a>
        </div>

        <!-- manage schedules button -->
        <div class="col-md-4">
            <a href="manageSchedules.php" class="btn btn-primary w-100 mb-3">Manage Schedules</a>
        </div>
    </div>
</body>
</html>