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

//confirm the password
if ($password !== $confirm_password) {
    echo '  <script>
                    alert("Passwords do not match!");
                    window.location.href = "../pages/login-register-page.html";
                </script>';
    exit();
}
else{
    //confirm the email first
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
    $mail->Subject = 'Bus Ticketing System Login Details';
    $mail->Body    = 'Hi, ' . $firstname . " " . $lastname . '! ' . '<br>' . '<br>' . 'You have successfully registered an account. To continue, click the link below: ' . '<br>' . 'http://localhost/Ticketing-System/index.php';
    $mail->send();
    echo '<script type="text/javascript">
            window.location = "../pages/login-usr-page.html";
            </script>';
    }
    catch (Exception $e) {}

    //add the registration details to the database
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
}
?>