<!DOCTYPE html>
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
        $stmt = $conn->query("SELECT code FROM code ORDER BY id DESC LIMIT 1");
        $fetch_code = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() != 1) {
            $code = 'No code';
        } else {
            $code = $fetch_code['code'];
        }
        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
        $select_tutor->execute([$tutor_id]);
        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
        $name = isset($fetch_tutor['name']) ? $fetch_tutor['name'] : "Guest";
        $admin = false;
        if ($fetch_tutor['email'] == "hr@edutubeacademy.com"||"marketing@edutubeacademy.com"||"social@edutubeacademy.com"||"technicalsupport@edutubeacademy.com"||"mohamed98.reda@gmail.com"||"coo@edutubeacademy.com") {
            $admin = true;
        }
        if ($admin) {
            $select_playlists = $conn->prepare("SELECT * FROM `playlist`");
            $select_playlists->execute();
            $total_playlists = $select_playlists->rowCount();
            $select_contents = $conn->prepare("SELECT * FROM `content`");
            $select_contents->execute();
            $total_contents = $select_contents->rowCount();
        }else {
            $select_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
            $select_contents->execute([$tutor_id]);
            $total_contents = $select_contents->rowCount();
            $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
            $select_playlists->execute([$tutor_id]);
            $total_playlists = $select_playlists->rowCount();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-';
            $newCode = substr(str_shuffle($characters), 0, 8);
            $playlist = $_POST['playlist'];
            $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);
            $stmt = $conn->prepare("INSERT INTO code (code,playlist_id) VALUES(?,?)");
            $stmt->execute([$newCode, $playlist]);
            header("Location: index.php");
            exit();
        }
        ?>
        <section class="all-courses-area section-py-120">
            <div class="container">
                <div class="row courses__grid-wrap row-cols-1 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1">
                    <div class="col">
                        <div class="courses__item shine__animate-item">
                            <div class="courses__item-content">
                                <h5 class="description">
                                    <?= $name; ?>
                                </h5>
                                <p class="description">Welcome!</p>
                                <a href="profile.php" class="btn">View Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="courses__item shine__animate-item">
                            <div class="courses__item-content">
                                <h5 class="title">
                                    <?= $total_contents; ?>
                                </h5>
                                <p class="description">Total contents</p>
                                <a href="add_content.php" class="btn">Add new content</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="courses__item shine__animate-item">
                            <div class="courses__item-content">
                                <h5 class="title">
                                    <?= $total_playlists; ?>
                                </h5>
                                <p class="description">Total playlists</p>
                                <a href="add_playlist.php" class="btn">Add new playlist</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="courses__item shine__animate-item">
                            <div class="courses__item-content">
                                <form method="post">
                                    <div class="form-group">
                                        <p class="description" id="generatedCode">
                                            <?= $code ?>
                                        </p>
                                        <select name="playlist" class="form-control" required>
                                            <option value="" disabled selected>-- Select Playlist --</option>
                                            <?php
                                            if ($select_playlists->rowCount() > 0) {
                                                while ($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $fetch_playlist['id']; ?>">
                                                        <?= $fetch_playlist['title']; ?>
                                                    </option>
                                                    <?php
                                                }
                                            } else {
                                                echo '<option value="" disabled>No playlist created yet!</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn mt-2" name="generateCode">Generate Code</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="courses__item shine__animate-item">
                            <div class="courses__item-content">
                                <h5 class="description">Online Content</h5>
                                <a href="get_online.php" class="btn">View Online Content</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($admin) {
                    ?>
                    <div class="col">
                        <div class="courses__item shine__animate-item">
                            <div class="courses__item-content">
                                <h5 class="description">Add Teacher</h5>
                                <a href="register.php" class="btn">Add Teacher</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="col">
                        <div class="courses__item shine__animate-item">
                            <div class="courses__item-content">
                                <h5 class="description">Add Ads</h5>
                                <a href="add_ads.php" class="btn">Add Ads</a>
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