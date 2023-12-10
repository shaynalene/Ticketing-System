<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    header("Location: login-page.html");
    exit();
}

// Fetch seat statuses from the database
$sql = "SELECT bus_seat, status FROM seat_reservation";
$result = $conn->query($sql);

// Create an associative array to store seat statuses
$seatStatuses = [];
while ($row = $result->fetch_assoc()) {
    $seatStatuses[$row['bus_seat']] = $row['status'];
}

/*
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset"]) && !isset($_SESSION["reset_clicked"])) {
  $_SESSION["reset_clicked"] = true;
    $status = "vacant";
    $reserved = "reserved";
    $sql = "UPDATE seat_reservation SET status=? WHERE status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $status, $reserved); 
    $stmt->execute();
    $stmt->close();
}*/
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
    <style>
    .seatButton {
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: green;
      color: white;
    }
    .selected{
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: red;
      color: white;
    }
    .reserved{
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: red;
      color: white;
    }
  </style>
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
              <a href="index.php" id="active-page">HOME</a>
            </li>
            <li>
              <a href="../pages/booking-form1.php">BOOKING</a>
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

    <!-- SEAT SELECTION -->
    <!--<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <button type="submit" name="reset">RESET IN DATABASE</button>
    </form>-->
    <button onclick="resetSeats()">UNSELECT</button>
    <button onclick="confirm()" name="confirm">CONFIRM</button>

    <table border="1">
        <?php
        $rows = ['A', 'B', 'C', 'D', 'E', 'F'];
        $cols = [1, 2, 3, 4];

        foreach ($rows as $row) {
            echo "<tr>";

            foreach ($cols as $col) {
                $seatId = $row . $col;
                $buttonClass = 'seatButton';

                // Check if the seat is reserved
                if (isset($seatStatuses[$seatId]) && $seatStatuses[$seatId] === 'reserved') {
                    $buttonClass = 'reserved';
                }

                echo "<td><button onclick=\"buttonClick('$row', $col)\" name=\"$row$col\" id=\"$row$col\" class=\"$buttonClass\">$row$col</button></td>";
            }

            echo "</tr>";
        }
        ?>
    </table>

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
  <script>
    function buttonClick(row, col) {
      //alert('Button clicked: Row ' + row + ', Column ' + col);
      var button = row+col;
      document.getElementById(button).classList.remove('seatButton');
      document.getElementById(button).classList.add('selected');
      console.log(button);
    }

    function resetSeats() {
      var buttons = document.querySelectorAll('.selected');
      for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('selected');
        buttons[i].classList.add('seatButton');
      }
      // Trigger form submission
      document.getElementById('resetForm').submit();
    }

    function confirm(){
      alert('Confirm');
      var buttons = document.querySelectorAll('.selected');
      var selectedValues = [];
      
      for (var i = 0; i < buttons.length; i++) {
        var selected = buttons[i].id;
        selectedValues.push(selected);
        console.log(selected);
      }

      // Send selectedValues array to PHP using AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '../php/seat.php', true); // Specify the correct PHP script filename
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Handle the response from the server if needed
          console.log(xhr.responseText);
        }
      };

      // Convert the array to a JSON string for easy handling on the server
      var jsonData = JSON.stringify({ selectedValues: selectedValues });

      // Send the data to the server
      xhr.send('jsonData=' + encodeURIComponent(jsonData));
    }
  </script>
</html>