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
    $gender = $_POST['gender'];

    $update_stmt = $con->prepare("UPDATE customer SET first_name = ?, gender = ? WHERE email = ?");
    $update_stmt->bind_param("sss", $first_name, $gender, $email);

    if ($update_stmt->execute()) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile: " . $con->error;
    }

    $update_stmt->close();
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
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <div class="topnav">
        <div class="ulnav">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a>Product</a></li>
                <li><a>Contact</a></li>
                <li><a href="sout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="contain">
        <div class="info">
            <h2>Update Your Details</h2>
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
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
    <?php
   if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $nA = $_POST['Street'];
        $nB = $_POST['City'];
        $nC = $_POST['State'];
        $nD = $_POST['Country'];
        $nE = $_POST['Zipcode'];
        $nF = $_POST['Contact'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "helpdesk";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO customer_address (street, city , state, country, zipcode, contact) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nA, $nB, $nC, $nD, $nE, $nF);

        if ($stmt->execute()) {
            $update_stmt->close();
            header('Location: dasbord.php'); // redirect to the dashboard after update
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>

