<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "da_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $pass = $replacePass = '';
$errors = array('username' => '', 'password' => '', 'replacepassword' => '');
$error = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['username'])) {
        $errors['username'] = "Username is empty";
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Password is empty";
    }
    if (empty($_POST['replacepassword'])) {
        $errors['replacepassword'] = "Password confirmation is empty";
    }
    if ($_POST['password'] !== $_POST['replacepassword']) {
        $errors['replacepassword'] = "Password confirmation does not match";
    }
    if (strlen($_POST['password']) > 1 && strlen($_POST['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters long. Please enter a valid password.";
    }

    if (empty($errors['username']) && empty($errors['password']) && empty($errors['replacepassword'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert signup data into the database
        $sql = "INSERT INTO users (username, password, quyenhan) VALUES ('$username', '$hashedPassword', 'user')";
        if (mysqli_query($conn, $sql)) {
            // Redirect to login page after successful signup
            header('Location: login.php');
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css">
</head>

<style type="text/css">
    body {
        background-image: url(images/korea2.png);
        background-size: cover;
        font-family: Arial, sans-serif;
    }

    .error-message {
        color: #FF3030;
    }

    .signupbox {
        width: 320px;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        top: 50%;
        left: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
        padding: 40px 20px;
        border-radius: 5px;
    }

    .signupbox h1 {
        margin: 0;
        padding: 0 0 20px;
        text-align: center;
        font-size: 24px;
    }

    .signupbox p {
        margin: 0;
        padding: 0;
        font-weight: bold;
    }

    .signupbox input[type="text"],
    .signupbox input[type="password"],
    .signupbox input[type="replacepassword"] {
        border: none;
        border-bottom: 1px solid #fff;
        background: transparent;
        outline: none;
        width: 100%;
        height: 40px;
        color: #fff;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .signupbox input:hover {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        height: 40px;
        color: #fff;
        font-size: 16px;
        border-bottom: 1px solid #0046AB;
    }

    .signupbox input[type="submit"] {
        width: 100%;
        border: none;
        outline: none;
        height: 40px;
        background: #0046AB;
        color: #fff;
        font-size: 18px;
        border-radius: 20px;
        cursor: pointer;
        margin: 0 auto;
        display: block;
    }

    .signupbox input[type="submit"]:hover {
        background: #ffc107;
        color: #000;
    }

    .signupbox a {
        text-decoration: none;
        font-size: 14px;
        color: #fff;
    }

    .signupbox a:hover {
        color: #ffc107;
    }

    .avatar {
        background: rgba(0, 0, 0, 0.7);
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
        display: block;
        margin: 0 auto;
        margin-bottom: 20px;
        opacity: 1;
    }

    .error-message {
        color: #FF3030;
        font-size: 14px;
        margin-top: 5px;
    }

    .password-strength {
        color: #FF3030;
    }
</style>

<body>
    <div class="signupbox">
        <img src="images/woowa_logo.png" class="avatar">
        <br>
        <h1>Sign Up</h1>
        <form method="post">
            <p>User name</p>
            <input type="text" name="username" placeholder="Enter Username" value="<?php echo htmlspecialchars($username) ?>">
            <div class="error-message"><?php echo $errors['username']; ?></div><br>
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($pass) ?>">
            <div class="error-message">
                <?php echo $errors['password']; ?>
                <p class="password-strength">
                    <?php
                    if (strlen($pass) >= 6) {
                        echo 'Strong';
                    } elseif (strlen($pass) > 0) {
                        echo 'Weak';
                    }
                    ?>
                </p>
            </div><br>

            <p>Confirm Password</p>
            <input type="password" name="replacepassword" placeholder="Confirm password" value="<?php echo htmlspecialchars($replacePass) ?>">
            <div class="error-message"><?php echo $errors['replacepassword']; ?></div><br>
            <input type="submit" name="submit" value="Sign Up">
            <br>
            <a href="Login.php">Already have an account? Log in</a><br>
        </form>
    </div>
</body>

</html>
<script>
    const passwordInput = document.querySelector('input[name="password"]');
    const passwordStrength = document.querySelector('.password-strength');

    passwordInput.addEventListener('input', () => {
        const password = passwordInput.value;
        let strength = '';

        if (password.length >= 6) {
            strength = 'Strong';
        } else if (password.length > 0) {
            strength = 'Weak';
        }

        passwordStrength.textContent = strength;
    });
</script>
