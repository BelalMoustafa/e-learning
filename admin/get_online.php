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
<?php include '../components/nav_admin.php'; ?>

<main class="main-area fix">
<section class="breadcrumb_area breadcrumb_bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb__content">
                            <h3 class="title">Online Courses</h3>
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
    <section class="blog-area section-py-120">
        <div class="container">
            <div class="row">
                <?php
                include '../components/connect.php';
                $sql = "SELECT * FROM online_content";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() > 0) {
                    foreach ($result as $row) {
                        $fetch_stmt = $conn->prepare("SELECT * FROM tutors WHERE id = ?");
                        $fetch_stmt->execute([$row['tutor_id']]);
                        $fetch_tutor = $fetch_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="card mb-4">
                                <img src="../uploaded_files/<?= $row['thumb'] ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['title'] ?></h5>
                                    <p class="card-text"><?= $row['description'] ?></p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="flaticon-calendar"></i> <?= $row['data'] ?></li>
                                        <li class="list-group-item"><i class="flaticon-user-1"></i> by <a href=""><?= $fetch_tutor['name'] ?></a></li>
                                        <li class="list-group-item"><i class="fa-solid fa-timer"></i> <?= $row['time'] ?></li>
                                    </ul>
                                    <form action="get_online.php" method="post" class="mt-3">
                                        <a href="update_online.php?edit_id=<?= $row['id'] ?>" class="btn btn-primary btn-sm me-2">Update</a>
                                        <input type="hidden" value="<?= $row['id'] ?>" name="id">
                                        <input type="submit" class='btn btn-danger btn-sm' value="Delete">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='col'><h4 class='text-center'>No products found</h4></div>";
                }
                ?>
            </div>
            <div class="row">
                <div class="col text-center">
                    <a class="btn btn-primary" href="add_online.php">Add New Product</a>
                </div>
            </div>
        </div>
    </section>
</main>


    <!-- JS here -->
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