<?php
if (isset($message)) {
    foreach ($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">
    <section class="flex">

        <a href="index.php" class="logo">Huong Tra</a>

        <form action="search_course.php" method="post" class="search-form">
            <input type="text" name="search_course" placeholder="Tìm kiếm..." required maxlength="100">
            <button type="submit" class="fas fa-search" name="search_course_btn"></button>
        </form>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <?php
                $select_profile = $db->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->bind_params("s", $user_id);
                $select_profile->execute();
                if ($select_profile->num_rows > 0) {
                    $fetch_profile = $select_profile->get_result()->fetch_assoc();
                    ?>
                    <img src="uploaded_files/<?= $fetch_profile['image'] ?>" alt="">
                    <h3><?= $fetch_profile['name'] ?></h3>
                    <span>Học sinh</span>
                    <a href="profile.php" class="btn">Hồ sơ</a>
                    <div class="flex-btn" style="display: none;">
                        <a href="login.php" class="option-btn" style="font-size: 16px;padding: 12px;">Đăng nhập</a>
                        <a href="register.php" class="option-btn" style="padding: 12px;">Đăng kí</a>
                    </div>
                    <a href="/auth/logout.php" onclick="return confirm('Bạn có muốn đăng xuất?');" class="delete-btn">Đăng xuất</a>
            <?php } ?>
        </div>
    </section>
</header>

<div class="side-bar">
    <div class="close-side-bar">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <?php
            $select_profile = $db->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->bind_params("s", $user_id);
            $select_profile->execute();
            if ($select_profile->num_rows > 0) {
                $fetch_profile = $select_profile->get_result()->fetch_assoc();
                ?>
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                <h3><?= $fetch_profile['name']; ?></h3>
                <span>Học sinh</span>
                <a href="profile.php" class="btn">Hồ sơ</a>
        <?php } else { ?>
            <div class="flex-btn" style="padding-top: .5rem;">
                <a href="login.php" class="option-btn" style="padding: 12px;font-size: 17px;">Đăng nhập</a>
                <a href="register.php" class="option-btn" style="padding: 12px;font-size: 17px;">Đăng kí</a>
            </div>
        <?php } ?>
    </div>

    <nav class="navbar">
        <a href="index.php"><i class="fas fa-home"></i><span>Trang Chủ</span></a>
        <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Học</span></a>
        <a href="teachers.php"><i class="fa-solid fa-user-group"></i><span>Nhà Sáng Tạo</span></a>
        <a href="contact.php"><i class="fa-solid fa-phone"></i><span>Hỗ Trợ</span></a>
    </nav>
</div>