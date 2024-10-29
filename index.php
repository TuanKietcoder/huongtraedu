<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->bind_param("s", $user_id)
$select_likes->execute([$user_id]);
$total_likes = $select_likes;

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang Chủ</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href=".//assets/css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- quick select section starts  -->

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

<!-- quick select section ends -->

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">Mới Nhất</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC LIMIT 6");
         $select_courses->execute(['active']);
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$fetch_course['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
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
      }else{
         echo '<p class="empty">Chưa có khóa học nào!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-option-btn">Xem Thêm</a>
   </div>

</section>

<!-- courses section ends -->












<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="/assets/js/script.js"></script>
   
</body>
</html>