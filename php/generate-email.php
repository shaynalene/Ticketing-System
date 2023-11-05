<?php
//connect to database
$conn = new mysqli('localhost','root','','ticket_system');

if ($conn->connect_error) {
    die(''. $conn->connect_error);
}


session_start();
$username = $_SESSION['username'];


if(isset($_POST['button_pressed'])){
    echo 'success';
    $to = $username;
    $subject = "HTML email";

    $message = "
    MESSAGE
    ";


    echo $to . "". $subject ."". $message ."";
}


// OPTIONAL STARTS HERE

// Always set content-type when sending HTML email
/*$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";*/

// OPTIONAL ENDS HERE

mail($to,$subject,$message);
?>