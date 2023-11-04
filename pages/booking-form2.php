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
        .form-bg2 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button-container button {
            background-color: #7788E5;
            padding: 10px 20px;
            margin: 10px;
        }

        /* Responsiveness Code */
        @media (max-width: 768px) {
            .form-bg2 {
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
        <li><a href="../index.html" id="active-page">HOME</a></li>
        <li><a href="booking-form1.html">BOOKING</a></li>
        <li>
          <a href="#">TRANSACTIONS</a>
        </li>
        <li>
          <a href="#">ABOUT US</a>
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

    <div class="background">

<!--php code-->
<?php
//get data from html form
$name = $_POST["name"];
$number = $_POST["contact"];
$pick_up = $_POST["pick-up"];
$drop_off = $_POST["drop-off"];
$date = $_POST["departure-date"];
$time = $_POST['departure-time'];
$passenger_number = $_POST['passenger-count'];

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
<!--end of php code-->

<!-- Start of booking-form2.html (confirmation part) -------------------------------------------------------->
        <div class="booking-form">
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="form-bg2">
                <h1 style="color: #365F32;">Confirm Details</h1>
                <textarea disabled id="confirmation-details" style="width: 100%; height: 400px;">
                <h3>Name: <?php echo $name ?></h3>
                <h3>Contact Number: <?php echo $number ?></h3>
                <h3>Pick Up: <?php echo $pick_up ?></h3>
                <h3>Drop Off: <?php echo $drop_off ?></h3>
                <h3>Date: <?php echo $date ?></h3>
                <h3>Time: <?php echo $time ?></h3>
                <h3>Number of Passengers: <?php echo $passenger_number ?></h3>
              </textarea>
<!-- End of booking-form2.html (confirmation part) -------------------------------------------------------->

<!-- Start of Buttons -------------------------------------------------------->

                <div class="button-container">
                    <button onclick="location.href='booking-form1.html'" type="button">Go Back</button>
                    <button onclick="location.href='booking-payment.html'" type="button" style="background-color: #54CC36;">Confirm</button>
                </div>
<!-- End of Buttons -------------------------------------------------------->
            </div>
        </div>
    </div>
</body>
</html>
