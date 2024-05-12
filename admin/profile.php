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


    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="tg-flaticon-arrowhead-up"></i>
    </button>
    <?php
include '../components/nav_admin.php';
?>
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
        <!-- breadcrumb-area-end -->

        <!-- instructor-details-area -->
        <?php

        include '../components/connect.php';
        
        if(isset($_COOKIE['tutor_id'])){
            $tutor_id = $_COOKIE['tutor_id'];
        
            $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
            $select_playlists->execute([$tutor_id]);
            $total_playlists = $select_playlists->rowCount();
        
            $select_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
            $select_contents->execute([$tutor_id]);
            $total_contents = $select_contents->rowCount();

            // Fetching tutor profile information
            $fetch_profile_stmt = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
            $fetch_profile_stmt->execute([$tutor_id]);
            $fetch_profile = $fetch_profile_stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $tutor_id = '';
            header('location:../login.php');
            exit;
        }
        
        ?>
        <section class="instructor__details-area section-pt-120 section-pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="instructor__details-wrap">
                            <div class="instructor__details-info">
                                <div class="instructor__details-thumb">
                                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="<?= $fetch_profile['name']; ?>">
                                </div>
                                <div class="instructor__details-content">
                                    <h2 class="title"><?= $fetch_profile['name']; ?></h2>
                                    <span class="profession"><?= $fetch_profile['profession']; ?></span><br><br>
                                    <a href="update.php" class="btn btn-primary col-12">update profile</a>
                                </div>
                            </div>
                            <div class="instructor__details-Skill">
                                <div class="instructor__progress-wrap">
                                    <ul class="list-wrap">
                                        <li>
                                            <div class="progress-item">
                                                <h6 class="title"><?= $total_playlists; ?></h6>
                                                <p>Total Playlists</p>
                                                <a href="playlists.php" class="btn">View Playlists</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="progress-item">
                                                <h6 class="title"><?= $total_contents; ?></h6>
                                                <p>Total Videos</p>
                                                <a href="contents.php" class="btn">View Contents</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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


<!-- Mirrored from themegenix.com/demo/skillgro/instructor-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Jan 2024 10:43:37 GMT -->
</html>