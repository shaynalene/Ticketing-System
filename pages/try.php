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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset"]) && !isset($_SESSION["reset_clicked"])) {
    $_SESSION["reset_clicked"] = true;
    $status = "vacant";
    $reserved = "reserved";
    $sql = "UPDATE seat_reservation SET status=? WHERE status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $status, $reserved); 
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Button Grid</title>
  <style>
    .seatButton {
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: green;
      color: white;
    }
    .selected {
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: red;
      color: white;
    }
  </style>
</head>
<body>
<!-- SEAT SELECTION -->

<!--admin side lang yung may reset button -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <button type="submit" name="reset">RESET</button>
</form>


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
                $buttonClass = 'selected';
            }

            echo "<td><button onclick=\"buttonClick('$row', $col)\" name=\"$row$col\" id=\"$row$col\" class=\"$buttonClass\">$row$col</button></td>";
        }

        echo "</tr>";
    }
    ?>
</table>

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
        //console.log(button[i]);
      }
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

</body>
</html>
