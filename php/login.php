<?php
session_start();
include '../php/server.php';

//FORGOT
if (isset($_POST['forgot'])){
    //get the username and password from the form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST["username"];
    }

    //check if there is an existing account
    $stmt = $conn->prepare("SELECT * FROM user_accounts WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        //get the user email
        $email = $row["email"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $name = $firstname;
        
        
        //send the forgot password email   
        include "../php/generate-email.php";
        try {
        // Server settings
        $mail->SMTPDebug = 2;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                              
        $mail->Username   = 'bus.ticketing.system.co@gmail.com';                    
        $mail->Password   = 'obiy hpfs bkhy achs';                           
        $mail->SMTPSecure = 'tls';         
        $mail->Port       = 587;                                    
        
        // EMAIL DETAILS
        $mail->setFrom('bus.ticketing.system.co@gmail.com', 'Bus Ticketing System Co');
        $mail->addAddress($email, $name);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
        // EMAIL CONTENTS
        $mail->isHTML(true);                                
        $mail->Subject = 'Forgot Password';
        $mail->Body    = 'Hi, ' . $firstname . " " . $lastname . '! ' . '<br>' . '<br>' . 'To change your password, click the link below: ' . '<br>' . 'http://localhost/Ticketing-System/pages/forgot-password.php';
        $mail->send();
        }
        catch (Exception $e) {}

        //show alert that an email was sent
        echo '<script>alert("An email was sent to your registered email.");
                //window.location = "../pages/login-usr-page.html";
        </script>';
        header("Location: ../pages/login-usr-page.html");
        //exit(); // Make sure to exit after setting the header
    }
    else {
        //no account was found
        echo    '<script>
                    alert("No account was found!");
                </script>';
    }
    //header("Location: ../pages/login-usr-page.html");
    $stmt->close();
    $conn->close();
}

//LOGIN
if (isset($_POST['login'])){
    // get data from HTML form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST["username"];
        $password = $_POST['password'];
    }
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    // validate if there is an existing account with the login credentials
    $stmt = $conn->prepare("SELECT * FROM user_accounts WHERE username=?");
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

            if($row["user_type"] === "admin"){
                header("Location: ../admin-pages/admin-landing-page.php");
            }
            else{
                header("Location: ../index.php");
            }
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
}
//$stmt->close();
//$conn->close();


?>
