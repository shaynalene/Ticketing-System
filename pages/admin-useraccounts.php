<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login-page.html");
  exit();
}

//if edit button is clicked
if (isset($_POST['edit'])){
  $user_id = $_POST["user_id"];
  $username = $_POST["username"];
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $number = $_POST["number"];
  $email = $_POST["email"];
  $account_status = $_POST["account_status"];
  $user_type = $_POST["user_type"];

  $sql = "UPDATE user_accounts SET username = ?, firstname = ?, lastname = ?, number = ?, email = ?, account_status = ? WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sssissi', $username, $firstname, $lastname, $number, $email, $account_status, $user_id);
  $stmt->execute();
  $stmt->close();
}

//if remove button is clicked
if (isset($_POST['remove'])){
  $user_id = $_POST["user_id"];
  $account_status = "deactivated";

  $sql = "UPDATE user_accounts SET account_status = ? WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $account_status, $user_id);
  $stmt->execute();
  $stmt->close();
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
              <a href="../pages/admin-landing-page.php">HOME</a>
            </li>
            <!--<li>
              <a href="../pages/booking.php">BOOKING</a>
            </li>-->
            <li>
              <a href="../pages/admin-transaction.php">TRANSACTIONS</a>
            </li>
            <li>
            <a href="../pages/admin-useraccounts.php">USERS</a>
            </li>
            <li><a href="../pages/admin-feedback.html">FEEDBACK</a></li>
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
          <div class="title-header">USER ACCOUNTS</div>
        </div>
        <!--<div id="lastEditDate">UPDATED AS OF: 00/00/00 00:00 AM/PM</div>-->
      </div>
      <div class="table-wrapper">
        <table id="editableTable" class="fl-table">
          <thead>
            <tr>
              <th>ROLE</th>
              <th>USERNAME</th>
              <th>LAST NAME</th>
              <th>FIRST NAME</th>
              <th>PHONE NUMBER</th>
              <th>EMAIL</th>
              <th>STATUS</th>
              <th>MODIFY</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $sql = "SELECT * FROM user_accounts WHERE account_status = 'active'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['user_type']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['firstname']}</td>
                        <td>{$row['lastname']}</td>
                        <td>{$row['number']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['account_status']}</td>
                        <td><button id=\"modifyButton\" class=\"editButtonLP\" onclick=\"displayUserAccount('{$row['user_id']}', '{$row['user_type']}', '{$row['username']}', '{$row['firstname']}', '{$row['lastname']}', '{$row['number']}', '{$row['email']}', '{$row['account_status']}')\">Modify</button></td>
                        </tr>";
                }
            }
          ?>
          </tbody>
        </table>

        <div class="editpopup-container" id="editpopupContainer">
          <h3 class="recordtitle">EDIT RECORD</h3>
          <br />
          <div class="details" id="editpopupContent"></div>
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
            onclick="closePopupUA()"
          >
            Close
          </button>
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
  <script src="../script.js"></script>
</html>
