<?php
session_start();
//testing
// print_r($_SESSION);
$loggedin = false;

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1) {
  $loggedin = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ITCS333 Project</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <div class="container-fluid">
    <header>
      <div class="container-fluid p-2">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">UOB Booking System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <div class="me-auto"></div>
              <ul class="nav nav-tabs">

                <?php if ($loggedin): ?>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="templates/profile.php">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="adminDash.php">Admin</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="templates/login.html">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="templates/register.html">Register</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About Us</a>
                </li>

                <?php endif; ?>


              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>


    <main>
      <div class="row g-50">
        <!-- Sidebar Search Menu -->
        <div id="searchSidebar" class="search-sidebar">
          <!-- <div class="sidebar-header">
            <button class="btn-close" id="closeSidebar">&times;</button>
          </div> -->
          <div class="sidebar-body p-5 ">
            <input class="form-control me-2 mb-4" type="search" placeholder="Search" aria-label="Search" />

            <label>Choose a department:</label>
            <div class="form-check form-check-inline mb-4">
              <input class="form-check-input" type="checkbox" id="ISCheckBox" value="IS" />
              <label class="form-check-label" for="ISCheckBox">IS</label>
            </div>
            <div class="form-check form-check-inline mb-4">
              <input class="form-check-input" type="checkbox" id="CSCheckBox" value="CS" />
              <label class="form-check-label" for="CSCheckBox">CS</label>
            </div>
            <div class="form-check form-check-inline mb-4">
              <input class="form-check-input" type="checkbox" id="CECheckBox" value="CE" />
              <label class="form-check-label" for="CECheckBox">CE</label>
            </div>

            <label>Choose a floor:</label>
            <div class="form-check mb-2">
              <input class="form-check-input " type="checkbox" name="SecondFloorRadio" id="SecondFloorRadio"
                value="Second" checked />
              <label class="form-check-label" for="SecondFloorRadio">Second Floor</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="FirstFloorRadio" id="FirstFloorRadio"
                value="First" />
              <label class="form-check-label" for="FirstFloorRadio">First Floor</label>
            </div>
            <div class="form-check  mb-4">
              <input class="form-check-input" type="checkbox" name="GroundFloorRadio" id="GroundFloorRadio"
                value="Ground" />
              <label class="form-check-label" for="GroundFloorRadio">Ground Floor</label>
            </div>

            <label for="capacity">Capacity:</label>
            <select id="capacity" class="form-control mb-4">
              <option selected value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="40">40</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>

            <label for="bookingTime">Search by Available Time:</label>
            <input type="datetime-local" id="bookingTime" class="form-control mb-3" />
          </div>

          <div id="openSidebar" class="toggle-icon">
            <i class="bi bi-search"></i>
          </div>

        </div>


        <div class="col-lg-9 container">
          <div class="scrollable-container">
            <?php
            // Include the existing database connection
            include('database/db.php');
            include('helpers/functions.php');

            // Fetch class data from the database
            $sql = "SELECT * FROM rooms";
            $stmt = $pdo->prepare($sql);  // Prepare the query
            $stmt->execute();  // Execute the query
            
            // Check if there are rows
            if ($stmt->rowCount() > 0) {
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Card content
                $class_name = $row['department'] . " Class";
                $class_subtitle = "S40- " . $row['number'];
                $class_description = $row['Description'];
                ?>
                <div class="col-lg-3 row g-3">
                  <a href="room_details.php?Room_ID=<?php echo $row['Room_ID']; ?>" class="nav-link card-link">
                    <div class="card" style="width: 18rem">
                      <div class="card-body m-3">
                        <h5 class="card-title"><?php echo $class_name; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $class_subtitle; ?></h6>
                        <p class="card-text">
                          <?php echo $class_description; ?>
                        </p>
                        <hr>


                        <a href="#" class="book-link">
                          <p class="book-link">Book</p>
                        </a>
                      </div>
                    </div>
                  </a>

                </div>
                <?php
              }
            } else {
              echo "No classes available.";
            }

            // Close the connection (optional, as PDO will handle it when the script ends)
            $pdo = null;
            ?>
          </div>
        </div>

      </div>
    </main>

    <footer></footer>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="search.js"></script>
</body>

</html>