<?php
session_start();

$username = $pass = '';
$errors = array('username' => '', 'password' => '');
$error = '';

if (isset($_POST['submit'])) {

    if (empty($_POST['username'])) {
        $errors['username'] = "Username is empty";
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "Password is empty";
    }

    if (empty($errors['username']) && empty($errors['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $db = mysqli_connect('localhost', 'root', '', 'da_1');

        if (!$db) {
            die('Không thể kết nối với database: ' . mysqli_connect_error());
        }

        $sql = "SELECT username, password, quyenhan FROM users WHERE username=?";
        $stmt = mysqli_prepare($db, $sql);

        // Gắn giá trị vào các tham số
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Thực thi câu truy vấn
        mysqli_stmt_execute($stmt);

        // Lấy kết quả
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            // Khai báo biến để lưu kết quả
            $userResult = mysqli_fetch_assoc($result);
            if ($userResult) {
                $hashedPassword = $userResult['password'];

                if (password_verify($password, $hashedPassword)) {
                    // Mật khẩu đúng, thực hiện đăng nhập thành công

                    if (isset($userResult['quyenhan']) && $userResult['quyenhan'] === 'admin') {
                        $_SESSION['username'] = $username;
                        $_SESSION['quyenhan'] = $userResult['quyenhan'];
                        header('Location: ../admin/admin.php');                        
                        exit();
                    } else {
                        $error = "You do not have access.";
                    }
                } else {
                    $error = "Username or Password is not correct.";
                }
            } else {
                $error = "Username or Password is not correct.";
            }
        } else {
            // Xử lý lỗi
            echo mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/sign in.css">
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

    .loginbox {
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

    .loginbox h1 {
        margin: 0;
        padding: 0 0 20px;
        text-align: center;
        font-size: 24px;
    }

    .loginbox p {
        margin: 0;
        padding: 0;
        font-weight: bold;
    }

    .loginbox input[type="email"],
    .loginbox input[type="password"],
    .loginbox input[type="text"] {
        border: none;
        border-bottom: 1px solid #fff;
        background: transparent;
        outline: none;
        height: 40px;
        color: #fff;
        font-size: 16px;
    }

    .loginbox input[type="submit"] {
        border: none;
        outline: none;
        height: 40px;
        background: #fb2525;
        color: #fff;
        font-size: 18px;
        border-radius: 20px;
        cursor: pointer;
    }

    .loginbox input[type="submit"]:hover {
        background: #ffc107;
        color: #000;
    }

    .loginbox a {
        text-decoration: none;
        font-size: 14px;
        color: #fff;
    }

    .loginbox a:hover {
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
    }
</style>

<body>
    <div class="loginbox">
        <img src="images/woowa_logo.png" class="avatar">
        <br>
        <h1>Login Here</h1>
        <form method="post">
            <p>User name</p>
            <input type="text" name="username" placeholder="Enter Username" value="<?php echo htmlspecialchars($username) ?>">
            <div class="error-message"><?php echo $errors['username']; ?></div><br>
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($pass) ?>">

            <div class="error-message"><?php echo $errors['password']; ?><?php echo $error; ?></div><br>

            <input type="submit" name="submit" value="Login">

            <a href="#">Lost your password?</a><br>
            <a href="SignIn.php">Sign Up</a><br>
            <a href="../index.html">Quay lại trang chủ</a><br>

        </form>
    </div>
</body>

</html>
