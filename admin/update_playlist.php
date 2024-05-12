<!DOCTYPE html>
<html>

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="dexignlabs">
<meta name="robots" content="index, follow">

<meta name="keywords" content="admin, dashboard, admin dashboard, admin template, ASP.NET Core MVC, template, admin panel, administration, analytics, bootstrap, modern, responsive, creative, retina ready, modern Dashboard responsive dashboard, responsive template, user experience, user interface, Bootstrap Dashboard, Analytics Dashboard, Customizable Admin Panel, EduMin template, ui kit, web app, EduMin, School Management,Dashboard Template, academy, course, courses, e-learning, education, learning, learning management system, lms, school, student, teacher">

<meta name="description" content="EduMin - Empower your educational institution with the all-in-one Education Admin ASP.NET Core MVC Dashboard Template. Streamline administrative tasks, manage courses, track student performance, and gain valuable insights with ease. Elevate your education management experience with a modern, responsive, and feature-packed solution. Explore EduMin now for a smarter, more efficient approach to education administration.">

<meta property="og:title" content="EduMin - Education Admin ASP.NET Core MVC Dashboard Template | dexignlabs">
<meta property="og:description" content="EduMin - Empower your educational institution with the all-in-one Education Admin ASP.NET Core MVC Dashboard Template. Streamline administrative tasks, manage courses, track student performance, and gain valuable insights with ease. Elevate your education management experience with a modern, responsive, and feature-packed solution. Explore EduMin now for a smarter, more efficient approach to education administration.">

<meta property="og:image" content="../../products.w3itexpert.com/images/edumin_ogimage.png">

<meta name="format-detection" content="telephone=no">

<meta name="twitter:title" content="EduMin - Education Admin ASP.NET Core MVC Dashboard Template | dexignlabs">
<meta name="twitter:description" content="EduMin - Empower your educational institution with the all-in-one Education Admin ASP.NET Core MVC Dashboard Template. Streamline administrative tasks, manage courses, track student performance, and gain valuable insights with ease. Elevate your education management experience with a modern, responsive, and feature-packed solution. Explore EduMin now for a smarter, more efficient approach to education administration.">

<meta name="twitter:image" content="../../products.w3itexpert.com/images/edumin_ogimage.png">
<meta name="twitter:card" content="summary_large_image">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edutube</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <!--**********************************
        Style script start
    ***********************************-->
    
	<link rel="stylesheet" href="vendor/pickadate/themes/default.css">
	<link rel="stylesheet" href="vendor/pickadate/themes/default.date.css">

    <!--**********************************
        Style script end
    ***********************************-->
    <!-- Style css -->
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

	<!-- row -->
	<div class="container">


		<div class="row">
			<div class="col-lg-12">
         <?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:../login.php');
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:playlist.php');
}

// Fetch playlist data from the database
$select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ?");
$select_playlist->execute([$get_id]);
$fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    $update_playlist = $conn->prepare("UPDATE `playlist` SET title = ?, description = ?,price=? ,status = ? WHERE id = ?");
    $update_playlist->execute([$title, $description,$price,$status, $get_id]);

    $old_image = isset($_POST['old_image']) ? $_POST['old_image'] : '';
    $old_image = filter_var($old_image, FILTER_SANITIZE_STRING);
    $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_size = isset($_FILES['image']['size']) ? $_FILES['image']['size'] : 0;
    $image_tmp_name = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
    $image_folder = '../uploaded_files/'.$rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `playlist` SET thumb = ? WHERE id = ?");
            $update_image->execute([$rename, $get_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($old_image != '' AND $old_image != $rename) {
                unlink('../uploaded_files/'.$old_image);
            }
        }
    }

    $message[] = 'playlist updated!';
}

if (isset($_POST['delete'])) {
    $delete_id = $get_id; // Use $get_id instead of $_POST['playlist_id']
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $delete_playlist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
    $delete_playlist_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);

    // Check if file exists before attempting to unlink
    if (file_exists('../uploaded_files/' . $fetch_thumb['thumb'])) {
        unlink('../uploaded_files/' . $fetch_thumb['thumb']);
    }


    
    $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
    $delete_playlist->execute([$delete_id]);

    header('location:playlists.php');
}

// Start buffering
ob_start();

?>
<section class="breadcrumb__area breadcrumb__bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb__content">
                    <h3 class="title">Update Playlist</h3>
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
</section>
<div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="old_image" value="<?= isset($fetch_playlist['thumb']) ? $fetch_playlist['thumb'] : ''; ?>">
        <!-- Playlist Status -->
        <div class="form-group">
            <label class="form-label" for="Course_Status">Playlist Status</label>
            <select name="status" class="form-control box" required>
                <option value="active" <?= isset($fetch_playlist['status']) && $fetch_playlist['status'] == 'active' ? 'selected' : ''; ?>>active</option>
                <option value="deactive" <?= isset($fetch_playlist['status']) && $fetch_playlist['status'] == 'deactive' ? 'selected' : ''; ?>>deactive</option>
            </select>
        </div>
        <!-- Playlist Title -->
        <div class="form-group">
            <label class="form-label" for="Course_Name">Playlist Title</label>
            <input placeholder="Playlist Title" id="Course_Name" type="text" class="form-control box" name="title" maxlength="100" required value="<?= isset($fetch_playlist['title']) ? $fetch_playlist['title'] : ''; ?>">
        </div>
        <div class="form-group">
            <label class="form-label" for="Course_Name">Playlist price</label>
            <input placeholder="Playlist price" id="Course_Name" type="text" class="form-control box" name="price" maxlength="100" required value="<?= isset($fetch_playlist['price']) ? $fetch_playlist['price'] : ''; ?>">
        </div>
        <!-- Playlist Description -->
        <div class="form-group">
            <label class="form-label" for="Course_Details">Playlist Description</label>
            <textarea placeholder="Playlist Description" id="Course_Details" class="form-control box" name="description" rows="5" required><?= isset($fetch_playlist['description']) ? $fetch_playlist['description'] : ''; ?></textarea>
        </div>
        <!-- Playlist Thumbnail -->
        <div class="form-group fallback w-100">
            <label class="form-label d-block" for="Course_Photo">Playlist Thumbnail</label>
            <input id="Course_Photo" type="file" class="form-control box" name="image" accept="image/*">
        </div>
        <!-- Submit Buttons -->
        <div class="col-lg-12 col-md-12 col-sm-12 mt-5">
            <button type="submit" class="btn btn-primary" name="submit">Update Playlist</button>
        </div>
    </form>
</div>

<?php

// Get the buffered content and clean the buffer
$output = ob_get_clean();
echo $output; // Send the output to the browser

?>

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

<!-- Mirrored from edumin.w3itexpert.com/Edumin/AddCourses by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Jan 2024 19:06:37 GMT -->
</html>
