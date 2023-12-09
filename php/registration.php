<?php
include "server.php";
//get data from html form
$username = $_POST["username"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$number = $_POST["phonenumber"];
$email = $_POST["email"];
$password = $_POST['password'];
$confirm_password  = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo '  <script>
                    alert("Passwords do not match!");
                    window.location.href = "../pages/login-register-page.html";
                </script>';
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);
$user_type = "user";
$account_status = "active";

//insert the data to database
$sql = "INSERT INTO user_accounts (username, firstname, lastname, number, email, password, user_type, account_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssissss", $username, $firstname, $lastname, $number, $email, $hashed_password, $user_type, $account_status);
$stmt->execute();
header("Location: ../pages/login-page.html");
$stmt->close();
$conn->close(); 
?>