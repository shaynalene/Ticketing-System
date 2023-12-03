<?php
include "server.php";
//get data from html form
$username = $_POST["username"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$number = $_POST["phonenumber"];
$email = $_POST["email"];
$password = $_POST['password'];

//insert the data to database
$sql = "INSERT INTO user_accounts (username, firstname, lastname, number, email, password) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiss", $username, $firstname, $lastname, $number, $email, $password);
$stmt->execute();
header("Location: ../pages/login-page.html");
$stmt->close();
$conn->close(); 
?>