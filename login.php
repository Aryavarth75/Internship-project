<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="topnav">
        <div class="ulnav">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a>Address</a></li>
                <li><a>Complain</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
    <div class="contain">
        <div class="box">
            <p>Login</p>
            <form method="post" action="login.php">
                <div class="boxnav">
                    <ul>
                        <li class="borli"><p>Enter Email:</p><input type="email" name="Email" required/></li>
                        <li class="borli"><p>Enter Password:</p><input type="password" name="Password" required/></li>
                    </ul>
                </div>
                <div class="subbot"><input type="submit" name="submit" value="Login"/></div>
            </form>
            <div class="create"><a href="register.php">Create/Register</a></div>
        </div>
    </div>
    <?php
    session_start();
    if (isset($_POST['submit'])) {
        $email = $_POST['Email']; 
        $password = $_POST['Password'];

        $con = new mysqli("localhost", "root", "", "helpdesk");

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $stmt = $con->prepare("SELECT * FROM customer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                header('Location: dasbord.php');
            } else {
                $_SESSION['error'] = "Invalid password";
                header('Location: login.php');
            }
        } else {
            $_SESSION['error'] = "User not found";
            header('Location: register.php');
        }

        $stmt->close();
        $con->close();
    }
    ?>
</body>
</html>
