<?php
include "server.php";
//get data from html form
//$name = $_POST["name"];
//$number = $_POST["contact"];
$pick_up = $_POST["pick-up"];
$drop_off = $_POST["drop-off"];
$date = $_POST["departure-date"];
$time = $_POST['departure-time'];
$passenger_number = $_POST['passenger-count'];

//insert into the database
$sql = "INSERT INTO booking_form (number, pick_up, drop_off, date, time, passenger_number)
        VALUES (?, ?, ?, ?, ?, ?, ?)"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssi", $number, $pick_up, $drop_off, $date, $time, $passenger_number);
$stmt->execute();
header("Location: ../pages/booking-form2.php");
$stmt->close();
$conn->close();
?>