<?php 
//get user by id ✔
//user by email ✔
//get profile picture by id
//check if user is admin.. get role? ✔
//Get room by id ✔


function getUserById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE ID= :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? $user : false;

}


function getUserByEmail($pdo, $email) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR) ;
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? $user : false;
}

function getUserRoleById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE ID= :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $role = $stmt->fetch(PDO::FETCH_ASSOC);

    return $role ? $role : false;
}


function getRoomById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE Room_ID= :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    return $room ? $room : false;

}

function getBookingBYId ($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE Booking_ID = :id ");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    return $booking ? $booking : false;
}


//add booking
//update bookings
//remove booking
//get bookings of user
//check availibility


//add room
//update room
//remove
//get room by department
//get available rooms
//


?>