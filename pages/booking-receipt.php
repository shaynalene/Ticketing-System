<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BTS | Bus Ticketing System</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />

<!-- Start of Style for booking-form2.html -------------------------------------------------------->
<style>
  .title {
        text-align: center;
    }

  .receiptTable {
            width: 100%;
            max-width: 500px; 
            margin: 0 auto;
            padding: 10px;
            background-color: #f2eacb;
            border: 2px dotted #365F32;
            font-family: 'Times New Roman', Times, serif;
   }

   .ticket{
       text-align: center;
   }

  .ticketNumber {
      font-weight: bold;
      font-size: 25px;
      color: #365F32;
  }

  .number {
      font-weight: bold;
      font-size: 25px;
  }

  .details {
      margin: 10px 0;
  }

  .question {
      font-weight: bold;
  }

  .answer {
      float: right;
  }

  .button-container {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
  }

  .button-container button {
      padding: 10px 20px;
      margin: 10px;
  }

  /* Responsiveness Code */
  @media (max-width: 768px) {
      .confirmTable {
          padding: 20px;
      }
      .button-container {
          flex-direction: column;
          align-items: center;
      }
      .button-container button {
          margin: 5px;
      }
  }


       
    </style>
<!-- End of Style for booking-form2.html -------------------------------------------------------->

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
        <li><a href="../index.php">HOME</a></li>
        <li><a href="../pages/booking-form1.php" id="active-page">BOOKING</a></li>
        <li>
          <a href="transaction.html">TRANSACTIONS</a>
        </li>
        <li>
          <a href="../pages/about-us.html">ABOUT US</a>
        </li>
        <li><a href="#">FEEDBACK</a></li>
        <div class="login">
          <a href="../pages/profile-page.php" id="login-button">Your Account</a>
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
include "../php/server.php";
//get data from html form
session_start();
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$number = $_SESSION['number'];
$pick_up = $_SESSION['pick-up'];
$drop_off = $_SESSION['drop-off'];
$date = $_SESSION['departure-date'];
$time = $_SESSION['departure-time'];
$passenger_number = $_SESSION['passenger-count'];

$name = $firstname . ' ' . $lastname;
?>
<!--End of php code-->

<br>
<br>
<br>
<br>
<br>
<!-- Start of booking-form2.html (confirmation part) -------------------------------------------------------->
<div class="title">
    <h1 style="color: #365F32;">Booking Confirmed!</h1>
    <p>Here are your booking details:</p>
</div>
<br>
<div class="receiptTable">
    <div class="ticket">
    <span class="ticketNumber">Bus Ticket #: </span>
    <span class="number">number here</span>
    </div>
    <br><br>
  <div class="details">
      <span class="question">Customer's Name:</span>
      <span class="answer"><?php echo $name ?></span>
      <br><br>
      <span class="question">Contact Number:</span>
      <span class="answer"><?php echo $number ?></span>
      <br><br>
      <span class="question">Pick-up Terminal:</span>
      <span class="answer"><?php echo $pick_up ?></span>
      <br><br>
      <span class="question">Drop-off Destination:</span>
      <span class="answer"><?php echo $drop_off ?></span>
      <br><br>
      <span class="question">Departure Date:</span>
      <span class="answer"><?php echo $date ?></span>
      <br><br>
      <span class="question">Departure Time:</span>
      <span class="answer"><?php echo $time ?></span>
      <br><br>
      <span class="question">Number of Passengers:</span>
      <span class="answer"><?php echo $passenger_number ?></span>
     </div>
</div>

<!-- End of booking-form2.html (confirmation part) -------------------------------------------------------->

<!-- Start of Buttons -------------------------------------------------------->

                <div class="button-container">
                    <button onclick="location.href='../index.html'" type="button" style="background-color: #54CC36;">Go to Home Page</button>
                </div>
<!-- End of Buttons -------------------------------------------------------->
            </div>
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
</body>
</html>
