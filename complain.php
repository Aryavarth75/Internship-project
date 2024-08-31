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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
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
    
    // Get form data
    $Tittle = $_POST['Tittle'];
    $Complain = $_POST['Complain'];
    $ID = $helpdesk['sn'];
   
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO address_complain (id_customer, id_customer_address, tittle, complain_detail) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ID, $ID, $Tittle, $Complain);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "New complaint recorded successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the connection
    $stmt->close();
    $conn->close();
    
    
    header('Location: dasbord.php'); // redirect to the dashboard after update
    exit();
}

$stmt->close();
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="Complain.css">
</head>
<body>



<div class="topnav">
<div class="welcome">
        <p>Welcome<?php echo htmlspecialchars($helpdesk['first_name']); ?></p>
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
        <h2>Enter your complaint</h2>
        <form method="POST" action="">
            <div class="boxnav">
                <ul>
                    <li class="borli">
                        <p>Title:</p>
                        <input type="text" name="Tittle" required/>
                    </li>
                    <li class="borli">
                        <p>Describe your complaint:</p>
                        <input type="text" name="Complain" id="in" required/>
                    </li>
                </ul>
            </div>
           <div id="submit"><input type="submit" value="Submit"></div> 
        </form>
    </div>
</div>
</body>
</html>

