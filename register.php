<!doctype html>
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

    <!--Preloader-->

    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="tg-flaticon-arrowhead-up"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->

    <!-- header-area-end -->



    <!-- main-area -->
    <main class="main-area fix">

        <!-- singUp-area -->
        <?php
        include 'components/connect.php';
        
        if(isset($_COOKIE['user_id'])){
           $user_id = $_COOKIE['user_id'];
        }else{
           $user_id = '';
        }
        
        if(isset($_POST['submit'])){
        
           $id = unique_id();
           $first_name = $_POST['first_name'];
           $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
           $last_name = $_POST['last_name'];
           $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
           $email = $_POST['email'];
           $email = filter_var($email, FILTER_SANITIZE_STRING);
           $password = sha1($_POST['password']);
           $password = filter_var($password, FILTER_SANITIZE_STRING);
           $confirm_password = sha1($_POST['confirm_password']);
           $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);
        
           $image = $_FILES['image']['name'];
           $image = filter_var($image, FILTER_SANITIZE_STRING);
           $ext = pathinfo($image, PATHINFO_EXTENSION);
           $rename = unique_id().'.'.$ext;
           $image_size = $_FILES['image']['size'];
           $image_tmp_name = $_FILES['image']['tmp_name'];
           $image_folder = 'uploaded_files/'.$rename;
        
           $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
           $select_user->execute([$email]);
           
           if($select_user->rowCount() > 0){
              $message[] = 'Email already taken!';
           }else{
              if($password != $confirm_password){
                 $message[] = 'Confirm password not matched!';
              }else{
                 $insert_user = $conn->prepare("INSERT INTO `users`(id, first_name, last_name, email, password, image) VALUES(?,?,?,?,?,?)");
                 $insert_user->execute([$id, $first_name, $last_name, $email, $confirm_password, $rename]);
                 move_uploaded_file($image_tmp_name, $image_folder);
                 
                 $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
                 $verify_user->execute([$email, $password]);
                 $row = $verify_user->fetch(PDO::FETCH_ASSOC);
                 
                 if($verify_user->rowCount() > 0){
                    setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
                    header('location:index.php');
                 }
              }
           }
        
        }
        ?>
        
        <section class="singUp-area section-py-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="singUp-wrap">
                            <h2 class="title">Create Your Account</h2>
        
                            <form class="account__form" action="" method="post" enctype="multipart/form-data">
                                <div class="row gutter-20">
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="first-name">First Name</label>
                                            <input type="text" id="first-name" name="first_name" placeholder="First Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="last-name">Last Name</label>
                                            <input type="text" id="last-name" name="last_name" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-grp">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-grp">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-grp">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
                                </div>
                                <div class="form-grp">
                                    <label for="image">Select Picture</label>
                                    <input type="file" id="image" name="image" accept="image/*" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-two arrow-btn">Sign Up<img src="assets/img/icons/right_arrow.svg" alt="img" class="injectable"></button>
                            </form>
                            <div class="account__switch">
                                <p>Already have an account?<a href="login.php">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- singUp-area-end -->

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


<!-- Mirrored from themegenix.com/demo/skillgro/registration.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Jan 2024 10:43:46 GMT -->
</html>