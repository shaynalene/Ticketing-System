<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BTS | Bus Ticketing System</title>
    <link rel="stylesheet" href="../style.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />
<!-- Start of Style for booking-payment.html -------------------------------------------------------->
    <style>
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
        <a href="#"
          ><img src="../img/bts-logo-nav.png" alt="BTS" class="logo-pic"
        /></a>
      </div>
      <input type="radio" name="slider" id="menu-btn" />
      <input type="radio" name="slider" id="close-btn" />
      <ul class="nav-links">
        <label for="close-btn" class="navbtn close-btn"
          ><i class="fa fa-times"></i
        ></label>
        <li><a href="../index.html" id="active-page">HOME</a></li>
        <li><a href="booking-payment.html">BOOKING</a></li>
        <li>
          <a href="#">TRANSACTIONS</a>
        </li>
        <li>
          <a href="../pages/about-us.html">ABOUT US</a>
        </li>
        <li><a href="#">PROFILE</a></li>
        <div class="login">
          <a href="#" id="login-button">Your Account</a>
        </div>
      </ul>
      <label for="menu-btn" class="navbtn menu-btn"
        ><i class="fa fa-bars"></i
      ></label>
    </div>
  </nav>
<!-- End of Navigation Bar -------------------------------------------------------->

<!--Php Codes to display booking price-->
<?php
//get data from html form
session_start();
$pick_up = $_SESSION['pick-up'];
$drop_off = $_SESSION['drop-off'];
$passenger_number = $_SESSION['passenger-count'];
$username = $_SESSION['username'];

$conn = new mysqli('localhost','root','','ticket_system');

if ($conn->connect_error) {
    die(''. $conn->connect_error);
}
else{
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
    $conn->close();
}
?>
<!--End of php code-->

  <div class="background">
    <div class="booking-form">
        <center>
            <br>
            <br>
            <br>
            <br>
            <h1 style="color: #365F32;">Payment</h1>
            <h4>Online Payment Transaction</h4>
            <br>
        </center>
<!-- Start of Payment Form -------------------------------------------------------->
    <div class="form-bg">
        <form id="payment-form" action="booking-process.html" method="post">
            <h3>Payment Channels</h3>
            <p>Bank of the Philippine Islands (BPI): 98765432112345</p>
            <p>Banco De Oro (BDO): 98765432112345</p>
            <p>Gcash or PayMaya: 09282828282</p>
            <br><br>
            <h3>Total Fare for Your Trip:</h3>
            <textarea disabled><?php echo $total_price ?></textarea>
            <br>
            <hr>
            <br>
            <h3>Enter Reference Number: </h3>
            <input type="text" name="name" id="name" required>
            <h3>Upload Proof of Payment Screenshot: </h3>
            <input type="file" name="Screenshot" id="Screenshot" accept=".png, .jpeg, .pdf" required>
            <h6>*You may upload .png, .jpeg, or pdf file</h6>
        </form>
    </div>
<!-- End of Payment Form -------------------------------------------------------->

<!-- Start of Buttons -------------------------------------------------------->
    <div class="button-container">
    <button onclick="location.href='booking-form1.html'" type="button" style="background-color: #7788E5;">Cancel</button>
    <button type="button" onclick="resetForm()" style="background-color: #E57777;">Clear Form</button>
    <!--<form action="../php/generate-email.php" method="post">-->
      <button onclick="validateForm()" type="submit" style="background-color: #54CC36;" name ="button_clicked">Submit</button>

    
</div>
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
