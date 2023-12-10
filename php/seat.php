<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    header("Location: login-page.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the JSON data from the AJAX request
  $jsonData = json_decode($_POST['jsonData'], true);

  // Access the selected values array
  $selectedValues = $jsonData['selectedValues'];

  //lagay sa incrementing selected Value variable
  for ($i = 0; $i < count($selectedValues); $i++) {
    ${'selectedValue_' . ($i + 1)} = $selectedValues[$i];
  }

  for ($i = 0; $i < count($selectedValues) + 1; $i++) {
    //lipat sa database
    $booking_id = $_SESSION['booking_id'];
    $status = "reserved";
    $sql = "UPDATE seat_reservation SET status=?, booking_id=? WHERE bus_seat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sis', $status, $booking_id, ${'selectedValue_' . $i}); 
    $stmt->execute();
    $stmt->close();
  }
}
?>