


<!doctype html>
<html class="no-js" lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>v</title>
    <meta name="description" content="SkillGro - Online Courses & Education Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/flaticon-skillgro.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default-icons.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/spacing.css">
    <link rel="stylesheet" href="assets/css/tg-cursor.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <!--Preloader-->

    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="tg-flaticon-arrowhead-up"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->
    <?php
include '../components/nav_admin.php';
?>
    <!-- header-area-end -->



    <!-- main-area -->
    <main class="main-area fix">


    <?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:../login.php');
}

if(isset($_POST['delete_video'])){
   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $verify_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
   $verify_video->execute([$delete_id]);
   if($verify_video->rowCount() > 0){
      $delete_video_thumb = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
      $delete_video_thumb->execute([$delete_id]);
      $fetch_thumb = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fetch_thumb['thumb']);
      $delete_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
      $delete_video->execute([$delete_id]);
      $fetch_video = $delete_video->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fetch_video['video']);
      $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
      $delete_content->execute([$delete_id]);
      $message[] = 'video deleted!';
   }else{
      $message[] = 'video already deleted!';
   }

}

if(isset($_POST['delete_playlist'])){
   $delete_id = $_POST['playlist_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND tutor_id = ? LIMIT 1");
   $verify_playlist->execute([$delete_id, $tutor_id]);

   if($verify_playlist->rowCount() > 0){

   

   $delete_playlist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
   $delete_playlist_thumb->execute([$delete_id]);
   $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);

   $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
   $delete_playlist->execute([$delete_id]);
   $message[] = 'playlist deleted!';
   }else{
      $message[] = 'playlist already deleted!';
   }
}

?>

   
<section class="all-courses-area section-py-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                        <div class="row courses__grid-wrap row-cols-1 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1">
                            <?php
                            if(isset($_POST['search']) or isset($_POST['search_btn'])){
                                $search = $_POST['search'];
                                $select_videos = $conn->prepare("SELECT * FROM `content` WHERE title LIKE '%{$search}%' AND tutor_id = ? ORDER BY date DESC");
                                $select_videos->execute([$tutor_id]);
                                if($select_videos->rowCount() > 0){
                                    while($fecth_videos = $select_videos->fetch(PDO::FETCH_ASSOC)){ 
                                        $video_id = $fecth_videos['id'];
                            ?>
                            <div class="col">
                                <div class="courses__item shine__animate-item">
                                    <div class="courses__item-thumb">
                                        <a href="view_content.php?get_id=<?= $video_id; ?>" class="shine__animate-link">
                                            <img src="../uploaded_files/<?= $fecth_videos['thumb']; ?>" class="thumb" alt="img">
                                        </a>
                                    </div>
                                    <div class="courses__item-content">
                                        <ul class="courses__item-meta list-wrap">
                                            <li class="courses__item-tag">
                                                <a href="view_content.php?get_id=<?= $video_id; ?>" class="status" style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>">
                                                    <?= $fecth_videos['status']; ?>
                                                </a>
                                            </li>
                                            <li class="avg-rating date"><?= $fecth_videos['date']; ?></li>
                                        </ul>
                                        <h5 class="title"><?= $fecth_videos['title']; ?></h5>
                                        <p class="description">Bfdsfsdfsdf</p>
                                        <div class="courses__item-bottom">
                                            <div class="button">
                                                <a href="update_content.php?get_id=<?= $video_id; ?>">
                                                    <span class="text">Update</span>
                                                    <i class="flaticon-arrow-right"></i>
                                                </a>
                                            </div>
                                            <form action="" method="post" class="button">
                                                <input type="hidden" name="video_id" value="<?= $video_id; ?>">
                                                <input type="submit" value="Delete" class="text delete-btn" onclick="return confirm('Delete this video?');" name="delete_video">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                } else {
                                    echo '<p class="empty">No contents found!</p>';
                                }
                            } else {
                                echo '<p class="empty">Please search something!</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="all-courses-area section-py-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                        <div class="row courses__grid-wrap row-cols-1 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1">
                            <?php
                            if(isset($_POST['search']) or isset($_POST['search_btn'])){
                                $search = $_POST['search'];
                                $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE title LIKE '%{$search}%' AND tutor_id = ? ORDER BY date DESC");
                                $select_playlist->execute([$tutor_id]);
                                if($select_playlist->rowCount() > 0){
                                    while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
                                        $playlist_id = $fetch_playlist['id'];
                                        $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                                        $count_videos->execute([$playlist_id]);
                                        $total_videos = $count_videos->rowCount();
                            ?>
                            <div class="col">
                                <div class="courses__item shine__animate-item">
                                    <div class="courses__item-thumb">
                                        <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="shine__animate-link">
                                            <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" class="thumb" alt="Playlist Thumbnail">
                                        </a>
                                    </div>
                                    <div class="courses__item-content">
                                        <ul class="courses__item-meta list-wrap">
                                            <li class="courses__item-tag">
                                                <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="status" style="<?php if($fetch_playlist['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_playlist['status']; ?></a>
                                            </li>
                                            <li class="avg-rating date"><?= $fetch_playlist['date']; ?></li>
                                        </ul>
                                        <h5 class="title"><a href="view_playlist.php?get_id=<?= $playlist_id; ?>"><?= $fetch_playlist['title']; ?></a></h5>
                                        <p class="description"><?= $fetch_playlist['description']; ?></p>
                                        <div class="courses__item-bottom">
                                            <div class="button">
                                                <a href="update_playlist.php?get_id=<?= $playlist_id; ?>">
                                                    <span class="text">Update</span>
                                                    <i class="flaticon-arrow-right"></i>
                                                </a>
                                            </div>
                                            <form action="" method="post" class="button">
                                                <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
                                                <input type="submit" value="Delete Playlist" class="text delete-btn" onclick="return confirm('Delete this playlist?');" name="delete">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    } 
                                } else {
                                    echo '<p class="empty">No playlists found!</p>';
                                }
                            } else {
                                echo '<p class="empty">Please search something!</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>











<script src="../js/admin_script.js"></script>

<script>
   document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
      if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
   });
</script>

 
        <!-- all-courses-end -->

    </main>
    <!-- main-area-end -->


<footer class="footer__area footer__area-two">
        <div class="footer__top">
        </div>
        <div class="footer__bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="copy-right-text">
                            <p>© 2024-2025 Edutube.</p>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="footer__bottom-menu">
                            <ul class="list-wrap">
                                <li><a href="https://www.facebook.com/profile.php?id=61553985513121&mibextid=ZbWKwL"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://wa.me/+201550056744/"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/edutubex/"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="https://youtube.com/@Edutube394?si=mRVlUKZEzbc36F8I"><i class="fab fa-youtube"></i></a></li>
                            
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- JS here -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.odometer.min.js"></script>
    <script src="assets/js/jquery.appear.js"></script>
    <script src="assets/js/tween-max.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/jquery.marquee.min.js"></script>
    <script src="assets/js/tg-cursor.min.js"></script>
    <script src="assets/js/vivus.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/svg-inject.min.js"></script>
    <script src="assets/js/jquery.circleType.js"></script>
    <script src="assets/js/jquery.lettering.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        SVGInject(document.querySelectorAll("img.injectable"));
    </script>
</body>


</html>