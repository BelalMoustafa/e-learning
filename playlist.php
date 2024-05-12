<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edutube</title>
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

    <!-- Preloader -->

    <!-- Preloader End -->

    <!-- Scroll Top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="tg-flaticon-arrowhead-up"></i>
    </button>
    <?php
include './components/nav.php';
?>
    <?php
    $get_id = isset($_GET['get_id']) ? $_GET['get_id'] : '';
    if ($get_id === '') {
        header('location:index.php');
        exit;
    }

    $message = [];
    ?>

    <!-- Playlist Section -->
    <section class="all-courses-area section-py-120">
        <div class="container">
            <div class="row">
                <?php
                $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND status = ? LIMIT 1");
                $select_playlist->execute([$get_id, 'active']);
                if ($select_playlist->rowCount() > 0) {
                    $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);

                    $playlist_id = $fetch_playlist['id'];

                    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
                    $select_tutor->execute([$fetch_playlist['tutor_id']]);
                    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                ?>
                    <div class="col-xl-12 col-lg-12">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                                <div class="row courses__grid-wrap row-cols-12 row-cols-xl-12 row-cols-lg-12 row-cols-md-12 row-cols-sm-12">
                                    <div class="col-12">
                                        <div class="courses__item shine__animate-item">
                                            <div class="courses__item-thumb">
                                                <a href="#" class="shine__animate-link">
                                                    <img src="uploaded_files/<?= $fetch_playlist['thumb']; ?>" class="thumb" alt="Playlist Thumbnail">
                                                </a>
                                            </div>
                                            <div class="courses__item-content">
                                                <ul class="courses__item-meta list-wrap">
                                                    <li class="avg-rating date"><?= $fetch_playlist['date']; ?></li>
                                                </ul>
                                                <h5 class="title"><?= $fetch_playlist['title']; ?></h5>
                                                <p class="description"><?= $fetch_playlist['description']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } else { ?>
                    <p class="empty">This playlist was not found!</p>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Playlist Section End -->

    <!-- Videos Container Section -->
    <section class="videos-container section-py-120">
        <div class="container">
            <div class="row">
               <h1>Videos</h1>
                <div class="col-xl-9 col-lg-8">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                            <div class="row courses__grid-wrap row-cols-1 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1">
                                <?php
                                $select_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ? ORDER BY date DESC");
                                $select_content->execute([$get_id, 'active']);
                                if ($select_content->rowCount() > 0) {
                                    while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <div class="col">
                                            <div class="courses__item shine__animate-item">
                                                <div class="courses__item-thumb">
                                                    <a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>" class="shine__animate-link">
                                                        <img src="uploaded_files/<?= $fetch_content['thumb']; ?>" class="thumb" alt="img">
                                                    </a>
                                                </div>
                                                <div class="courses__item-content">
                                                    <h5 class="title"><a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>"><?= $fetch_content['title']; ?></a></h5>
                                                    <!-- Remove unnecessary description and button -->
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<p class="empty">No videos added yet!</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
                            </div>
                            
                        </div>
                        
                        
                    </div>

    <!-- Videos Container Section End -->

    <!-- Footer Area -->
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
    <!-- Footer Area End -->

    <!-- JS here -->
    <!-- <script src="assets/js/vendor/jquery-3.6.0.min.js"></script> -->
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
