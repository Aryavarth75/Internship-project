<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="address.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$con = new mysqli("localhost", "root", "", "helpdesk");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$email = $_SESSION['email'];
$stmt = $con->prepare("SELECT * FROM customer WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$helpdesk = $result->fetch_assoc();


// next code.........................................

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Insert into customer_address table
    $nA = $_POST['Street'];
    $nB = $_POST['City'];
    $nC = $_POST['state'];
    $nD = $_POST['Country'];
    $nE = $_POST['Zipcode'];
    $nF =  $_POST['Contact'];
    $ID = $helpdesk['sn'];
    $stmt = $con->prepare("INSERT INTO address_customer (customer_id, street, city, state, country, zipcode, contact) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss",  $ID, $nA, $nB, $nC, $nD, $nE, $nF);

    if ($stmt->execute()) {
        echo "Address added successfully";
        $_SESSION['customer_id'] =  $ID;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
    
    header('Location: address.php'); // redirect to the dashboard after update
    exit();
}

$stmt->close();
$con->close();



?>
    <div class="topnav">
    <div class="welcome">
            <p>Welcome <?php echo htmlspecialchars($helpdesk['first_name']); ?></p>
        </div>
        <div class="ulnav">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="address.php">Address</a></li>
                <li><a href="complain.php">Complain</a></li>
                <li><a href="sout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="contain">
    
        <div class="info">
            <h2>Add Address</h2>
            <form method="POST" action="">
    <div class="boxnav">
                    <ul>
                        <li class="borli"><p>Street:</p><input type="text" name="Street" required/></li>
                        <li class="borli"><p>City:</p><input type="text" name="City" required/></li>
                        <li class="borli"><p>State:</p><input type="text" name="state" required/></li>
                        <li class="borli"><p>Country:</p><input type="text" name="Country" required/></li>
                        <li class="borli"><p>Zipcode:</p><input type="text" name="Zipcode" required/></li>
                        <li class="borli"><p>Contact no.:</p><input type="text" name="Contact" required/></li>
                    </ul>
                </div>
                <div id="add"><input type="submit" value="Add"></div>
            </form>
       
       </div>
       <div class="address"><h2>Address</h2>
    <?php

$servername = "localhost"; 
$username = "root";    
$password = "";     
$dbname = "helpdesk"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all complaints
$sql = "SELECT street, city, state, country, zipcode, contact FROM address_customer";
$result = $conn->query($sql);

// Check if there are results and display them
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Street</th>
                <th>City</th>
                <th>State</th>
                <th>Country</th>
                <th>Zipcode</th>
                <th>Contact</th>
            </tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["street"]. "</td>
                <td>" . $row["city"]. "</td>
                <td>" . $row["state"]. "</td>
                <td>" . $row["country"]. "</td>
                <td>" . $row["zipcode"]. "</td>
                <td>" . $row["contact"]. "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the connection
$conn->close();

    ?>
    </div>
    </div>
</body>
</html>