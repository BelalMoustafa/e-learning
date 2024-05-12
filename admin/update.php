<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edutube</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <!-- Pickadate CSS -->
    <link rel="stylesheet" href="vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="vendor/pickadate/themes/default.date.css">
    <!-- Main CSS -->
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
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                include '../components/connect.php';

                if(isset($_COOKIE['tutor_id'])){
                    $tutor_id = $_COOKIE['tutor_id'];
                } else {
                    $tutor_id = '';
                    header('location:../login.php');
                }

                $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
                $select_tutor->execute([$tutor_id]);
                $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                $message = []; 
                $prev_pass = $fetch_tutor['password'];
                $prev_image = $fetch_tutor['image'];
                if(isset($_POST['submit'])){

                    

                    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                    $profession = filter_input(INPUT_POST, 'profession', FILTER_SANITIZE_STRING);
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

                    

                    if(!empty($name)){
                        $update_name = $conn->prepare("UPDATE `tutors` SET name = ? WHERE id = ?");
                        $update_name->execute([$name, $tutor_id]);
                        $message[] = 'Username updated successfully!';
                    }

                    if(!empty($profession)){
                        $update_profession = $conn->prepare("UPDATE `tutors` SET profession = ? WHERE id = ?");
                        $update_profession->execute([$profession, $tutor_id]);
                        $message[] = 'Profession updated successfully!';
                    }

                    if(!empty($email)){
                        $select_email = $conn->prepare("SELECT email FROM `tutors` WHERE id = ? AND email = ?");
                        $select_email->execute([$tutor_id, $email]);
                        if($select_email->rowCount() > 0){
                            $message[] = 'Email already taken!';
                        } else {
                            $update_email = $conn->prepare("UPDATE `tutors` SET email = ? WHERE id = ?");
                            $update_email->execute([$email, $tutor_id]);
                            $message[] = 'Email updated successfully!';
                        }
                    }

                    // Handle image upload
                    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                        $image = $_FILES['image'];
                        $image_name = $image['name'];
                        $image_tmp_name = $image['tmp_name'];
                        $image_size = $image['size'];

                        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                        $rename = unique_id() . '.' . $ext;
                        $image_folder = '../uploaded_files/' . $rename;

                        if($image_size > 2000000){
                            $message[] = 'Image size too large!';
                        } else {
                            $update_image = $conn->prepare("UPDATE `tutors` SET `image` = ? WHERE id = ?");
                            $update_image->execute([$rename, $tutor_id]);
                            move_uploaded_file($image_tmp_name, $image_folder);
                            if($prev_image != '' && $prev_image != $rename){
                                unlink('../uploaded_files/' . $prev_image);
                            }
                            $message[] = 'Image updated successfully!';
                        }
                    }

                    // Handle password update
                    $old_pass = sha1(filter_input(INPUT_POST, 'old_pass', FILTER_SANITIZE_STRING));
                    $new_pass = sha1(filter_input(INPUT_POST, 'new_pass', FILTER_SANITIZE_STRING));
                    $cpass = sha1(filter_input(INPUT_POST, 'cpass', FILTER_SANITIZE_STRING));

                    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

                    if($old_pass != $empty_pass){
                        if($old_pass != $prev_pass){
                            $message[] = 'Old password not matched!';
                        } elseif($new_pass != $cpass){
                            $message[] = 'Confirm password not matched!';
                        } else {
                            if($new_pass != $empty_pass){
                                $update_pass = $conn->prepare("UPDATE `tutors` SET password = ? WHERE id = ?");
                                $update_pass->execute([$cpass, $tutor_id]);
                                $message[] = 'Password updated successfully!';
                            } else {
                                $message[] = 'Please enter a new password!';
                            }
                        }
                    }
                }
                ?>
                <div class="card-body">
                    <form class="register" action="" method="post" enctype="multipart/form-data">
                        <h3>Update Profile</h3>
                        <?php foreach ($message as $msg): ?>
                            <div class="alert alert-info" role="alert"><?= $msg ?></div>
                        <?php endforeach; ?>
                        <div class="form-group">
                            <label class="form-label" for="Name">Your Name</label>
                            <input type="text" id="Name" class="form-control box" name="name" placeholder="<?= $fetch_tutor['name']; ?>" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="Profession">Your Profession</label>
                            <select id="Profession" class="form-control box" name="profession">
                                <option value="<?= $fetch_tutor['profession']; ?>" selected><?= $fetch_tutor['profession']; ?></option>
                                <option value="developer">Developer</option>
                                <option value="designer">Designer</option>
                                <option value="musician">Musician</option>
                                <option value="biologist">Biologist</option>
                                <option value="teacher">Teacher</option>
                                <option value="engineer">Engineer</option>
                                <option value="lawyer">Lawyer</option>
                                <option value="accountant">Accountant</option>
                                <option value="doctor">Doctor</option>
                                <option value="journalist">Journalist</option>
                                <option value="photographer">Photographer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="Email">Your Email</label>
                            <input type="email" id="Email" class="form-control box" name="email" placeholder="<?= $fetch_tutor['email']; ?>" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="Old_Password">Old Password</label>
                            <input type="password" id="Old_Password" class="form-control box" name="old_pass" placeholder="Enter Your Old Password" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="New_Password">New Password</label>
                            <input type="password" id="New_Password" class="form-control box" name="new_pass" placeholder="Enter Your New Password" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="Confirm_Password">Confirm Password</label>
                            <input type="password" id="Confirm_Password" class="form-control box" name="cpass" placeholder="Confirm Your New Password" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="Profile_Pic">Update Pic</label>
                            <input type="file" id="Profile_Pic" class="form-control box" name="image" accept="image/*">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary" name="submit">Update Now</button>
                        </div>
                    </form>
                </div>
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
