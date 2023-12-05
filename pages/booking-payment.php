<?php
session_start();
include "../php/server.php";

//get data from other pages
$email = $_SESSION['email'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$name = $firstname . ' ' . ' ' . $lastname;
$pick_up = $_SESSION['pick-up'];
$drop_off = $_SESSION['drop-off'];
$passenger_number = $_SESSION['passenger-count'];
$username = $_SESSION['username'];

//compute for the total booking price
$stmt = $conn->prepare("SELECT price FROM destinations WHERE pick_up=? AND drop_off=?");
$stmt->bind_param("ss", $pick_up, $drop_off);
$stmt->execute();
$result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $price = $row["price"];
    $total_price = $price * $passenger_number;
  }
  $stmt->close();

  //store reference number, proof of payment, and send email 
  if (isset($_POST['submit'])){
    $ref_number = $_POST['reference-number'];
    $booking_id = $_SESSION['booking_id'];

    //REFERENCE NUMBER
    $sql = "UPDATE booking_form SET reference_number = '$ref_number' WHERE booking_id = $booking_id";
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //PROOF OF PAYMENT
    $file = $_FILES['image'];
    $filename = $file['name'];
    $image = file_get_contents($file['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO payment_proof (filename, image) VALUES (?, ?)");
    $stmt->bind_param('ss', $filename, $image);
    $stmt->execute();
    $stmt->close();

    //GENERATE EMAIL
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
      $mail->Body    = 'Hi, ' . $firstname . " " . $lastname . '. ' . 'You have just submitted your payment reference number for your booking '. $pick_up . ' to ' . $drop_off . ' . Please wait for your official ticket once we confirm your payment.' .  '<br>' .  '<br>' . 'Thank you for trusting BTS!';
      $mail->send();
      echo '<script type="text/javascript">
              window.location = "../pages/booking-receipt.php";
            </script>';
    }
    catch (Exception $e) {}

    header("Location: booking-receipt.php");
  }
  $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BTS | Bus Ticketing System</title>
    <link rel="stylesheet" href="../style.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />
<!-- Start of Style for booking-payment.html -------------------------------------------------------->
    <style>
        .totalFare {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            color: #365F32;
        }
       .amount {
            text-align: center;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            font-size: 30px;
            color: #E57777;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px; /* Adjust the spacing between buttons */
            margin-top: 20px;
        }
        .button-container button {
            background-color: #E57777;
            padding: 10px 20px;
        } 
    </style>
<!-- End of Style for booking-payment.html -------------------------------------------------------->
</head>
<body>

<!-- Start of Navigation Bar -------------------------------------------------------->
<nav>
    <div class="wrapper">
      <div class="logo">
        <a href="#">
          <img src="../img/bts-logo-nav.png" alt="BTS" class="logo-pic"/>
        </a>
      </div>
      <input type="radio" name="slider" id="menu-btn" />
      <input type="radio" name="slider" id="close-btn" />
      <ul class="nav-links">
        <label for="close-btn" class="navbtn close-btn"><i class="fa fa-times"></i></label>
        <li><a href="../index.html">HOME</a></li>
        <li><a href="booking-payment.php" id="active-page">BOOKING</a></li>
        <li><a href="../pages/transaction.php">TRANSACTIONS</a></li>
        <li><a href="../pages/about-us.html">ABOUT US</a></li>
        <li><a href="#">FEEDBACK</a></li>
        <div class="login">
          <a href="../pages/profile-page.php" id="login-button">Account</a>
        </div>
      </ul>
      <label for="menu-btn" class="navbtn menu-btn"><i class="fa fa-bars"></i></label>
    </div>
  </nav>
<!-- End of Navigation Bar -------------------------------------------------------->

  <div class="background">
    <div class="booking-form">
        <center>
            <br><br><br><br>
            <h1 style="color: #365F32;">Payment</h1>
            <h4>Online Payment Transaction</h4>
            <br>
        </center>
<!-- Start of Payment Form -------------------------------------------------------->
    <div class="form-bg">
        <form id="payment-form" action="" method="post" enctype="multipart/form-data">
            <h3>Payment Channels</h3>
            <p>Bank of the Philippine Islands (BPI): 98765432112345</p>
            <p>Banco De Oro (BDO): 98765432112345</p>
            <p>Gcash or PayMaya: 09282828282</p>
            <br><br><hr><br>
              <span class="totalFare">Total Fare for your Trip:</span>
              <span class="amount"><?php echo $price . " * " . $passenger_number . " = " . $total_price ?></span>
            <br>
            <hr>
            <br>
            <h3>Enter Reference Number: </h3>
            <input type="number" name="reference-number" id="name" required>
            <h3>Upload Proof of Payment Screenshot: </h3>
            <input type="file" name="image" id="image" accept="image/*" required>
            <h6>*You may upload .png, .jpeg, or pdf file</h6>
            <!--<button type="submit" name="proof">Upload Image</button>-->
<!-- Start of Buttons -------------------------------------------------------->
    <div class="button-container">
    <button onclick="location.href='booking-form1.php'" type="button" style="background-color: #7788E5;">Cancel</button>
    <button type="button" onclick="resetForm()" style="background-color: #E57777;">Clear Form</button>
    <button onclick="validateForm()" type="submit" style="background-color: #54CC36;" name ="submit">Submit</button>
    </div>
        </form>
    </div>
<!-- End of Payment Form -------------------------------------------------------->


<!-- End of Buttons -------------------------------------------------------->
</div>
</div>

<!-- FOOTER -->
<div class="footer">
      <div class="footer-content">Copyright © 2023 BTS Co.</div>
      <div class="footer-content">
        <ul class="social-footer">
          <li>
            <a href="#" class="social-button"
              ><i class="fa fa-facebook" aria-hidden="true"></i
            ></a>
          </li>
          <li>
            <a href="#" class="social-button"
              ><i class="fa fa-twitter" aria-hidden="true"></i
            ></a>
          </li>
          <li>
            <a href="#" class="social-button"
              ><i class="fa fa-google" aria-hidden="true"></i
            ></a>
          </li>
        </ul>
      </div>
    </div>

<!-- Start of Script (to reset and validate form) -------------------------------------------------------->
    <script>
        function resetForm() {
            document.getElementById("payment-form").reset();
        }

        function validateForm() {
            var form = document.getElementById("payment-form");
            if (form.checkValidity()) {
                location.href = 'booking-process.html';
            } else {
                alert("Please fill in all required fields.");
            }
        }
    </script>
<!-- End of Script (to reset and validate form) -------------------------------------------------------->

</body>
</html>

