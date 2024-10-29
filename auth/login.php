<?php
require_once 'components/connect.php';

session_set_cookie_params(3600 * 24 * 7);
session_start();

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $pass = sha1($_POST['pass']);

    $select_user = $db->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
    $select_user->bind_param("ss", $email, $pass);
    $select_user->execute();
    $row = $select_user->fetch_assoc();

    if($select_user->length > 0){
        setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
        header('location:index.php');
    }else{
        $message = 'Email hoặc mật khẩu không chính xác!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
    <title>Trang chủ</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
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
    <?php include 'components/footer.html'; ?>
</body>
</html>