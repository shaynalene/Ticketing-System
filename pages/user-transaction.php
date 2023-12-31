<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    header("Location: login-page.html");
    exit();
}

//get data from other pages
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$number = $_SESSION['number'];
$name = $firstname . ' ' . $lastname;
$user_id = $_SESSION["user_id"];  

//cancel button is clicked
if (isset($_POST['cancel'])){
    $status = "Cancel Request";

    $selected_booking = $_POST["variable"];

    $sql = "UPDATE booking_form SET status=? WHERE user_id = ? AND booking_id = ?";
    $stmt = $conn->prepare($sql); $stmt->bind_param('sii', $status, $user_id,
$selected_booking); $stmt->execute(); $stmt->close(); } ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BTS | Bus Ticketing System</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../about-us.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />
    <style>
      body {
        font-family: "Arial", sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
      }
      /* Style for the 3 table containers (ongoing, upcoming, & past) */
      .container {
        max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      h1 {
        text-align: center;
        color: #333;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }
      th,
      td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
      th {
        background-color: #f2f2f2;
      }
      /* Style for the pop-up containers for view details button */
      .popup-container {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        width: 400px;
        height: 600px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
      }
      /* Style to center the content of the pop-up containers */
      #popupContent {
        text-align: center;
      }
      /* Style for the close button for the view details pop-up */
      .close-button {
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
        display: block;
      }
      /* Style for the cancel confirmation container */
      #cancelConfirmationContainer {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        width: 300px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1001;
        text-align: center;
      }
      #cancelConfirmationContainer h3 {
        margin-bottom: 20px;
        color: #333;
      }
      #cancelConfirmationContainer button {
        background-color: #e74c3c;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
      }
      .details-indiv {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .details-ctr {
        display: flex;
        flex-direction: column;
        gap: 1.5em;
      }
    </style>
  </head>
  <body>
    <!-- Start of Navigation Bar -------------------------------------------------------->
    <nav>
      <div class="wrapper">
        <div class="logo">
          <a href="#">
            <img src="../img/bts-logo-nav.png" alt="BTS" class="logo-pic" />
          </a>
        </div>
        <input type="radio" name="slider" id="menu-btn" />
        <input type="radio" name="slider" id="close-btn" />
        <ul class="nav-links">
          <label for="close-btn" class="navbtn close-btn"
            ><i class="fa fa-times"></i
          ></label>
          <li><a href="../index.php">HOME</a></li>
          <li><a href="../pages/booking.php">BOOKING</a></li>
          <li><a href="" id="active-page">TRANSACTIONS</a></li>
          <li><a href="../pages/about-us.html">ABOUT US</a></li>
          <li><a href="../pages/user-feedback.html">FEEDBACK</a></li>
          <div class="login">
            <a href="profile-page.php" id="login-button">Account</a>
          </div>
        </ul>
        <label for="menu-btn" class="navbtn menu-btn"
          ><i class="fa fa-bars"></i
        ></label>
      </div>
    </nav>
    <!-- End of Navigation Bar -------------------------------------------------------->

    <!-- Start of Transaction History (BODY)-------------------------------------------------------->
    <br /><br /><br /><br /><br /><br />
    <h1 style="color: #365f32">Transaction History</h1>

    <!-- UPCOMING ACTIVITY TABLE -->
    <div class="container">
      <h3 style="color: #365f32">UPCOMING ACTIVITY</h3>
      <table id="upcomingTable">
        <thead>
          <tr>
            <th>Date</th>
            <th>Pick up</th>
            <th>Destination</th>
            <th>Bus #</th>
            <th>Seat #</th>
            <th>Status</th>
            <th>View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include "../php/server.php";
            $sql = "SELECT
                BF.user_id,
                firstname,
                lastname,
                number,
                BF.booking_id,
                pick_up,
                drop_off,
                date,
                BF.time,
                passenger_number,
                BF.status,
                total_price,
                bus_number,
                bus_seat
            FROM
                booking_form BF
            INNER JOIN
                user_accounts UA ON BF.user_id = UA.user_id
            INNER JOIN
                seat_reservation SR ON BF.booking_id = SR.booking_id
            WHERE
                (BF.status = 'Cancel Request' OR BF.status = 'For Approval')
                AND BF.user_id = '$user_id'
                AND BF.booking_id = SR.booking_id
            GROUP BY
                BF.booking_id,
                BF.user_id
            ORDER BY
                status,
                date;
            ";           
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['date']}</td>
                        <td>{$row['pick_up']}</td>
                        <td>{$row['drop_off']}</td>
                        <td>{$row['bus_number']}</td>
                        <td>{$row['bus_seat']}</td>
                        <td>{$row['status']}</td>
                        <td><button onclick=\"displayReceipt('{$row['booking_id']}', '{$row['firstname']} {$row['lastname']}', '{$row['number']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['date']}', '{$row['time']}', '{$row['passenger_number']}', '{$row['status']}', '{$row['total_price']}', '{$row['bus_number']}')\">View Details</button></td>
                        </tr>";
                }
            }
          ?>
            </tbody>
        </table>
    </div>

    <!-- PAST ACTIVITY TABLE -->
    <div class="container">
      <h3 style="color: #365f32">CONFIRMED BOOKINGS</h3>
      <table id="pastTable">
        <thead>
          <tr>
            <th>Date</th>
            <th>Pick up</th>
            <th>Destination</th>
            <th>Bus #</th>
            <th>Seat #</th>
            <th>Status</th>
            <th>View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include "../php/server.php";
            $sql = "SELECT
              BF.user_id,
              firstname,
              lastname,
              number,
              BF.booking_id,
              pick_up,
              drop_off,
              date,
              BF.time,
              passenger_number,
              BF.status,
              total_price,
              bus_number,
              bus_seat
          FROM
              booking_form BF
          INNER JOIN
              user_accounts UA ON BF.user_id = UA.user_id
          INNER JOIN
              seat_reservation SR ON BF.booking_id = SR.booking_id
          WHERE
              (BF.status = 'Booking Cancelled' OR BF.status = 'Booking Approved')
              AND BF.user_id = '$user_id'
              AND BF.booking_id = SR.booking_id
          GROUP BY
              BF.booking_id,
              BF.user_id
          ORDER BY
              status,
              date;
          ";            
          $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                      <td>{$row['date']}</td>
                      <td>{$row['pick_up']}</td>
                      <td>{$row['drop_off']}</td>
                      <td>{$row['bus_number']}</td>
                      <td>{$row['bus_seat']}</td>
                      <td>{$row['status']}</td>
                      <td><button onclick=\"displayReceipt('{$row['booking_id']}', '{$row['firstname']} {$row['lastname']}', '{$row['number']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['date']}', '{$row['time']}', '{$row['passenger_number']}', '{$row['status']}', '{$row['total_price']}', '{$row['bus_number']}')\">View Details</button></td>
                      </tr>";
              }
          }
            ?>
            </tbody>
        </table>
    </div>

    <!-- POP-UP CONTAINER -->
    <div class="popup-container" id="popupContainer">
      <h3>Receipt Details</h3>
      <br />
      <div class="details" id="popupContent"></div>
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
      <button
        id="cancelButton"
        style="
          background-color: #e74c3c;
          color: white;
          padding: 10px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          position: absolute;
          bottom: 20px;
          left: 50%;
          transform: translateX(-50%);
          z-index: 1001;
        "
      >
        Cancel Booking
      </button>
    </div>

    <!-- Cancel Confirmation Container -->
    <div id="cancelConfirmationContainer"></div>

    <!-- End of Transaction History (BODY)-------------------------------------------------------->

    <script>
      function displayReceipt(booking_id, customer_name, number, pick_up, drop_off, date, time, passenger_number, status, total_price, bus_number) {
        document.getElementById("popupContent").innerHTML = `
            <div class="details-ctr">
            <div class="details-indiv">
            <span class="question">Transaction Number:</span>
            <span class="answer">${booking_id}</span>
            </div>

            <div class="details-indiv">
            <span class="question">Bus Number:</span>
            <span class="answer">${bus_number}</span>
            </div>

            <div class="details-indiv">
            <span class="question">Customer's Name:</span>
            <span class="answer">${customer_name}</span>
            </div>
 
            <div class="details-indiv">
            <span class="question">Contact Number:</span>
            <span class="answer">${number}</span>
            </div>
   
            <div class="details-indiv">
            <span class="question">Pick-up Terminal:</span>
            <span class="answer">${pick_up}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Drop-off Destination:</span>
            <span class="answer">${drop_off}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Departure Date:</span>
            <span class="answer">${date}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Departure Time:</span>
            <span class="answer">${time}</span>
            </div>
           
            <div class="details-indiv">
            <span class="question">Number of Passengers:</span>
            <span class="answer">${passenger_number}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Trip Fare:</span>
            <span class="answer">${total_price}</span>
            </div>
            
        </div>
        <hr>
        `;

        document.getElementById("popupContainer").style.display = "block";
        if (status == "For Approval") {
          document.getElementById("cancelButton").style.display = "block";
        } else {
          document.getElementById("cancelButton").style.display = "none";
        }

        document
          .getElementById("cancelButton")
          .addEventListener("click", function () {
            cancelUpcoming(booking_id);
          });
      }

      window.closePopup = function () {
        const popupContainer = document.getElementById("popupContainer");
        const cancelConfirmationContainer = document.getElementById(
          "cancelConfirmationContainer"
        );
        popupContainer.style.display = "none";
        cancelConfirmationContainer.style.display = "none";
      };

      // Function to start the cancellation process
      function cancelUpcoming(booking_id) {
        const cancelConfirmationContainer = document.getElementById(
          "cancelConfirmationContainer"
        );
        document.getElementById("cancelConfirmationContainer").innerHTML = `
        <h3>Confirm Cancellation</h3>
        <p>Are you sure you want to cancel this booking?</p>
        <form method="POST" action="">
        <input type ="hidden" name="variable" id="variable" value="${booking_id}"> 
        <button id="cancel" name="cancel" onclick="confirmCancellation(${booking_id})">Yes, Cancel</button>
        </form>
        <button style="background-color: #4CAF50; color: white;" onclick="closePopup()">No, Keep Booking</button>
        `;
        var selected_booking = booking_id;

        cancelConfirmationContainer.style.display = "block";
      }

      // Function to confirm the cancellation and update the status
      function confirmCancellation(booking_id) {
        const cancelButton = document.getElementById("cancelButton");
        alert(
          "Please wait for cancellation approval."
        );
        closePopup(); // Code to close the pop-up after canceling
      }
    </script>
  </body>
</html>
