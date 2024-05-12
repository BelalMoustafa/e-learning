<?php
include 'components/connect.php';
if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}
?>
<?php
if ($user_id=='') {
?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="assets/img/logo/logo.png" style="width: 113px;"
                    alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="nav-link">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
}else{
?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="assets/img/logo/logo.png" style="width: 113px;"
                    alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="courses.php">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="online_courses.php">Online Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="update.php">Update Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="components/user_logout.php" onclick="return confirm('logout from this website?');"
                            class="nav-link">Logout</a>
                    </li>
                </ul>
                <div class="tgmenu__search d-none d-md-block">
                    <form action="search_course.php" class="tgmenu__search-form" method="POST">
                        <div class="input-grp">
                            <input type="text" name="search_course" placeholder="search courses..." required
                                maxlength="100">
                            <button type="submit" class="fas fa-search" name="search_course_btn"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
<?php
}
?>
