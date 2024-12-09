<?php
session_start();
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
  <title>Us!</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <style>
    footer {
      text-align: center;
      background-color: #8ecae6;
      color: #272727;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    .table th,
    .table td {
      vertical-align: middle;
      padding: 12px;
      /* Add padding for better readability */
      text-align: center;
      /* Center the text inside table cells */
    }

    .table-hover tbody tr:hover {
      background-color: #f8f9fa;
    }

    .thead-dark th {
      background-color: #acd1f6;
      color: white;
    }

    .table {
      width: 100%;
      margin-top: 30px;
      /* Add margin to separate from other elements */
    }

    /* Customize buttons */
    .btn-primary {
      background-color: #a0b8cf;
      border-color: #EFF1F3;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #004085;
    }

    /* Style the table header */
    .table th {
      font-weight: bold;
      font-size: 1.1rem;
    }

    /* Style the page header */
  </style>
</head>

<body>
  <div class="container-fluid">
    <header>
      <div class="container-fluid p-2">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">
            <img src="static\UOBLogo.png" alt="UOB" id="UOBLogo"  />
            <h2 style="font-family: Comic Sans MS, Comic Sans, cursive; margin-left: 10px; display: inline-block;">
              UOB Booking System
            </h2>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <div class="me-auto"></div>
              <ul class="nav nav-tabs">
                <?php if ($loggedin): ?>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="profile/profile.php">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="Dashboard/dashboard.php">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="admin/adminDash.php">Admin</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="#">About Us</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="Registration/logout.php">logout</a>
                  </li>

                <?php else: ?>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="Registration/login.html">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="Registration/register.html">Register</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="admin/adminDash.php">Admin</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="#">About Us</a>
                  </li>

                <?php endif; ?>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <div class="container">
      <div class="row">
        <table class="table table-striped table-bordered table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Student Name</th>
              <th scope="col">ID</th>
              <th scope="col">Contribution</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Ameena Raed Hasan Aljazeeri</td>
              <td>202207518</td>
              <td>User profile management, Profile editing functionality, Picture upload, filtering, general design</td>
            </tr>
            <tr>
              <td>Khadija Ahmed Faraj</td>
              <td>202208131</td>
              <td>Reporting and analytics, room usage and popularity, upcoming and past bookings, room usage statistics
              </td>
            </tr>
            <tr>
              <td>Fatima Yaqoob Yusuf AlSwar</td>
              <td>202205785</td>
              <td>Room browsing and details, browsing functionality, displaying information, general design</td>
            </tr>
            <tr>
              <td>Bashayer Khalifa Aldoseri</td>
              <td>202204435</td>
              <td>Booking system, room booking functionality, conflict checking, booking cancellation</td>
            </tr>
            <tr>
              <td>Fatima Jafaar Ali Yaqoob</td>
              <td>202207126</td>
              <td>User registration and login, login functionality, validating emails</td>
            </tr>
            <tr>
              <td>Nawraa Abdulhadi Mahdi</td>
              <td>202207092</td>
              <td>Admin panel, room management system, room schedule management, admin interface</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>

    <div class="text-center mb-7">
      <p><a href="index.php" class="btn btn-primary">Return to Home Page</a></p>
    </div>
  </div>

  <footer>&copy; 2024 All Rights Reserved to us :></footer>
</body>

</html>