<?php
session_start();
include "../php/server.php";
if (!isset($_SESSION["user_id"])) {
  header("Location: login-page.html");
  exit();
}
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

    <!-- Start of Style for booking-form1.html -------------------------------------------------------->
    <style>
      .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
      }
      .button-container button {
        background-color: #e57777;
        padding: 10px 20px;
        margin: 0 10px;
      }
    </style>
    <!-- End of Style for booking-form1.html -------------------------------------------------------->
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
          <li><a href="../index.php">HOME</a></li>
          <li><a href="../pages/booking-form1.php" id="active-page">BOOKING</a></li>
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

    <!--BOOKING FORM-->
    <div class="background">
      <div class="booking-form">
        <br />
        <br />
        <br />
        <h1 style="color: #365f32">Booking Form</h1>
        <!-- Start of Booking Form -------------------------------------------------------->
        <div class="form-bg" id="booking">
          <form action="../pages/booking-form2.php" method="post" id="booking-form">
            <!--<label for="name">Customer's Name: </label>
                    <input type="text" name="name" id="name" required>
     
                    <label for="contact">Contact Number:</label>
                    <input type="text" name ="contact" id="contact" required>-->

            <label for="pick-up">Pick-up Terminal:</label>
            <input type="text" name="pick-up" value="pick up" required readonly>
            <!--<select name="pick-up" id="pick-up" required>
              <option value="" disabled selected>Select Terminal</option>
              <option value="Cubao">Cubao</option>
              <option value="Gil Puyat">Gil Puyat</option>
            </select>-->

            <label for="drop-off">Drop-off Destination:</label>
            <input type="text" name="drop-off" value="drop off" required readonly>
            <!--<select name="drop-off" id="drop-off" required>
              <option value="" disabled selected>Select Destination</option>
              <option value="Baguio">Baguio</option>
              <option value="Batangas">Batangas</option>
              <option value="Bicol">Bicol</option>
              <option value="Bataan">Bataan</option>
              <option value="La Union">La Union</option>
              <option value="Pampanga">Pampanga</option>
              <option value="Tagaytay">Tagaytay</option>
            </select>-->

            <label for="departure-date">Choose Preferred Date:</label>
            <input type="text" name="date" value="date" required readonly>


            <!--BAWASAN TO-->
            <label for="departure-time">Choose Preferred Time:</label>
            <select name="departure-time" id="departure-time" required>
              <option value="" disabled selected>Select Time</option>
              <option value="4:00:00">4:00 AM</option>
              <option value="7:00:00">7:00 AM</option>
              <option value="9:00:00">9:00 AM</option>
              <option value="13:00:00">1:00 PM</option>
              <option value="15:00:00">3:00 PM</option>
              <option value="17:00:00">5:00 PM</option>
            </select>
           
            <label for="passenger-count">Number of Passengers:</label>
            <select name="passenger-count" id="passenger-count" required>
              <option value="" disabled selected>
                Select Number of Passengers
              </option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
            </select>
            <!-- Start of Buttons -------------------------------------------------------->
            <div class="button-container">
              <button type="button" onclick="resetForm()" style="background-color: #e57777">
                Clear Form
              </button>
              <button onclick="validateForm()" type="submit" style="background-color: #e5cc77">
                Next
              </button>
            </div>
            <!-- End of Buttons -------------------------------------------------------->
          </form>
        </div>
        <!-- End of Booking Form -------------------------------------------------------->
      </div>
    </div>

    <!-- Start of Form Script (to reset, validate form, disable past time, and disable past dates) -------------------------------------------------------->
    <script>
      function resetForm() {
        document.getElementById("booking-form").reset();
      }

      function validateForm() {
        var form = document.getElementById("booking-form");
        var selectedTime = form["departure-time"].value;
        var currentTime = new Date().toTimeString().slice(0, 5);

        if (form.checkValidity() && selectedTime >= currentTime) {
          location.href = "booking-form2.html";
        } else {
          if (selectedTime < currentTime) {
            alert("Please select time.");
          } else {
            alert("Please fill in all required fields.");
          }
        }
      }

      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); // January is 0!
      var yyyy = today.getFullYear();
      today = yyyy + "-" + mm + "-" + dd;
      document.getElementById("departure-date").setAttribute("min", today);
    </script>
    <!-- End of Form Script (to reset, validate form, disable past time, and disable past dates) -------------------------------------------------------->

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
  <script src="../script.js"></script>
</html>
