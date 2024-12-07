<?php
header('Content-Type: text/html; charset=UTF-8');

require_once 'database/db.php';

$data = json_decode(file_get_contents('php://input'), true);

$query = "SELECT * FROM rooms WHERE 1=1";
$params = [];

// Search query
if (!empty($data['searchQuery'])) {
    $queryParts = explode(' ', $data['searchQuery']);
    
    $conditions = [];

    foreach ($queryParts as $part) {
        $conditions[] = "(
            department LIKE ? 
            OR Description LIKE ? 
            OR number LIKE ? 
            OR Capacity LIKE ? 
            OR floor LIKE ? 
            OR Type LIKE ?
        )";

        $params[] = "%" . $part . "%";  // department
        $params[] = "%" . $part . "%";  // Description
        $params[] = "%" . $part . "%";  // number
        $params[] = "%" . $part . "%";  // Capacity
        $params[] = "%" . $part . "%";  // floor
        $params[] = "%" . $part . "%";  // Type
    }

    $query .= " AND (" . implode(" AND ", $conditions) . ")";
}

// Departments
if (!empty($data['departments'])) {
    $placeholders = implode(',', array_fill(0, count($data['departments']), '?'));
    $query .= " AND department IN ($placeholders)";
    $params = array_merge($params, $data['departments']);
}

//Floors
if (!empty($data['floors'])) {
    // Cast each floor value to an integer (To search in the database)
    $data['floors'] = array_map('intval', $data['floors']);

    $placeholders = implode(',', array_fill(0, count($data['floors']), '?'));
    $query .= " AND floor IN ($placeholders)";
    $params = array_merge($params, $data['floors']);
    // var_dump(value: $data['floors']);
}


// Capacity
if (!empty($data['capacity'])) {
    $query .= " AND capacity >= ?";
    $params[] = $data['capacity'];
}

// Booking Time
//if (!empty($data['bookingTime'])) {
    //$query .= " AND available_time <= ?";
    //$params[] = $data['bookingTime'];
//}

$stmt = $pdo->prepare($query);
$stmt->execute($params);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $class_name = $row['department'] . " Class";
        $class_subtitle = "S40- " . $row['number'];
        $class_description = $row['Description'];

        $card_color = "";
        switch ($row['department']) {
            case "CE":
                $card_color = "border-color: #023e8a; color: #000000; border-width: medium;"; 
                break;
            case "CS":
                $card_color = "border-color: #F8DE7E; color: #000000; border-width: medium;"; 
                break;
            case "IS":
                $card_color = "border-color: #c1121f; color: #000000; border-width: medium;"; 
                break;
            default:
                $card_color = "border-color: #A3BFEF; color: #000000; border-width: medium;"; // Default gray 
            } 

        echo "
            <div class='col-lg-3 col-md-4 col-sm-6 mb-3'>
              <a href='room_details.php?Room_ID={$row['Room_ID']}' class='nav-link card-link'>
                  <div class='card' style='{$card_color}'>
                  <div class='card-body m-3'>
                    <h5 class='card-title'>{$class_name}</h5>
                    <h6 class='card-subtitle mb-2 text-muted'>{$class_subtitle}</h6>
                    <p class='card-text'>{$class_description}</p>
                    <hr>
                    <a href='new_reservation.php' class='book-link'>
                      <p class='book-link'>Book</p>
                    </a>
                  </div>
                </div>
              </a>
            </div> ";
    }
} else {
    echo "<p>No rooms match the selected filters.</p>";
}
?>