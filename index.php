<?php
require_once "include/@connect.php";

$select_likes = $db->prepare("SELECT COUNT(user_id) AS count FROM `likes` WHERE user_id = ?");
$select_likes->bind_param("s", $user_id);
$select_likes->execute();
$total_likes = $select_likes->get_result()->fetch_assoc()["count"];

$select_comments = $db->prepare("SELECT COUNT(user_id) FROM `comments` WHERE user_id = ?");
$select_comments->bind_param("s", $user_id);
$select_comments->execute();
$total_comments = $select_comments->get_result()->fetch_assoc()["count"];

$select_bookmark = $db->prepare("SELECT COUNT(user_id) FROM `bookmark` WHERE user_id = ?");
$select_bookmark->bind_param("s", $user_id);
$select_bookmark->execute();
$total_bookmarked = $select_bookmark->get_result()->fetch_assoc()["count"];

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include "include/head.php" ?>
</head>
<body>
    <?php include 'include/user_header.php'; ?>

    <section class="quick-select">
        <h1 class="heading">Tùy chọn nhanh</h1>
        <div class="box-container">

            <?php
                if($user_id != ''){
            ?>
            <div class="box">
                <h3 class="title">Thích và bình luận</h3>
                <p>Lượt thích: <span><?= $total_likes; ?></span></p>
                <a href="likes.php" class="inline-btn">Xem lượt thích</a>
                <p>Lượt bình luận: <span><?= $total_comments; ?></span></p>
                <a href="comments.php" class="inline-btn">Xem bình luận</a>
                <p>Lưu: <span><?= $total_bookmarked; ?></span></p>
                <a href="bookmark.php" class="inline-btn">Danh sách đã lưu</a>
            </div>
            <?php
                }else{ 
            ?>
            <?php
            }
            ?>

            <div class="box">
                <h3 class="title">Gợi ý tìm kiếm</h3>
                <div class="flex">
                    <a href="search_course.php?"><i class="fa-solid fa-calculator"></i><span>Toán</span></a>
                    <a href="#"><i class="fa-solid fa-book"></i><span>Ngữ Văn</span></a>
                    <a href="#"><i class="fas fa-pen"></i><span>Tiếng Anh</span></a>
                </div>
            </div>

            <div class="box">
                <h3 class="title">Được quan tâm</h3>
                <div class="flex">
                    <a href="search_course.php?"><i class="fa-solid fa-calculator"></i><span>Toán</span></a>
                    <a href="#"><i class="fa-solid fa-book"></i><span>Ngữ Văn</span></a>
                    <a href="#"><i class="fas fa-pen"></i><span>Tiếng Anh</span></a>
                </div>
            </div>

            <div class="box tutor">
                <h3 class="title">Trở Thành Nhà Sáng Tạo</h3>
                <p>Bằng việc trở thành nhà sáng tạo của chúng tôi bạn sẽ được đăng tải nội dung lên website của chúng tôi</p>
                <a href="admin/register.php" class="inline-btn">Bắt đầu</a>
            </div>

        </div>

    </section>

    <section class="courses">
        <h1 class="heading">Mới Nhất</h1>

        <div class="box-container">
            <?php
                $select_courses = $db->query("SELECT * FROM `playlist` WHERE status = 'active' ORDER BY date DESC LIMIT 6");
                if ($select_courses->num_rows <= 0) {echo '<p class="empty">Chưa có khóa học nào!</p>';}
                else {
                    while ($fetch_course = $select_courses->fetch_assoc()) {
                        $course_id = $fetch_course["id"];

                        $select_tutor = $db->prepare("SELECT * FROM `tutors` WHERE id = ?");
                        $select_tutor->bind_param("s", $fetch_course["tutor_id"]);
                        $select_tutor->execute();
                        $fetch_tutor = $select_tutor->get_result()->fetch_assoc();
                        ?>
                        <div class="box">
                            <div class="tutor">
                                <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                                <div>
                                    <h3><?= $fetch_tutor['name']; ?></h3>
                                    <span><?= $fetch_course['date']; ?></span>
                                </div>
                            </div>
                            <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
                            <h3 class="title"><?= $fetch_course['title']; ?></h3>
                            <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">Xem</a>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="more-btn">
            <a href="courses.php" class="inline-option-btn">Xem Thêm</a>
        </div>
    </section>

    <?php include "include/footer.php"; ?>
</body>
</html>