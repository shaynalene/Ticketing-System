<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login-page.html");
  exit();
}

//get data from session
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$number = $_SESSION['number'];
$name = $firstname . ' ' . ' ' . $lastname;

//if confirm button is clicked
if (isset($_POST['confirm'])){
    $bus_number = $_POST["bus_number"];
    $pick_up = $_POST["pick_up"];
    $drop_off = $_POST["drop_off"];
    $price = $_POST["price"];
    $date = $_POST["date"];
    $time = $_POST["departure_time"];
    $passenger_number= $_POST["passenger_count"];
    $status = "For Approval";

    $total_price = $price * $passenger_number;

    $_SESSION['total_price'] = $total_price;
    $_SESSION['passenger_count'] = $passenger_number;
  
    $sql = "INSERT INTO booking_form (user_id, bus_number, pick_up, drop_off, date, time, passenger_number, status, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iissssisi', $user_id, $bus_number, $pick_up, $drop_off, $date, $time,  $passenger_number, $status, $total_price);
    $stmt->execute();
    $previous_booking_id = $stmt->insert_id;
    $_SESSION['booking_id'] = $previous_booking_id;
    $stmt->close();

    //redirect to next page
    header("Location: ../pages/seat-selection.php");
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
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="shortcut icon"
      type="image/jpg"
      href="../img/bts-logo.png"
    />
  </head>
  <body class="pages-flex-feedback">
    <!-- NAVIGATION BAR -->
    <div class="navbar-ctr">
      <nav class="navbar">
        <div class="wrapper">
          <div class="logo">
            <a href="#"
              ><img
                src="../img/bts-logo-nav.png"
                alt="BTS"
                class="logo-pic"
            /></a>
          </div>
          <input type="radio" name="slider" id="menu-btn" />
          <input type="radio" name="slider" id="close-btn" />
          <ul class="nav-links">
            <label for="close-btn" class="navbtn close-btn"
              ><i class="fa fa-times"></i
            ></label>
            <li>
              <a href="index.php">HOME</a>
            </li>
            <li>
              <a href="../pages/booking-form1.php" id="active-page">BOOKING</a>
            </li>
            <li>
              <a href="#">TRANSACTIONS</a>
            </li>
            <li>
              <a href="../pages/useraccounts.html">USERS</a>
            </li>
            <li><a href="#">FEEDBACK</a></li>
            <div class="login">
              <a
                href="../pages/profile-page.php"
                id="login-button"
                >Your Account</a
              >
            </div>
          </ul>
          <label for="menu-btn" class="navbtn menu-btn"
            ><i class="fa fa-bars"></i
          ></label>
        </div>
      </nav>
    </div>

    <!-- LANDING PAGE -->
    <div class="main-content">
      <div class="header">
        <div class="left-header-lp">
          <div class="title-header">BOOK A TRIP HERE</div>
        </div>
        <!--<div id="lastEditDate">UPDATED AS OF: 00/00/00 00:00 AM/PM</div>-->
      </div>
      <div class="table-wrapper">
        <table id="editableTable" class="fl-table">
          <thead>
            <tr>
              <th>PICK UP</th>
              <th>DROP OFF</th>
              <th>PRICE</th>
              <th>BUS NO.</th>
              <th>TRAVEL DATE</th>
              <th>-</th>
              <th>BOOK</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $sql = "SELECT * FROM bus_schedule";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['pick_up']}</td>
                        <td>{$row['drop_off']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['bus_number']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['schedule_id']}</td>
                        <td><button id='modifyButton' class='editButtonLP' name='book' onclick=\"booking('{$row['schedule_id']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['price']}', '{$row['bus_number']}', '{$row['date']}')\">Book</button></td>
                    </tr>";
                }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="addpopup-container" id="addpopupContainer">
          <h3 class="recordtitle">BOOKING FORM</h3>
          <br />
          <div class="details" id="addpopupContent"></div>
          <button
            style="
              background-color: #4caf50;
              color: white;
              padding: 10px;
              border: none;
              border-radius: 5px;
              cursor: pointer;
              position: absolute;
              top: 10px;
              right: 10px;
              z-index: 1001;
            "
            onclick="closePopup()"
          >
            Close
          </button>
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
  <script src="../script.js"></script>
</html>
