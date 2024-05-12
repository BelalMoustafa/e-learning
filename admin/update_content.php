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

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
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
if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:index.php');
}

if(isset($_POST['update'])){

   $video_id = $_POST['video_id'];
   $video_id = filter_var($video_id, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $playlist = $_POST['playlist'];
   $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);

   $update_content = $conn->prepare("UPDATE `content` SET title = ?, description = ?, status = ? WHERE id = ?");
   $update_content->execute([$title, $description, $status, $video_id]);

   if(!empty($playlist)){
      $update_playlist = $conn->prepare("UPDATE `content` SET playlist_id = ? WHERE id = ?");
      $update_playlist->execute([$playlist, $video_id]);
   }

   $old_thumb = $_POST['old_thumb'];
   $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
   $thumb = $_FILES['thumb']['name'];
   $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
   $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
   $rename_thumb = unique_id().'.'.$thumb_ext;
   $thumb_size = $_FILES['thumb']['size'];
   $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
   $thumb_folder = '../uploaded_files/'.$rename_thumb;

   if(!empty($thumb)){
      if($thumb_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_thumb = $conn->prepare("UPDATE `content` SET thumb = ? WHERE id = ?");
         $update_thumb->execute([$rename_thumb, $video_id]);
         move_uploaded_file($thumb_tmp_name, $thumb_folder);
         if($old_thumb != '' AND $old_thumb != $rename_thumb){
            unlink('../uploaded_files/'.$old_thumb);
         }
      }
   }

   $old_video = $_POST['old_video'];
   $old_video = filter_var($old_video, FILTER_SANITIZE_STRING);
   $video = $_FILES['video']['name'];
   $video = filter_var($video, FILTER_SANITIZE_STRING);
   $video_ext = pathinfo($video, PATHINFO_EXTENSION);
   $rename_video = unique_id().'.'.$video_ext;
   $video_tmp_name = $_FILES['video']['tmp_name'];
   $video_folder = '../uploaded_files/'.$rename_video;

   if(!empty($video)){
      $update_video = $conn->prepare("UPDATE `content` SET video = ? WHERE id = ?");
      $update_video->execute([$rename_video, $video_id]);
      move_uploaded_file($video_tmp_name, $video_folder);
      if($old_video != '' AND $old_video != $rename_video){
         unlink('../uploaded_files/'.$old_video);
      }
   }

   $message[] = 'content updated!';

}

if(isset($_POST['delete_video'])){

   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $delete_video_thumb = $conn->prepare("SELECT thumb FROM `content` WHERE id = ? LIMIT 1");
   $delete_video_thumb->execute([$delete_id]);
   $fetch_thumb = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);

   $delete_video = $conn->prepare("SELECT video FROM `content` WHERE id = ? LIMIT 1");
   $delete_video->execute([$delete_id]);
   $fetch_video = $delete_video->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_files/'.$fetch_video['video']);


   $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
   $delete_content->execute([$delete_id]);
   header('location:contents.php');
    
}

?>
<section class="breadcrumb__area breadcrumb__bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb__content">
                    <h3 class="title">Update Content</h3>
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
    <?php
    if ($admin) {
        $select_videos = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
        $select_videos->execute([$get_id]);
    }else {
        $select_videos = $conn->prepare("SELECT * FROM `content` WHERE id = ? AND tutor_id = ?");
        $select_videos->execute([$get_id, $tutor_id]);
    }
    if($select_videos->rowCount() > 0){
        while($fecth_videos = $select_videos->fetch(PDO::FETCH_ASSOC)){ 
            $video_id = $fecth_videos['id'];
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="video_id" value="<?= $fecth_videos['id']; ?>">
        <input type="hidden" name="old_thumb" value="<?= $fecth_videos['thumb']; ?>">
        <input type="hidden" name="old_video" value="<?= $fecth_videos['video']; ?>">
        <div class="form-group">
            <label class="form-label" for="Video_Status">Update Status</label>
            <select name="status" class="form-control box" required>
                <option value="<?= $fecth_videos['status']; ?>" selected><?= $fecth_videos['status']; ?></option>
                <option value="active">Active</option>
                <option value="deactive">Deactive</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label" for="Video_Title">Update Title</label>
            <input type="text" name="title" maxlength="100" required placeholder="Enter video title" class="form-control box" value="<?= $fecth_videos['title']; ?>">
        </div>
        <div class="form-group">
            <label class="form-label" for="Video_Description">Update Description</label>
            <textarea name="description" class="form-control box" required placeholder="Write description" maxlength="1000" cols="30" rows="10"><?= $fecth_videos['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label class="form-label" for="Video_Playlist">Update Playlist</label>
            <select name="playlist" class="form-control box">
                <option value="<?= $fecth_videos['playlist_id']; ?>" selected>--Select playlist</option>
                <?php
                        if ($admin) {
                            $select_playlists = $conn->prepare("SELECT * FROM `playlist`");
                            $select_playlists->execute([]);
                        } else {
                            $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
                            $select_playlists->execute([$tutor_id]);
                        }
                
                if($select_playlists->rowCount() > 0){
                    while($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
                <?php
                    }
                ?>
                <?php
                }else{
                    echo '<option value="" disabled>No playlist created yet!</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Update Thumbnail</label>
            <input type="file" name="thumb" accept="image/*" class="form-control box">
        </div>
        <div class="form-group">
            <label class="form-label">Update Video</label>
            <input type="file" name="video" accept="video/*" class="form-control box">
        </div>
        <div class="form-group mt-5" >
            <button type="submit" class="btn btn-primary" name="update">Update Content</button>
        </div>
    </form>
    <?php
        }
    }else{
        echo '<p class="empty">Video not found! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">Add videos</a></p>';
    }
    ?>
</div>






			</div>
		</div>
	</div>
</div>

<br><br><br><br><br><br><br>

        <!--**********************************
            Content body end
        ***********************************-->
        <!--**********************************
    Footer start
***********************************-->

<!--**********************************
    Footer end
***********************************-->

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
