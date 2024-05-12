<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edutube</title>
    <meta name="description" content="Edutube">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
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
    <?php include 'components/nav.php'; ?>

    <!-- main-area -->
    <main class="main-area fix">

        <!-- banner-area -->
        <section class="banner-area-two banner-bg-two tg-motion-effects" data-background="assets/img/banner/banner_bg02.png">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="banner__content-two">
                            <h3 class="title" data-aos="fade-right" data-aos-delay="400">
                                Learning is
                                <span class="position-relative">
                                    <svg x="0px" y="0px" preserveAspectRatio="none" viewBox="0 0 209 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.74438 7.70565C69.7006 -1.18799 136.097 -2.38304 203.934 4.1205C207.178 4.48495 209.422 7.14626 208.933 10.0534C206.793 23.6481 205.415 36.5704 204.801 48.8204C204.756 51.3291 202.246 53.5582 199.213 53.7955C136.093 59.7623 74.1922 60.5985 13.5091 56.3043C10.5653 56.0924 7.84371 53.7277 7.42158 51.0325C5.20725 38.2627 2.76333 25.6511 0.0898448 13.1978C-0.465589 10.5873 1.61173 8.1379 4.73327 7.70565" fill="currentcolor" />
                                    </svg>
                                    What You
                                </span>
                                Make of it. Make it Yours at Edutube.
                            </h3>
                            <div class="banner__btn-two" data-aos="fade-right" data-aos-delay="600">
                                <?php
                                if ($user_id=='') {
                                ?>
                                <a href="register.php" class="btn arrow-btn">Start With Us<img src="assets/img/icons/right_arrow.svg" alt="img" class="injectable"></a>
                                <?php
                                }else{
                                ?>
                                <a href="courses.php" class="btn arrow-btn">Start Learn<img src="assets/img/icons/right_arrow.svg" alt="img" class="injectable"></a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-8">
                        <div class="banner__images-two tg-svg">
                            <img src="assets/img/banner/h2_banner_img.png" alt="img" class="main-img">
                            <div class="shape big-shape" data-aos="fade-up" data-aos-delay="600">
                                <img src="assets/img/banner/h2_banner_shape01.svg" alt="shape" class="injectable tg-motion-effects1">
                            </div>
                            <span class="svg-icon" id="banner-svg" data-svg-icon="assets/img/banner/h2_banner_shape02.svg"></span>
                            <div class="about__enrolled" data-aos="fade-right" data-aos-delay="200">
                                <p class="title"><span>36K+</span> Enrolled Students</p>
                                <img src="assets/img/others/student_grp.png" alt="img">
                            </div>
                            <div class="banner__student" data-aos="fade-left" data-aos-delay="200">
                                <div class="icon">
                                    <img src="assets/img/banner/h2_banner_icon.svg" alt="img" class="injectable">
                                </div>
                                <div class="content">
                                    <span>Total Students</span>
                                    <h4 class="title">15K</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="assets/img/banner/h2_banner_shape03.svg" alt="shape" class="line-shape-two" data-aos="fade-right"
            data-aos-delay="1600">
        </section>
        <?php
        $stmt = $conn->query("SELECT ads FROM ads ORDER BY id DESC LIMIT 1");
        $fetch_code = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() >0) {
            $ads = $fetch_code['ads'];
        } else {
            $ads = "Edutube";
        }
        ?>
        <div class="brand-area brand-area-two">
            <div class="container-fluid">
                <div class="marquee_mode">
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?=$ads?></h3></a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                    <div class="brand__item">
                        <a href="#"><h3 style="color: white;"><?= $ads ?>
                            </h3>
                        </a>
                        <img src="assets/img/icons/brand_star.svg" alt="star">
                    </div>
                </div>
            </div>
        </div>
        <!-- brand-area-end -->


        <section class="features__area-two section-pt-120 section-pb-90">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section__title text-center mb-40">
                            <span class="sub-title">Our Top Features</span>
                            <h2 class="title">Achieve Your Goal With Edutube</h2>
                            <p>when an unknown printer took a galley of type and scrambled make <br> specimen book has survived not only five centuries</p>
                        </div>
                    </div>
                </div>
                <div class="features__item-wrap">
                    <?php
                                if ($user_id=='') {
                                ?>
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6"><a href="login.php">
                            <div class="features__item-two">
                                <div class="features__content-two">
                                    <div class="content-top">
                                        <div class="features__icon-two">
                                            <img src="assets/img/icons/phone-settings-phone-smartphone-mobile-system-svgrepo-com.svg" alt="img" class="injectable">
                                        </div>
                                        <h2 class="title">Mobile System Course</h2>
                                    </div>
                                    <p>Learning to communicate via mobile phone opens up endless possibilities for connection and collaboration in today's interconnected world.</p>
                                </div>
                                <div class="features__item-shape">
                                    <img src="assets/img/others/features_item_shape.svg" alt="img" class="injectable">
                                </div>
                            </div>
                        </a></div>
                        <div class="col-lg-4 col-md-6"><a href="login.php">
                            <div class="features__item-two">
                                <div class="features__content-two">
                                    <div class="content-top">
                                        <div class="features__icon-two">
                                            <img src="assets/img/icons/security-svgrepo-com.svg" alt="img" class="injectable">
                                        </div>
                                        <h2 class="title">Cyber Security Course</h2>
                                    </div>
                                    <p>Learn how to protect your system from cyber operations and learn how to defend your accounts and personal financial data.</p>
                                </div>
                                <div class="features__item-shape">
                                    <img src="assets/img/others/features_item_shape.svg" alt="img" class="injectable">
                                </div>
                            </div>
                        </a></div>
                        <div class="col-lg-4 col-md-6"><a href="login.php">
                            <div class="features__item-two">
                                <div class="features__content-two">
                                    <div class="content-top">
                                        <div class="features__icon-two">
                                            <img src="assets/img/icons/satellite-dish-svgrepo-com.svg" alt="img" class="injectable">
                                        </div>
                                        <h2 class="title">Satellite Course</h2>
                                    </div>
                                    <p>Embarking on the journey to learn about satellite technology opens up a universe of knowledge and opportunities.</p>
                                </div>
                                <div class="features__item-shape">
                                    <img src="assets/img/others/features_item_shape.svg" alt="img" class="injectable">
                                </div>
                            </div>
                       </a> </div>
                    </div>
                    <?php
                                }else{
                                ?>
                                                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6"><a href="courses.php">
                            <div class="features__item-two">
                                <div class="features__content-two">
                                    <div class="content-top">
                                        <div class="features__icon-two">
                                            <img src="assets/img/icons/phone-settings-phone-smartphone-mobile-system-svgrepo-com.svg" alt="img" class="injectable">
                                        </div>
                                        <h2 class="title">Mobile System Course</h2>
                                    </div>
                                    <p>Learning to communicate via mobile phone opens up endless possibilities for connection and collaboration in today's interconnected world.</p>
                                </div>
                                <div class="features__item-shape">
                                    <img src="assets/img/others/features_item_shape.svg" alt="img" class="injectable">
                                </div>
                            </div>
                        </a></div>
                        <div class="col-lg-4 col-md-6"><a href="courses.php">
                            <div class="features__item-two">
                                <div class="features__content-two">
                                    <div class="content-top">
                                        <div class="features__icon-two">
                                            <img src="assets/img/icons/security-svgrepo-com.svg" alt="img" class="injectable">
                                        </div>
                                        <h2 class="title">Cyber Security Course</h2>
                                    </div>
                                    <p>Learn how to protect your system from cyber operations and learn how to defend your accounts and personal financial data.</p>
                                </div>
                                <div class="features__item-shape">
                                    <img src="assets/img/others/features_item_shape.svg" alt="img" class="injectable">
                                </div>
                            </div>
                        </a></div>
                        <div class="col-lg-4 col-md-6"><a href="courses.php">
                            <div class="features__item-two">
                                <div class="features__content-two">
                                    <div class="content-top">
                                        <div class="features__icon-two">
                                            <img src="assets/img/icons/satellite-dish-svgrepo-com.svg" alt="img" class="injectable">
                                        </div>
                                        <h2 class="title">Satellite Course</h2>
                                    </div>
                                    <p>Embarking on the journey to learn about satellite technology opens up a universe of knowledge and opportunities.</p>
                                </div>
                                <div class="features__item-shape">
                                    <img src="assets/img/others/features_item_shape.svg" alt="img" class="injectable">
                                </div>
                            </div>
                       </a> </div>
                    </div>
                    <?php
                                }
                    ?>
                </div>
            </div>
        </section>
        <section class="contact-area section-py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="contact-info-wrap">
                            <ul class="list-wrap">
                                <li>
                                    <div class="icon">
                                        <img src="assets/img/icons/map.svg" alt="img" class="injectable">
                                    </div>
                                    <div class="content">
                                        <h4 class="title">Address</h4>
                                        <p>Egypt,Cairo</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <img src="assets/img/icons/contact_phone.svg" alt="img" class="injectable">
                                    </div>
                                    <div class="content">
                                        <h4 class="title">Phone</h4>
                                        <a href="tel:01550056744">+20 155 005 6744</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <img src="assets/img/icons/emial.svg" alt="img" class="injectable">
                                    </div>
                                    <div class="content">
                                        <h4 class="title">E-mail Address</h4>
                                        <a href="mailto:edutubex.1@gmail.com">edutubex.1@gmail.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">
    <div class="contact-form-wrap">
        <h4 class="title">Send Us Message</h4>
        <p>Your email address will not be published. Required fields are marked *</p>
        <form id="contact-form" action="" method="POST">
            <div class="form-grp">
                <textarea name="message" placeholder="Comment" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-grp">
                        <input name="name" type="text" placeholder="Name *" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-grp">
                        <input name="email" type="email" placeholder="E-mail *" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-two arrow-btn" id="submit-form">Submit Now <img src="assets/img/icons/right_arrow.svg" alt="img" class="injectable"></button>
        </form>
        <p class="ajax-response mb-0"></p>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const submitButton = document.getElementById("submit-form");
        if (submitButton) {
            submitButton.addEventListener("click", function () {
                const fullName = document.querySelector('input[name="name"]').value;
                const emailAddress = document.querySelector('input[name="email"]').value;
                const message = document.querySelector('textarea[name="message"]').value;

               
                const ccEmails = ['coo@edutubeacademy.com'];
                const ccAddresses = ccEmails.map(email => `cc=${email}`).join('&');
                const mailtoLink = `mailto:technicalsupport@edutubeacademy.com?${ccAddresses}&subject=Message from ${fullName}&body=Email: ${emailAddress}%0A${message}`;
                window.location.href = mailtoLink;
            });
        }
    });
</script>


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


</html>