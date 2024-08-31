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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];

    // Update customer details
    $update_stmt = $con->prepare("UPDATE customer SET first_name = ?, last_name = ?, gender = ? WHERE email = ?");
    $update_stmt->bind_param("ssss", $first_name, $last_name, $gender, $email);

    if ($update_stmt->execute()) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile: " . $con->error;
    }

    

    $update_stmt->close();
    $stmt->close();
    $con->close();
    
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
    <title>Update Profile</title>
    <link rel="stylesheet" href="Update.css">
</head>
<body>
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
            <h2>Update Your Details</h2>
            <div class="input">
            <form method="POST" action="">
                <label for="first_name">First Name:</label><br>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($helpdesk['first_name']); ?>" required>
                <br>
                <label for="last_name">Last name:</label><br>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($helpdesk['last_name']); ?>" required>
                <br>
                <label for="gender">Gender:</label><br>
                <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($helpdesk['gender']); ?>" required>
                <br>
             
                <div class="update"><input type="submit" value="Update"></div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
