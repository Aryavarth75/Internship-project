<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="Dasbord.css">
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
            <h2>Your Details</h2>
            <p>Name: <?php echo htmlspecialchars($helpdesk['first_name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($helpdesk['email']); ?></p>
            <p>Gender: <?php echo htmlspecialchars($helpdesk['gender']); ?></p>
            <div class="edit"><a href="update.php">Update Profile</a></div>
        </div>
    </div>
</body>
</html>
