<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Register.css">
</head>
<body>
    <div class="topnav">
        <div class="ulnav">
            <ul>
            <li><a href="index.html">Home</a></li>
                <li><a >Address</a></li>
                <li><a >Complain</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
    <div class="contain">
        <div class="box">
            <p>Registration</p>
            <form method="post" action="register.php">
                <div class="boxnav">
                    <ul>
                        <li class="borli"><p>First name:</p><input type="text" name="Firstname" required/></li>
                        <li class="borli"><p>Last name:</p><input type="text" name="Lastname" required/></li>
                        <li class="borli"><p>Email:</p><input type="email" name="Email" required/></li>
                        <li class="borli"><p>Password:</p><input type="password" name="Password" required/></li>
                        <li class="borli"><p>Gender:</p>
                    <div class="gender">
                        <input type="radio" id="check" name="Gender">
                        <label for="check-male">Male</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check" name="Gender">
                        <label for="check-female">Female</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check" name="Gender">
                        <label for="check-other">Other</label>
                    </div>
          </li>
                    </ul>
                </div>
                <div class="subbot"><input type="submit" name="submit" value="Register"/></div>
            </form>
            <div class="create"><a href="login.php">Login</a></div>
        </div>
    </div>
    <?php
    if(isset($_POST['submit'])){
        $n1 = $_POST['Firstname'];
        $n2 = $_POST['Lastname'];
        $n3 = $_POST['Email'];
        $n4 = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Hash the password
        $n5 = $_POST['Gender'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "helpdesk";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO customer (first_name, last_name, email, password, gender) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $n1, $n2, $n3, $n4, $n5);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
