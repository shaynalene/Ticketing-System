<?php
session_start();
include '../php/server.php';

// get data from HTML form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $password = $_POST['password'];
}

// validate if there is an existing account with the login credentials
$stmt = $conn->prepare("SELECT user_id, username, firstname, lastname, number, email, password FROM user_accounts WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hashed_password = $row["password"];
    
    // Verify the provided password against the hashed password
    if (password_verify($password, $hashed_password)) {
        // Correct password
        $_SESSION['user_id'] = $row["user_id"];
        $_SESSION['username'] = $row["username"];
        $_SESSION['firstname'] = $row["firstname"];
        $_SESSION['lastname'] = $row["lastname"];
        $_SESSION['number'] = $row["number"];
        $_SESSION['email'] = $row["email"];

        header("Location: ../index.php");
        exit();
    } else {
        // Password is incorrect
        echo '<script>
                    alert("Incorrect Password!");
                    window.location.href = "../pages/login-usr-page.html";
                </script>';
    }
} else {
    // User not found
    echo '<script>
                    alert("User Not Found!");
                    window.location.href = "../pages/login-usr-page.html";
            </script>';
}

$stmt->close();
$conn->close();
?>
