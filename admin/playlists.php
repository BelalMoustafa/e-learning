
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edutube</title>
    <meta name="description" content="Edutube">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
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

    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="tg-flaticon-arrowhead-up"></i>
    </button>
<?php
include '../components/nav_admin.php';
?>
    <main class="main-area fix">
        <?php
        include '../components/connect.php';
        if (isset($_COOKIE['tutor_id'])) {
            $tutor_id = $_COOKIE['tutor_id'];
        } else {
            $tutor_id = '';
            header('location:../login.php');
        }
        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
        $select_tutor->execute([$tutor_id]);
        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
        $admin = false;
        if ($fetch_tutor['email'] == "hr@edutubeacademy.com"||"marketing@edutubeacademy.com"||"social@edutubeacademy.com"||"technicalsupport@edutubeacademy.com"||"mohamed98.reda@gmail.com"||"coo@edutubeacademy.com") {
            $admin = true;
        }
        if ($admin) {
            if (isset($_POST['delete'])) {
                $delete_id = $_POST['playlist_id'];
                $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
                $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ?  LIMIT 1");
                $verify_playlist->execute([$delete_id, $tutor_id]);
                if ($verify_playlist->rowCount() > 0) {
                    $delete_playlist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
                    $delete_playlist_thumb->execute([$delete_id]);
                    $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
                    unlink('../uploaded_files/' . $fetch_thumb['thumb']);
                    $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
                    $delete_playlist->execute([$delete_id]);
                    $message[] = 'playlist deleted!';
                } else {
                    $message[] = 'playlist already deleted!';
                }
            }
        }else {
            if (isset($_POST['delete'])) {
                $delete_id = $_POST['playlist_id'];
                $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
                $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND tutor_id = ? LIMIT 1");
                $verify_playlist->execute([$delete_id, $tutor_id]);
                if ($verify_playlist->rowCount() > 0) {
                    $delete_playlist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
                    $delete_playlist_thumb->execute([$delete_id]);
                    $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
                    unlink('../uploaded_files/' . $fetch_thumb['thumb']);
                    $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
                    $delete_playlist->execute([$delete_id]);
                    $message[] = 'playlist deleted!';
                } else {
                    $message[] = 'playlist already deleted!';
                }
            }
        }
        ?>
        <section class="breadcrumb__area breadcrumb__bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb__content">
                            <h3 class="title">Playlists</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="breadcrumb__shape-wrap">
                <img src="assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown">
                <img src="assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right"
                    data-aos-delay="300">
                <img src="assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400">
                <img src="assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left"
                    data-aos-delay="400">
                <img src="assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400">
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
                                    if ($admin) {
                                        $select_playlist = $conn->prepare("SELECT * FROM `playlist` ORDER BY date DESC");
                                        $select_playlist->execute();
                                    }
                                    else {
                                        $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ? ORDER BY date DESC");
                                        $select_playlist->execute([$tutor_id]);
                                    }
                                    if ($select_playlist->rowCount() > 0) {
                                        while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                                            $playlist_id = $fetch_playlist['id'];
                                            $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                                            $count_videos->execute([$playlist_id]);
                                            $total_videos = $count_videos->rowCount();
                                    ?>
                                            <div class="col">
                                                <div class="courses__item shine__animate-item">
                                                    <div class="courses__item-thumb">
                                                        <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="shine__animate-link">
                                                            <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" class="thumb" alt="img">
                                                        </a>
                                                    </div>
                                                    <div class="courses__item-content">
                                                        <ul class="courses__item-meta list-wrap">
                                                            <li class="courses__item-tag">
                                                                <span class="status" style="<?php echo ($fetch_playlist['status'] == 'active') ? 'color: limegreen;' : 'color: red;'; ?>"><?php echo $fetch_playlist['status']; ?></span>
                                                            </li>
                                                            <li class="avg-rating date"><?= $fetch_playlist['date']; ?></li>
                                                        </ul>
                                                        <h5 class="title"><a href="view_playlist.php?get_id=<?= $playlist_id; ?>"><?= $fetch_playlist['title']; ?></a></h5>
                                                        <p class="description"><?= $fetch_playlist['description']; ?></p>
                                                        <div class="courses__item-bottom">
                                                            <div class="button">
                                                                <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">View Playlist</a><br>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
                                                                    <input type="submit" value="Delete" class="delete-btn btn" onclick="return confirm('Delete this playlist?');" name="delete">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<p class="empty">No playlist added yet!</p>';
                                    }
                                    ?>
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