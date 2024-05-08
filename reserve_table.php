<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "username", "password", "restaurant_reservation");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$email = $_SESSION['email'];
$phone = $mysqli->real_escape_string($_POST['phone']);
$date = $mysqli->real_escape_string($_POST['date']);
$time = $mysqli->real_escape_string($_POST['time']);
$party_size = $mysqli->real_escape_string($_POST['party_size']);
$location = $mysqli->real_escape_string($_POST['location']);

$user_query = $mysqli->query("SELECT id FROM users WHERE email = '$email'");
$user_row = $user_query->fetch_assoc();
$user_id = $user_row['id'];

$insert_query = "INSERT INTO reservations (user_id, date, time, party_size, location) VALUES ('$user_id', '$date', '$time', '$party_size', '$location')";
if ($mysqli->query($insert_query) === TRUE) {
    echo "Reservation successful!";
} else {
    echo "Error: " . $insert_query . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
