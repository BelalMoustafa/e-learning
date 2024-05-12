<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="dexignlabs">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="v">
    <meta name="description" content="Edutube">
    <meta property="og:title" content="v">
    <meta property="og:description" content="Edutube">
    <meta property="og:image" content="../../products.w3itexpert.com/images/edumin_ogimage.png">
    <meta name="format-detection" content="telephone=no">
    <meta name="twitter:title" content="Edutube">
    <meta name="twitter:description" content="v">
    <meta name="twitter:image" content="../../products.w3itexpert.com/images/edumin_ogimage.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edutube</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
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
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                include '../components/nav_admin.php';
                include '../components/connect.php';
                if (isset($_COOKIE['tutor_id'])) {
                    $tutor_id = $_COOKIE['tutor_id'];
                } else {
                    $tutor_id = '';
                    header('location:../login.php');
                }
                if (isset($_POST['submit'])) {
                    $id = unique_id();
                    $title = $_POST['title'];
                    $title = filter_var($title, FILTER_SANITIZE_STRING);
                    $description = $_POST['description'];
                    $description = filter_var($description, FILTER_SANITIZE_STRING);
                    $link = $_POST['link'];
                    $link = filter_var($link, FILTER_SANITIZE_STRING);
                    $date = $_POST['date'];
                    $date = filter_var($date, FILTER_SANITIZE_STRING);
                    $time = $_POST['time'];
                    $time = filter_var($time, FILTER_SANITIZE_STRING);
                    $thumb = $_FILES['thumb']['name'];
                    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
                    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
                    $rename_thumb = unique_id() . '.' . $thumb_ext;
                    $thumb_size = $_FILES['thumb']['size'];
                    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
                    $thumb_folder = '../uploaded_files/' . $rename_thumb;
                    if ($thumb_size > 2000000) {
                        $message[] = 'image size is too large!';
                    } else {
                        $add_playlist = $conn->prepare("INSERT INTO `online_content`(id, tutor_id, title, description, link, thumb,data,time) VALUES(?,?,?,?,?,?,?,?)");
                        $add_playlist->execute([$id, $tutor_id, $title, $description, $link, $rename_thumb,$date,$time]);
                        move_uploaded_file($thumb_tmp_name, $thumb_folder);
                        $message[] = 'new course uploaded!';
                    }
                }
                ?>
                <section class="breadcrumb__area breadcrumb__bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb__content">
                            <h3 class="title">Add Online Content</h3>
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
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="videoTitle">Online Content Title</label>
                                    <input placeholder="Online Content Title" type="text" name="title" maxlength="100"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="videoTitle">Online Content Time</label>
                                    <input placeholder="Online Content time" type="text" name="time" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="videoTitle">Online Content date</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="videoDescription">Online Content Description</label>
                                    <textarea placeholder="Online Content Description" name="description" class="form-control"
                                    rows="5" maxlength="1000" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Online Content Link</label>
                                    <input placeholder="Online Content Link" type="text" name="link"class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group fallback w-100">
                                    <label class="form-label d-block" for="videoThumbnail">Select Thumbnail</label>
                                    <input type="file" name="thumb" accept="image/*" required class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-5">
								<button type="submit" name="submit" class="btn btn-primary">Upload Video</button>
							</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
</body>
</html>