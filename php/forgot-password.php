<?php
session_start();
include '../php/server.php';

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

    echo    '<script>
                alert("Account found");
                //window.location.href = "../pages/login-usr-page.html";
            </script>';

    //get the user email
    $email = $row["email"];
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    
    /*
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
    $mail->Subject = 'Booking Payment to be Confirmed';
    $mail->Body    = 'Hi, ' . $firstname . " " . $lastname . '. ' . '<br>' . 'To change your password, click the link below: ' . '<br>' .  '<br>' . 'http://localhost/Ticketing-System/index.php';
    $mail->send();
    echo '<script type="text/javascript">
            window.location = "../pages/booking-receipt.php";
            </script>';
    }
    catch (Exception $e) {}

    //show alert that an email was sent
    echo    '<script>
    alert("An email was sent to your registered email.");
    window.location.href = "../pages/login-usr-page.html";
    </script>';
    */

}
else {
    //no account was found
    echo    '<script>
                alert("No account was found!");
            </script>';
}
$stmt->close();
$conn->close();
?>
