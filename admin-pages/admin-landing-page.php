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
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="shortcut icon"
      type="image/jpg"
      href="../Ticketing-System/img/bts-logo.png"
    />
  </head>
  <body class="pages-flex">
    <!-- NAVIGATION BAR -->
    <div class="navbar-ctr">
      <nav class="navbar">
        <div class="wrapper">
          <div class="logo">
            <a href="#"
              ><img
                src="../Ticketing-System/img/bts-logo-nav.png"
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
              <a href="index.php" id="active-page">HOME</a>
            </li>
            <li>
              <a href="../pages/booking-form1.php">BOOKING</a>
            </li>
            <li>
              <a href="../pages/transaction.php">TRANSACTIONS</a>
            </li>
            <li>
              <a href="../pages/about-us.html">ABOUT US</a>
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
          <div class="title-header">ONLINE VIEWBOARD</div>
          <button id="editButton" class="editButtonLP">Edit Trips</button>
          <button id="addRowButton" class="editButtonLP" style="display: none">
            Add Trip
          </button>
          <!-- HIDE UNLESS ITS ON ADMIN SIDE !! TO BE EDITED -->
        </div>
        <div id="lastEditDate">UPDATED AS OF: 00/00/00 00:00 AM/PM</div>
      </div>
      <div class="table-wrapper">
        <table id="editableTable" class="fl-table">
          <thead>
            <tr>
              <th>PICK UP</th>
              <th>DROP OFF</th>
              <th>PRICE</th>
              <th>BUS NO.</th>
              <!--<th>TRAVEL DATE</th>-->
              <th>STATUS</th>
            </tr>
          </thead>
          <tbody>
            <!--
          <?php
          include "../Ticketing-System/php/server.php";
          $sql = "SELECT pick_up, drop_off, price FROM destinations";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['pick_up']}</td>
                          <td>{$row['drop_off']}</td>
                          <td>{$row['price']}</td>
                          <td>##</td>
                          <td>00/00/00</td>
                          <td>00:00:00 AM/PM</td>
                          <td>ACTIVE</td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='3'>No records found</td></tr>";
          }
          ?>
          -->
            <tr>
              <td contenteditable="false">PLACE</td>
              <td contenteditable="false">###</td>
              <td contenteditable="false">##</td>
              <td contenteditable="false">00/00/00</td>
              <!--<td contenteditable="false">00:00:00 AM/PM</td>-->
              <td contenteditable="false">ACTIVE</td>
            </tr>
          </tbody>
        </table>
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
  <script src="../script.js"></script>
</html>