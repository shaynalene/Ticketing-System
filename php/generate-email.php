<?php
//connect to database
$conn = new mysqli('localhost','root','','ticket_system');

if ($conn->connect_error) {
    die(''. $conn->connect_error);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../php/PHPMailer-master/src/Exception.php';
require '../php/PHPMailer-master/src/PHPMailer.php';
require '../php/PHPMailer-master/src/SMTP.php';
$mail = new PHPMailer(true);

session_start();
$email = $_SESSION['email'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$name = $firstname . ' ' . ' ' . $lastname;


    try {
        // Server settings
        $mail->SMTPDebug = 2;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'bus.ticketing.system.co@gmail.com';                     // SMTP username
        $mail->Password   = 'obiy hpfs bkhy achs';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        // Recipients
        $mail->setFrom('bus.ticketing.system.co@gmail.com', 'Bus Ticketing System Co');
        $mail->addAddress($email, $name);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Booking Payment to be Confirmed';
        $mail->Body    = 'You have just submitted your payment reference number. Please wait for your official ticket once we confirm your payment.' .  '<br>' .  '<br>' . 'Thank you for trusting BTS!';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        echo '<script type="text/javascript">
           window.location = "../pages/booking-receipt.php";
      </script>';
    }
catch (Exception $e) {}


// OPTIONAL STARTS HERE

// Always set content-type when sending HTML email
/*$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";*/

// OPTIONAL ENDS HERE

//mail($to,$subject,$message);
?>