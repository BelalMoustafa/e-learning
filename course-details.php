<?php
if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:index.php');
}

?>
<!doctype html>
<html class="no-js" lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edutube</title>
    <meta name="description" content="Edutube">
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


    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="tg-flaticon-arrowhead-up"></i>
    </button>

    <?php include 'components/nav.php';?>



    <!-- main-area -->
    <main class="main-area fix">

        <!-- breadcrumb-area -->
        <div class="breadcrumb__area breadcrumb__bg breadcrumb__bg-two" data-background="assets/img/bg/breadcrumb_bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb__content">
                        </div>
                    </div>
                </div>
            </div>
            <div class="breadcrumb__shape-wrap">
                <img src="assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown">
                <img src="assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right" data-aos-delay="300">
                <img src="assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400">
                <img src="assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left" data-aos-delay="400">
                <img src="assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400">
            </div>
        </div>

        <section class="courses__details-area section-py-120">
            <div class="container">
                <div class="row">
                        <?php
                            $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? and status = ? LIMIT 1");
                            $select_playlist->execute([$get_id, 'active']);
                            if($select_playlist->rowCount() > 0){
                                $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);
                                $playlist_id = $fetch_playlist['id'];
                                $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                                $count_videos->execute([$playlist_id]);
                                $videos_count = $count_videos->rowCount();
                                $total_videos = $count_videos->rowCount();
                                $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
                                $select_tutor->execute([$fetch_playlist['tutor_id']]);
                                $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                        ?>
                    <div class="col-xl-9 col-lg-8">
                        <div class="courses__details-thumb">
                            <img src="uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="img">
                        </div>
                        <div class="courses__details-content">
                            <h2 class="title"><?= $fetch_playlist['title']; ?></h2>
                            <div class="courses__details-meta">
                                <ul class="list-wrap">
                                    <li class="author-two">
                                        <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="img" style="width: 100px;">
                                        By
                                        <a><?= $fetch_tutor['name']; ?></a>
                                    </li>
                                    <li class="date"><i class="flaticon-calendar"></i><?= $fetch_playlist['date']; ?></li>
                                </ul>
                            </div>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="overview-tab-pane" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                                    <div class="courses__overview-wrap">
                                        <h3 class="title">Course Description</h3>
                                        <p><?= $fetch_playlist['description']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="courses__details-sidebar">
                            <div class="courses__cost-wrap">
                                <span>This Course Fee:</span>
                                <h2 class="title">$<?= $fetch_playlist['price']; ?></h2>
                            </div>
                            <div class="courses__information-wrap">
                                <h5 class="title">Course includes:</h5>
                                <ul class="list-wrap">
                                    <li>
                                        <img src="assets/img/icons/course_icon03.svg" alt="img" class="injectable">
                                        Lessons
                                        <span><?=$videos_count?></span>
                                    </li>
                                    <li>
                                        <?php
                                        $code="";
                                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                $code = $_POST['code'];
                                                $stmt = $conn->prepare("SELECT * FROM code WHERE code = ? and playlist_id=?");
                                                $stmt->execute([$code,$get_id]);
                                                if ($stmt->rowCount() > 0) {
                                                    $code_stmt = $conn->prepare("SELECT * FROM code_user WHERE code = ?");
                                                    $code_stmt->execute([$code]);
                                                    if ($code_stmt->rowCount() > 0) {
                                                        $user_stmt = $conn->prepare("SELECT * FROM code_user WHERE code = ? and user_id=?");
                                                        $user_stmt->execute([$code, $_COOKIE['user_id']]);
                                                        if ($user_stmt->rowCount() > 0) {
                                                            $code = $_POST['code'];
                                                        }else{
                                                            $code = "";
                                                        }
                                                    }else{
                                                        $user_stmt = $conn->prepare("INSERT INTO code_user (code,user_id) VALUES(?,?)");
                                                        $user_stmt->execute([$code, $_COOKIE['user_id']]);
                                                        $code = $_POST['code'];
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($code == ""||$stmt->rowCount() !=1) {
                                                ?>
                                                <form class="account__form" action="" method="post" enctype="multipart/form-data">
                                                    <div class="form-grp">
                                                        <input type="text" id="code" name="code" placeholder="Enter Code" required>
                                                        <button type="submit" name="submit" class="btn btn-two arrow-btn">Enter Code<img
                                                                src="assets/img/icons/right_arrow.svg" alt="img" class="injectable"></button>
                                                    </div>
                                                </form>
                                                <?php
                                            }elseif ($stmt->rowCount() > 0) {
                                                ?>
                                                <a href="playlist.php?get_id=<?= $fetch_playlist['id']; ?>">
                                                    <span class="text">View Playlist</span>
                                                    <i class="flaticon-arrow-right"></i>
                                                </a>
                                                <?php
                                            }
                                                ?>
                                        </li>
                                        </ul>
                                    </div>
                                <?php
                                }else{
                                    echo '<p class="empty">this playlist was not found!</p>';
                                }  
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- courses-details-area-end -->

    </main>
    <!-- main-area-end -->



    <!-- footer-area -->
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
    <!-- footer-area-end -->



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