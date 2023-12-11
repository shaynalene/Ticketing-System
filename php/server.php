<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ticket_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// You are now connected to the database

// Perform your database operations here

// Close the connection when done
//$conn->close();

?>
