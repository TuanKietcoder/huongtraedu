<?php
require_once "include/@connect.php";

if (isset($_POST['submit'])) {

    $id = unique_id();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);

    $image = $_FILES['image']['name'];
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_files/'.$rename;

    $select_user_stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user = $select_user_stmt->execute([$email]);
    
    if (!empty($select_user)) {
        $message = "email already taken!";
    } else if ($pass != $cpass) {
        $message = "confirm passowrd not matched!";
    } else {
        $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image) VALUES(?,?,?,?,?)");
        $insert_user->bind_param("sssss", $id, $name, $email, $cpass, $rename);
        $insert_success = $insert_user->execute();
        move_uploaded_file($image_tmp_name, $image_folder);
        
        if ($insert_success) {
            $_SESSION["user_id"] = $id;
            $_SESSION["name"] = $name;
            $_SESSION["password"] = $pass;
            header("Location: /");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "include/head.php" ?>
</head>
<body>
    <?php include "include/user_header.php" ?>

    <section class="form-container">
        <form class="register" action method="post" enctype="multipart/form-data">
            <h3>Tạo tài khoản</h3>
            <div class="flex">
                <div class="col">
                    <p>Họ và tên <span>*</span></p>
                    <input type="text" name="name" placeholder="Họ và tên" maxlength="50" required class="box">
                    <p>Email <span>*</span></p>
                    <input type="email" name="email" placeholder="Email" maxlength="50" required class="box">
                </div>
                <div class="col">
                    <p>Mật khẩu <span>*</span></p>
                    <input type="password" name="pass" placeholder="Mật khẩu" maxlength="20" required class="box">
                    <p>Xác nhận lại mật khẩu <span>*</span></p>
                    <input type="password" name="cpass" placeholder="Xác nhận lại mật khẩu" maxlength="20" required class="box">
                </div>
            </div>
            <p>Chọn ảnh <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
            <p class="link">Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            <input type="submit" name="submit" value="Đăng kí" class="btn">
        </form>
    </section>
    
    <?php include 'components/footer.php'; ?>
</body>
</html>