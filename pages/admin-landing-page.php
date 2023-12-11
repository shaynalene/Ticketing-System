<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login-page.html");
  exit();
}

//get data from session
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$number = $_SESSION['number'];
$name = $firstname . ' ' . ' ' . $lastname;

//if add button is clicked
if (isset($_POST['save'])){
  $pick_up = $_POST["pickup"];
  $drop_off = $_POST["dropoff"];
  $price = $_POST["price"];
  $bus_number = $_POST["busnumber"];
  $date = $_POST["date"];
  //$time = $_POST["time"];

  $sql = "INSERT INTO bus_schedule (pick_up, drop_off, price, bus_number, date/*, time*/) VALUES (?, ?, ?, ?, ?/*, ?*/)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssiis', $pick_up, $drop_off, $price, $bus_number, $date/*, $time*/);
  $stmt->execute();
  $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM seat_reservation WHERE bus_no=?");
    $stmt->bind_param("i", $bus_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      $sql = "INSERT INTO seat_reservation (bus_no, bus_seat, status, booking_id)
      VALUES
      ($bus_number, 'A1', 'vacant', ''),
      ($bus_number, 'A2', 'vacant', ''),
      ($bus_number, 'A3', 'vacant', ''),
      ($bus_number, 'A4', 'vacant', ''),
      ($bus_number, 'B1', 'vacant', ''),
      ($bus_number, 'B2', 'vacant', ''),
      ($bus_number, 'B3', 'vacant', ''),
      ($bus_number, 'B4', 'vacant', ''),
      ($bus_number, 'C1', 'vacant', ''),
      ($bus_number, 'C2', 'vacant', ''),
      ($bus_number, 'C3', 'vacant', ''),
      ($bus_number, 'C4', 'vacant', ''),
      ($bus_number, 'D1', 'vacant', ''),
      ($bus_number, 'D2', 'vacant', ''),
      ($bus_number, 'D3', 'vacant', ''),
      ($bus_number, 'D4', 'vacant', ''),
      ($bus_number, 'E1', 'vacant', ''),
      ($bus_number, 'E2', 'vacant', ''),
      ($bus_number, 'E3', 'vacant', ''),
      ($bus_number, 'E4', 'vacant', ''),
      ($bus_number, 'F1', 'vacant', ''),
      ($bus_number, 'F2', 'vacant', ''),
      ($bus_number, 'F3', 'vacant', ''),
      ($bus_number, 'F4', 'vacant', '')
      ;";
      $conn->query($sql);
    }
}

//if edit button is clicked
if (isset($_POST['edit'])){
  $schedule_id = $_POST["schedule_id"];
  $pick_up = $_POST["pick_up"];
  $drop_off = $_POST["drop_off"];
  $price = $_POST["price"];
  $bus_number = $_POST["bus_number"];
  $date = $_POST["date"];
  //$time = $_POST["time"];

  $sql = "UPDATE bus_schedule SET pick_up = ?, drop_off = ?, price = ?, bus_number = ?, date = ?/*, time = ?*/ WHERE schedule_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssiisi', $pick_up, $drop_off, $price, $bus_number, $date/*, $time*/, $schedule_id);
  $stmt->execute();
  $stmt->close();
}

//if remove button is clicked
if (isset($_POST['remove'])){
  $schedule_id = $_POST["schedule_id"];

  $sql = "DELETE FROM bus_schedule WHERE schedule_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $schedule_id);
  $stmt->execute();
  $stmt->close();

  $bus_number = $_POST["bus_number"];

  $sql = "DELETE FROM seat_reservation WHERE bus_no = $bus_number";
  $result = $conn->query($sql);
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
              <a href="" id="active-page">HOME</a>
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
                >Account</a
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
          <button id="addButton" class="editButtonLP" onclick="addRecord()">
            Add Trip
          </button>
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
              <th>MODIFY</th>
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
                        <td>-</td>
                        <td><button id=\"modifyButton\" class=\"editButtonLP\" onclick=\"displayRecord('{$row['schedule_id']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['price']}', {$row['bus_number']}, {$row['date']},{$row['time']})\">Edit</button></td>
                        </tr>";
                }
            }
            ?>
          </tbody>
        </table>

        <div class="addpopup-container" id="addpopupContainer">
          <h3 class="recordtitle">ADD RECORD</h3>
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
            onclick="closePopup()"
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
