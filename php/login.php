<?php
//get data from html form
$username = $_POST["username"];
$password = $_POST['password'];

session_start();
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;

//connect database
$conn = new mysqli('localhost', 'root', '', 'ticket_system');

if ($conn->connect_error) {
    die("Connection Failed. ". $conn->connect_error);
}
else{
    //validate if there is an existing account with the login credentials
    $stmt = $conn->prepare("SELECT user_id, username, firstname, lastname, number, email, password FROM user_accounts WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $number = $row["number"];
        $email = $row["email"];
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['number'] = $number;
        $_SESSION['email'] = $email;

        // Verify the provided password against the hashed password
        if ($password === $hashed_password) {
            //correct password
            header("Location: ../index.html");
            //$_SESSION['user_id'] = $row["user_id"];
        } else {
            // Password is incorrect
            echo '  <script>
                        alert("Incorrect Password!");
                        window.location.href = "../pages/login-usr-page.html";
                    </script>';
        }
    } else {
        // User not found
        echo '  <script>
                        alert("User Not Found!");
                        window.location.href = "../pages/login-usr-page.html";
                </script>';
    }

    $stmt->close();
    $conn->close(); 
}
?>