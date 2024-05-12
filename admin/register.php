<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {
   $id = unique_id();
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $profession = filter_var($_POST['profession'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $pass = sha1(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
   $cpass = sha1(filter_var($_POST['cpass'], FILTER_SANITIZE_STRING));

   $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/' . $rename;

   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
   $select_tutor->execute([$email]);
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   if ($select_tutor->rowCount() > 0 || $select_user->rowCount() > 0) {
      $message[] = 'Email already taken!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirm password not matched!';
      } else {
         $insert_tutor = $conn->prepare("INSERT INTO `tutors` (id, name, profession, email, password, image) VALUES (?, ?, ?, ?, ?, ?)");
         $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);
         $message[] = 'New tutor registered! Please login now.';
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
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

<body style="padding-left: 0;">
   <section class="form-container">
      <!-- Form content -->
<section class="singUp-area section-py-120 form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
               <?php
               if (isset($message)) {
                  foreach ($message as $msg) {
                     echo '
        <div class="message form">
            <span>' . $msg . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
                  }
               }
               ?>
                <div class="singUp-wrap">
                    <h2 class="title">Register New User</h2>
                    <form action="" method="post" class="account__form register" enctype="multipart/form-data">
                        <div class="form-grp">
                            <label for="name">Your Name</label>
                            <input id="name" type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">
                            <input name="profession" class="box" required value="teacher" type="hidden">
                        </div>
                        <div class="form-grp">
                            <label for="email">Your Email</label>
                            <input id="email" type="email" name="email" placeholder="Enter your email" required class="box">
                        </div>
                        <div class="form-grp">
                            <label for="password">Your Password</label>
                            <input id="password" type="password" name="pass" placeholder="Enter your password"  minlength="8" required class="box">
                        </div>
                        <div class="form-grp">
                            <label for="confirmPassword">Confirm Password</label>
                            <input id="confirmPassword" type="password" name="cpass" placeholder="Confirm your password" minlength="8" required class="box">
                        </div>
                        <div class="form-grp">
                            <label for="profilePicture">Select Profile Picture</label>
                            <input id="profilePicture" type="file" name="image" accept="image/*" required class="box">
                        </div>
                        <button type="submit" name="submit" class="btn btn-two arrow-btn">Register Now</button>
                    </form>
                    <div class="account__switch">
                        <p>Already have an account? <a href="../login.php">Login now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


   </section>


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