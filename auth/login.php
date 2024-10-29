<?php
require_once "include/@connect.php";

if ($logged_in) {
    header("Location: /");
    exit;
}

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $pass = sha1($_POST['pass']);

    $login_stmt = $db->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
    $login_stmt->bind_param("ss", $email, $pass);
    $login_stmt->execute();
    $login_result = $login_stmt->get_result()->fetch_assoc();

    if ($login) {
        $_SESSION["user_id"] = $login_result["id"];
        $_SESSION["name"] = $login_result["name"];
        $_SESSION["password"] = $login_result["password"];
        header("Location: /");
        exit;
    }

    $message = "Email hoặc mật khẩu không chính xác!";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include "include/head.php" ?>
</head>
<body>
    <?php include "include/user_header.php"; ?>
    
    <section class="form-container">
        <form action method="post" enctype="multipart/form-data" class="login">
            <h3>Chào mừng trở lại!</h3>
            <p>Email <span>*</span></p>
            <input type="email" name="email" placeholder="Email" maxlength="50" required class="box">
            <p>Mật khẩu <span>*</span></p>
            <input type="password" name="pass" placeholder="Mật khẩu" maxlength="20" required class="box">
            <p class="link">Bạn chưa có tài khoản? <a href="register.php">Đăng kí</a></p>
            <input type="submit" name="submit" value="Đăng nhập" class="btn">
        </form>
    </section>

    <?php include "include/footer.html"; ?>
</body>
</html>