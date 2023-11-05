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
  .confirmTable {
            width: 100%;
            max-width: 500px; 
            margin: 0 auto;
            padding: 10px;
            background-color: #f2eacb;
            border: 1px solid #365F32;
            font-family: 'Times New Roman', Times, serif;
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
        <li><a href="../pages/landing-page.html" id="active-page">HOME</a></li>
        <li><a href="booking-form2.php">BOOKING</a></li>
        <li>
          <a href="#">TRANSACTIONS</a>
        </li>
        <li>
          <a href="../pages/about-us.html">ABOUT US</a>
        </li>
        <li><a href="#">PROFILE</a></li>
        <div class="login">
          <a href="../pages/login-page.html" id="login-button">LOGIN</a>
        </div>
      </ul>
      <label for="menu-btn" class="navbtn menu-btn"
        ><i class="fa fa-bars"></i
      ></label>
    </div>
  </nav>
<!-- End of Navigation Bar -------------------------------------------------------->
<br>
<br>
<br>
<br>
<br>
<!--Php Codes to display booking form details-->
<?php
//get data from html form
$name = $_POST["name"];
$number = $_POST["contact"];
$pick_up = $_POST["pick-up"];
$drop_off = $_POST["drop-off"];
$date = $_POST["departure-date"];
$time = $_POST['departure-time'];
$passenger_number = $_POST['passenger-count'];

session_start();
$_SESSION['pick-up'] = $pick_up;
$_SESSION['drop-off'] = $drop_off;
$_SESSION['passenger-count'] = $passenger_number;

$conn = new mysqli('localhost','root','','ticket_system');

if ($conn->connect_error) {
    die(''. $conn->connect_error);
}
else{
    //insert into the database
    $sql = "INSERT INTO booking_form (customer_name, number, pick_up, drop_off, date, time, passenger_number)
            VALUES (?, ?, ?, ?, ?, ?, ?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssi", $name, $number, $pick_up, $drop_off, $date, $time, $passenger_number);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
<!--End of php code-->

<!-- Start of booking-form2.html (confirmation part) -------------------------------------------------------->
<center><h1 style="color: #365F32;">Confirm Details Below</h1></center>
<br>
<div class="confirmTable">
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
      <br><br>
      <center><p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: red;">(If you wish to edit your booking details, kindly go back to the previous page)</p></center>
  </div>
</div>

<!-- End of booking-form2.html (confirmation part) -------------------------------------------------------->

<!-- Start of Buttons -------------------------------------------------------->

                <div class="button-container">
                    <button onclick="location.href='booking-form1.html'" type="button" style="background-color: #7788E5;">Go Back</button>
                    <button onclick="location.href='booking-payment.php'" type="button" style="background-color: #54CC36;">Confirm</button>
                </div>
<!-- End of Buttons -------------------------------------------------------->
            </div>
        </div>
    </div>
</body>
</html>
