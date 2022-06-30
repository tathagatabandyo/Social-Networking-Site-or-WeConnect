<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["user_email"])) {
    header("Location:index");
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="img/icon/icon.png" type="image/x-icon">

    <?php
    $page_name = "home";
    if (isset($_GET['page_name'])) {
        if ($_GET['page_name'] == "home" || $_GET['page_name'] == "watch") {
            $page_name = $_GET['page_name'];
        } else {
    ?>
            <title>Error | No Page Found | Something Went to Wrong</title>
            <script>
                alert("No Page Found | Something Went to Wrong");
            </script>
    <?php
            die("<a href='user' style='text-align: center; display: inline-block; font-size: 40px; text-decoration: none; color: #fff; background-color: #000; width: 250px; font-weight: bold; padding: 19px; border-radius: 10px; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);'>Go To Home Page</a>");
        }
    }
    ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <title>WeConnect</title>

    <link rel="stylesheet" href="css/animation.css">
    <!-- <link rel="stylesheet" href="css/floating_style.css"> -->
    <link rel="stylesheet" href="css/user_style.css">
    <link rel="stylesheet" href="css/user_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="css/post_modal1.css">

    <link rel="stylesheet" href="css/emoji_style.css">
    <link rel="stylesheet" href="css/rection_emoji_style.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="css/message_modal.css">
    <link rel="stylesheet" href="css/edit_profile_modal.css">
    <link rel="stylesheet" href="css/date_picker.css">

    <style>
        .icon_at_nav {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            /* background-color: #dddee2; */
        }

        .icon_at_nav img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .row_ele_style {
            cursor: pointer;
            color: #000;
            background-color: #d9dde6;
            transition: background-color 0.2s linear 0s;
            font-weight: 600;
            margin: 15px 0px;
            border-radius: 10px;
        }

        .row_ele_style:hover {
            background-color: #1877f21f;
            color: #000;
        }

        #left_slide_l_bar {
            /* display: block; */
            display: none;
            width: 340px;
            background: #f0f2f5;
            position: fixed;
            height: calc(100vh - 54.4px);
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 0px 0px 4px 2px rgb(0, 0, 0, 0.3);
            z-index: 999;
            top: 55.5px;
            left: 0px;
            border-radius: 0px 10px 10px 0px;
        }

        .user_profile_ {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .user_profile_ img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            object-position: top center;
        }

        .user_profile_ .profile___text_ {
            width: 40px;
            height: 40px;
            background: #0d6efd;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: 700;
            color: #fff;
            font-size: 24px;
        }

        #show_post_modal_ {
            border-radius: 16px;
            background-color: #e4e6eb;
            padding: 10px 15px;
            user-select: none;
            cursor: pointer;
            transition: background-color 0.1s linear 0s;
        }

        .show_post_modal_2 {
            width: 100%;
            /* width: 96%; */
            border-radius: 4px;
            /* border-radius: 0px 0px 16px 16px; */
            /* background-color: #ced0d3; */
            /* padding: 8px 15px; */
            outline: none;
            border: none;
            padding: 5px 6px !important;
            background: #fff !important;
            box-shadow: 0px 0px 6px 0px #000;
            transition: border-radius 0.2s linear 0s;
        }
        .comment__column__ele .emojionearea-editor {
            padding: 6px 9px !important;
            width: 92% !important;
            color: #000 !important;
            background: #78787829 !important;
            caret-color: #000 !important;
            border-radius: 15px;
            min-height: 33.42px !important;
            max-height: 54.85px !important;
            /* max-height: none !important; */
        }

        .comment__column__ele .emojionearea-picker {
            box-shadow: rgb(0 0 0) 0px 0px 6px 0px;
            background: rgb(255, 255, 255) !important;
            border-radius: 16px 16px 0px 0px;
        }
        .comment__column__ele .emojionearea-editor:empty:before {
            color: #504b4bd9;
        }
        .comment__column__ele {
            display: inline-block;
            width: calc(100% - 40px - 20px);
        }
        .comment_user_profile__style,.comment__details,.user_profile_comment_style {
            display: inline-block;
        }
        .comment_user_profile__style,.user_profile_comment_style {
            width: 40px;
            height: 40px;
            margin-right: 20px;
            border-radius: 50%;
        }
        .comment__details {
            width: calc(100% - 40px - 20px);
        }
        .comment__details_style {
            display: inline-block;
            background-color: rgba(0,0,0,0.1);
            border-radius: 24px;
            padding: 10px;
            position: relative;
        }
        .comment__description {
            margin: 4px 0px;
            word-break: break-word;
        }
        .comment__description img {
            width: 24px;
            height: 24px;
        }
        .comment__details_style_margin_r {
            margin-right: 40px;
        }
        .comment__details_style a {
            color: #000;
            transition: color 0.2s linear 0s;
            transition: text-decoration 0.2s linear 0s;
        }
        .comment__details_style a:hover {
            color: #0d6efd;
            text-decoration: underline solid #0d6efd;
        }
        .comment__details_style .delete_comment_btn {
            position: absolute;
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            user-select: none;
            cursor: pointer;
            background-color: rgba(0,0,0,0.1);
            border-radius: 50%;
            top: 50%;
            right: -36px;
            transform: translateY(-50%);
            transition: color 0.2s linear 0s;
            transition: background-color 0.2s linear 0s;
        }
        .comment__details_style .delete_comment_btn:hover {
            color: #fff;
            background-color: #000;
        }
        .name_of_user_who_comment {
            font-weight: 600;
            font-size: 14px;
        }
        .user_profile_comment_style img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            object-position: top center;
        }
        .comment_user_profile__style img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            object-position: top center;
        }
        .user_profile_img_text_comment_style_,.comment_user_profile_img_text__style_ {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #0d6efd;
            font-weight: 700;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            user-select: none;
        }
        .comment_user_profile_img_text__style_ {
            width: 32px;
            height: 32px;
            font-size: 20px;
        }
        .no_comment_found_ele {
            background: #fff;
            color: #000;
            box-shadow: 0px 0px 4px 0px #000, 0px 0px 4px 0px #fff, 0px 0px 4px 0px #000;
            padding: 6px 0px;
            border-radius: 8px;
            user-select: none;
            font-weight: 600;
        }
        .comment_date_time_ele {
            font-size: 8.5px;
            font-weight: 700;
            display: inline-block;
            cursor: default;
            user-select: none;
        }
        .comment_show_hide_element {
            display: none;
        }

        #show_post_modal_:hover {
            background-color: #cfd1d6;
        }

        .style_post_any {
            /* margin: 20px 0; */
            padding: 10px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 6px 1px #000;
        }

        .like_div,
        .comment_div {
            cursor: pointer;
            padding: 10px 0px;
            transition: background-color 0.15s linear 0s;
            user-select: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .like_div:hover,
        .comment_div:hover {
            background-color: #c5bebe74;
        }

        .user_name_span {
            font-weight: 600;
            color: #000;
            text-decoration: underline solid transparent;
            transition: color 0.2s linear 0s;
            transition: text-decoration 0.2s linear 0s;
        }

        .user_name_span:hover {
            color: #0d6efd;
            text-decoration: underline solid #0d6efd;
        }

        .user_time_icon a {
            color: #000;
            font-size: 12px;
            text-decoration: underline solid transparent;
            transition: text-decoration 0.2s linear 0s;
        }

        .user_time_icon a:hover {
            text-decoration: underline solid #000;
        }

        .user_time_icon i {
            font-size: 12px;
        }

        .style_border_add {
            border-top: 1px solid #acaeb3;
            /* border-bottom: 1px solid #acaeb3; */
        }

        .like_,
        .comment_ {
            font-size: 18px;
            color: #000;
            display: flex;
            align-items: center;
            font-weight: 700;
        }
        .like_ i,
        .comment_ i {
            font-size: 20px;
            color: #000;
        }

        .like_ img {
            width: 28px;
            height: 28px;
            margin-right: 8px;
        }

        .like_ span {
            color: #000;
            font-size: 18px;
            font-weight: 600;
            font-family: arial;
        }

        #image_zoom_modal_col {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #image_zoom_modal_col img,
        #image_zoom_modal_col video {
            max-width: 100%;
            max-height: 80vh;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 4px;
        }

        #text_post {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        #text_post .emojionearea {
            background: #fff !important;
            box-shadow: 0px 0px 6px 0px #000;
        }

        #text_post .emojionearea-editor {
            width: 92% !important;
            color: #000 !important;
            background: #78787829 !important;
            caret-color: #000 !important;
        }

        #text_post .emojionearea-editor:empty:before {
            color: #000000;
        }

        #text_post .emojionearea .emojionearea-picker {
            background: rgb(255, 255, 255) !important;
            box-shadow: 0px 0px 4px 2px #000 !important;
        }

        #text_post .emojionearea .emojionearea-picker.emojionearea-picker-position-top {
            /* top: 366px !important; */
            left: 0px !important;
            transform: translate(0%, -100%) !important;
        }

        .post__mess_style img {
            width: 24px;
            height: 24px;
        }

        #loading_animation_page {
            width: 100%;
            height: 100vh;
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 1000000000000000000000000000;
            display: none;
        }

        #loading_ani_p {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #000000d4;
        }

        #loading_ani_p img {
            border-radius: 50%;
        }

        .rection__emoji_row {
            border-top: 1px solid #acaeb3;
            user-select: none;
            /* background-color: #e0aca3; */
            /* background-color: #d2c2c0; */
            /* border-radius: 17px; */
        }

        .rection___img img {
            width: 20px;
            height: 20px;
            margin-right: 6px;
        }

        .rection___img {
            /* width: 50px; */
            /* min-width: 50px; */
            max-width: 100px;
            background-color: #d7dce2;
            padding: 4px 8px;
            border-radius: 14px;
            margin: 8px 4px;
        }

        .rection_section {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 4px;
            /* background-color: #7a6f72; */
            /* border-radius: 14px; */
        }

        .rection___text {
            background-color: #000000;
            padding: 4px 9px;
            border-radius: 10px;
            color: #fff;
        }

        #profile_side__img_,
        #profile_side__img_text {
            width: 36px;
            height: 36px;
            background: #0d6efd;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: 700;
            color: #fff;
            font-size: 24px;
        }

        #profile_side__img_text {
            width: 40px;
            height: 40px;
        }
        .post__mess_style {
            word-break: break-word;
        }
        .watch__video_specific__user video{
            width: 70%;
            max-height: 72vh;
            border-radius: 10px;
            box-shadow: 0px 0px 4px 1px #000, 0px 0px 4px 1px #fff, 0px 0px 4px 1px #000;
        }
        .no_found_video_watch {
            box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000;
            border-radius: 10px;
            font-size: 20px;
            font-weight: 700;
            user-select: none;
            width: 100%;
            text-align: center;
            padding: 10px;
        }
        .text_post_emojionearea_picker_top1 {
            top: 366px !important;
        }
        .text_post_emojionearea_picker_top2 {
            top: 387.42px !important;
        }
        .text_post_emojionearea_picker_top3 {
            top: 408.84px !important;
        }
        .text_post_emojionearea_picker_top4 {
            top: 425.26px !important;
        }
        @media screen and (max-width:1200px) {
            .watch__video_specific__user video {
                width: 78%;
            }
        }
        @media screen and (max-width:992px) {
            .watch__video_specific__user video {
                width: 96%;
            }
        }
        @media screen and (max-width:578px) {
            .res_ele {
                width: 96% !important;
            }
            .watch__video_specific__user video {
                width: 98%;
            }
        }
        @media screen and (max-width:500px) {
            #text_post .emojionearea-editor {
                height: 39.5px !important;
            }
        }

        @media screen and (max-width:480px) {

            .like_,
            .comment_,
            .like_ span {
                font-size: 17px;
            }

            .like_ img {
                width: 20px;
                height: 20px;
            }
            .watch__video_specific__user video {
                width: 100%;
            }

        }
    </style>
</head>

<body>
    <div id="loading_animation_page">
        <div id="loading_ani_p">
            <img src="img/icon/loadng_animation.svg">
        </div>
    </div>
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <!-- user_header -->
    <?php
    require_once "user_header.php";
    ?>


    <!-- slide bar Start -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="slide_bar_m" aria-labelledby="slide_bar_mLabel">
        <div class="offcanvas-header d-flex align-items-center justify-content-end">
            <!-- <h5 class="offcanvas-title" id="slide_bar_mLabel">Offcanvas</h5> -->
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container m-0 p-0">
                <a href="profile?uid=<?php echo $_SESSION['user_id']; ?>" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <!-- <img src="img/profile_img/default_image1.jpg" alt=""> -->
                            <?php
                            if (!isset($_SESSION)) {
                                session_start();
                            }
                            $user__id = $_SESSION['user_id'];
                            require_once "conn.php";
                            $conn = connected() or die("Connection Failed");
                            $sql = "SELECT image_type FROM user WHERE user_id='$user__id'";
                            $result = mysqli_query($conn, $sql) or die("Query Failed");
                            $image_type = "";
                            if (mysqli_num_rows($result) > 0) {
                                while ($arr = mysqli_fetch_assoc($result)) {
                                    $image_type = $arr["image_type"];
                                }
                            }
                            if ($image_type == "text") {
                                $ch = strtoupper(substr(explode(" ", $_SESSION['user_name'])[0], 0, 1));
                                echo "<div id='profile_side__img_'>$ch</div>";
                            } else {
                                $sql2 = "SELECT profile_image FROM user WHERE user_id='$user__id'";
                                $result2 = mysqli_query($conn, $sql2) or die("Query Failed");
                                $image_name = "";
                                if (mysqli_num_rows($result2) > 0) {
                                    while ($arr = mysqli_fetch_assoc($result2)) {
                                        $image_name = $arr["profile_image"];
                                    }
                                }
                                echo "<img src='img/profile_img/$image_name'>";
                            }
                            mysqli_close($conn);
                            ?>
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center"><?php echo $_SESSION['user_name']; ?></div>
                </a>
                <a href="#" class="row justify-content-start p-3 row_ele_style show_all_specific_post">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/home.svg" alt="post">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Post</div>
                </a>
                <!-- <a href="#" class="row justify-content-start p-3 row_ele_style show_friend_in_user">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/friends.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Friends</div>
                </a> -->
                <!-- <a href="#" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/group.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Groups</div>
                </a> -->

                <a href="#" class="row justify-content-start p-3 row_ele_style show_all_specific_video_in_all_user">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/watch.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Watch</div>
                </a>
                <a href="#" class="row justify-content-start p-3 row_ele_style message_all_user">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/messenger.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Messenger</div>
                </a>
                <!-- <a href="#" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/pages.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Pages</div>
                </a> -->
            </div>
        </div>
    </div>
    <!-- slide bar end -->


    <!-- Post Modal start-->
    <div id="container_main_madal">
        <div class="container_post">
            <div class="wrapper_post">
                <section class="post">
                    <header>
                        <button type="button" class="btn-close" id="hide_post_modal_btn"></button>
                        <span>Create Post</span>
                    </header>
                    <form action="#" id="post_modal_form">
                        <div class="content">
                            <!-- <img id="user_profile_image1_" src="img/profile_img/default_image1.jpg" alt="logo"> -->
                            <?php
                            if (!isset($_SESSION)) {
                                session_start();
                            }
                            $user__id = $_SESSION['user_id'];
                            require_once "conn.php";
                            $conn = connected() or die("Connection Failed");
                            $sql = "SELECT image_type FROM user WHERE user_id='$user__id'";
                            $result = mysqli_query($conn, $sql) or die("Query Failed");
                            $image_type = "";
                            if (mysqli_num_rows($result) > 0) {
                                while ($arr = mysqli_fetch_assoc($result)) {
                                    $image_type = $arr["image_type"];
                                }
                            }
                            if ($image_type == "text") {
                                $ch = strtoupper(substr(explode(" ", $_SESSION['user_name'])[0], 0, 1));
                                echo "<div id='profile_side__img_'>$ch</div>";
                            } else {
                                $sql2 = "SELECT profile_image FROM user WHERE user_id='$user__id'";
                                $result2 = mysqli_query($conn, $sql2) or die("Query Failed");
                                $image_name = "";
                                if (mysqli_num_rows($result2) > 0) {
                                    while ($arr = mysqli_fetch_assoc($result2)) {
                                        $image_name = $arr["profile_image"];
                                    }
                                }
                                echo "<img id='user_profile_image1_' src='img/profile_img/$image_name'>";
                            }
                            mysqli_close($conn);
                            ?>

                            <!--change-->
                            <div class="details">
                                <p class="m-0"><?php echo $_SESSION['user_name']; ?></p>
                                <!--change-->
                                <div class="privacy" id="privacy_option_val">
                                    <i class="fas fa-globe-asia"></i>
                                    <span>Public</span>
                                    <i class="fas fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                        <div id="text_post">
                            <textarea id="post_mess" placeholder="Type any Message"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-12 img_style_post mb-2" id="img_style_post_id">

                            </div>
                        </div>
                        <!-- <div class="theme-emoji">
                            <img src="img/post_modal_logo/theme.svg" alt="theme">
                            <img src="img/post_modal_logo/smile.svg" alt="smile">
                        </div> -->
                        <div class="options">
                            <p class="m-0">Add to Your Post</p>
                            <ul class="list p-0 m-0">
                                <li><label for="post_image"><img src="img/post_modal_logo/gallery.svg" alt="gallery"></label></li>
                                <input type="file" name="post_image[]" id="post_image" multiple="multiple" accept="image/png, image/jpeg,image/gif,video/mp4">
                                <!-- <li><img src="img/post_modal_logo/tag.svg" alt="gallery"></li>
                                <li><img src="img/post_modal_logo/emoji.svg" alt="gallery"></li>
                                <li><img src="img/post_modal_logo/mic.svg" alt="gallery"></li>
                                <li><img src="img/post_modal_logo/more.svg" alt="gallery"></li> -->
                            </ul>
                        </div>
                        <button type="submit" id="post_btn">Post</button>
                    </form>
                </section>

                <section class="audience">
                    <header>
                        <div class="arrow-back"><i class="fas fa-arrow-left"></i></div>
                        <p class="m-0">Select Audience</p>
                    </header>
                    <div class="content">
                        <p class="m-0">Who can see your post?</p>
                        <span>Your post will show up in News Feed, on your profile and in search results.</span>
                    </div>
                    <ul class="list p-0">
                        <li id="public_li" class="active">
                            <div class="column">
                                <div class="icon"><i class="fas fa-globe-asia"></i></div>
                                <div class="details">
                                    <p class="m-0">Public</p>
                                    <span>Anyone on or off WeConnect</span>
                                </div>
                            </div>
                            <!-- <div class="radio"></div> -->
                            <input type="radio" name="post_" id="public" value="public" class="form-check-input" checked>
                        </li>
                        <li id="friends_li">
                            <div class="column">
                                <div class="icon"><i class="fas fa-user-friends"></i></div>
                                <div class="details">
                                    <p class="m-0">Friends</p>
                                    <span>Your friends on WeConnect</span>
                                </div>
                            </div>
                            <!-- <div class="radio"></div> -->
                            <input type="radio" name="post_" id="friends" value="friends" class="form-check-input">
                        </li>
                        <!-- <li id="specific_li">
                            <div class="column">
                                <div class="icon"><i class="fas fa-user"></i></div>
                                <div class="details">
                                    <p class="m-0">Specific</p>
                                    <span>Only show to some friends</span>
                                </div>
                            </div>
                            <input type="radio" name="post_" id="specific" value="specific" class="form-check-input">
                        </li> -->
                        <li id="only_me_li">
                            <div class="column">
                                <div class="icon"><i class="fas fa-lock"></i></div>
                                <div class="details">
                                    <p class="m-0">Only me</p>
                                    <span>Only you can see your post</span>
                                </div>
                            </div>
                            <!-- <div class="radio"></div> -->
                            <input type="radio" name="post_" id="only_me" value="only_me" class="form-check-input">
                        </li>
                        <!-- <li id="custom_li">
                            <div class="column">
                                <div class="icon"><i class="fas fa-cog"></i></div>
                                <div class="details">
                                    <p class="m-0">Custom</p>
                                    <span>Include and exclude friends</span>
                                </div>
                            </div>
                            <input type="radio" name="post_" id="custom" value="custom" class="form-check-input">
                        </li> -->
                    </ul>
                    <!-- </form> -->
                </section>
            </div>
        </div>
    </div>
    <!-- Post Modal end-->

    <!-- post start -->
    <div class="container my-4">
        <div class="row justify-content-center" id="post_friend_video_ele__show">

        </div>
    </div>
    <!-- post end -->


    <!--image zoom Modal -->
    <div class="modal fade" id="image_zoom_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="image_zoom_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" id="image_zoom_modal_close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" id="image_zoom_modal_col">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message modal -->
    <?php require "message_modal.php" ?>

    <!-- Edit Profile modal -->
    <?php require "edit_profile_modal.php" ?>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- floating_script js -->
    <!-- <script src="js/floating_script.js"></script> -->

    <!-- sweetalert2 js -->
    <script src="js/sweetalert2.js"></script>

    <!-- emoji script -->
    <script src="js/emoji_script.js"></script>

    <!-- rection_emoji.js -->
    <script src="js/rection_emoji.js"></script>

    <!-- user_header.js -->
    <script src="js/user_header.js"></script>

    <!-- message_modal.js -->
    <script src="js/message_modal.js"></script>

    <!-- edit_profile_modal.js -->
    <script src="js/edit_profile_modal.js"></script>

    <script>
        $(document).ready(function() {
            var video_play_state_in_modal = 0;
            var post_privacy = "public";
            var post_get_in_c_t = "";
            var clear_inter_val_in_post_check = "";
            var check_new_post_in_db_f_call_status = 0;

            function check_new_post_in_db() {
                clear_inter_val_in_post_check = setInterval(function(){
                    $.ajax({
                        url:"ajax_request/check_new_post_data",
                        type:"POST",
                        beforeSend:function(){
                            if(clear_inter_val_in_post_check != "") {
                                clearInterval(clear_inter_val_in_post_check);
                            }
                        },
                        data:{
                            post_get_in_c_t:post_get_in_c_t
                        },
                        dataType:"json",
                        success: function(data) {
                            if (data.error == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'something went wrong'
                                });
                                // console.log("hh");
                            }
                            else {
                                setTimeout(function(){
                                    if(data.total_post == 1) {
                                        if(data.post_data != "") {
                                            $("#add_post_data").prepend(data.mdata);
                                        }
                                    }
                                    else if(data.total_post == 0) {
                                        if(data.post_data != "") {
                                            $("#add_post_data").html(data.mdata);
                                        }
                                    }
                                    post_get_in_c_t = data.post_get_in_c_t;
                                    check_new_post_in_db();
                                },1000);
                                // console.log(data.post_get_in_c_t);
                            }
                        }
                    });
                },5000);
            }

            // $("#message_modal").modal("show");

            $(document).on("mouseenter", ".like_div", function() {
                $(this).append(`
                    <div class='reaction-box'>
                        <div class='reaction-icon like'>
                            <label>Like</label>
                        </div>
                        <div class='reaction-icon love'>
                            <label>Love</label>
                        </div>
                        <div class='reaction-icon care'>
                            <label>Care</label>
                        </div>
                        <div class='reaction-icon haha'>
                            <label>Haha</label>
                        </div>
                        <div class='reaction-icon wow'>
                            <label>Wow</label>
                        </div>
                        <div class='reaction-icon sad'>
                            <label>Sad</label>
                        </div>
                        <div class='reaction-icon angry'>
                            <label>Angry</label>
                        </div>
                    </div>
                    `);
                $(this).children(".reaction-box").children().each(function(i, e) {
                    setTimeout(function() {
                        $(e).addClass("show");
                    }, i * 100);
                });
            }).on("mouseleave", ".like_div", function() {
                if ($(this).children(".reaction-box").length == 1) {
                    $(this).children(".reaction-box").children().removeClass("show");
                    $(this).children(".reaction-box").remove();
                }
            });
            // $(document).on("mouseleave",".like_div",function(){
            //     if($(this).children(".reaction-box").length == 1) {
            //         $(this).children(".reaction-box").children().removeClass("show");
            //         $(this).children(".reaction-box").remove();
            //     }
            // });
            // $(window).contextmenu(function(event){
            //     if($(".reaction-box").length == 1) {
            //         $(".reaction-box").remove();
            //     }
            // });


            $("#post_mess").emojioneArea({
                tonesStyle: "radio",
                // searchPosition: "bottom",
                pickerPosition: 'top',
                // filtersPosition: "bottom",
                placeholder: "Type a message",
                // useInternalCDN: true,
            });
            var show_post_modal_2_emojioneArea = "";
            
            // $(".show_post_modal_2").emojioneArea({
            //     tonesStyle: "radio",
            //     // searchPosition: "bottom",
            //     pickerPosition: 'top',
            //     // filtersPosition: "bottom",
            //     placeholder: "Write a comment",
            //     // useInternalCDN: true,
            // });
            setTimeout(function() {
                $(".emojionearea-button").css("order", "-100");
                $(".emojionearea-button").css("margin-right", "16px");
                // $(".show_post_modal_2 .emojionearea-button").attr("data-show_emoji_p","0");
                $("#text_post .emojionearea-picker").addClass("text_post_emojionearea_picker_top1");
            }, 1000);

            

            // post modal js code start
            var check_image_post = 0;
            $("#img_style_post_id").parent().css("visibility", "hidden");

            function radio_checked(ele) {
                ele.prop("checked", true);
            }

            $("#public_li").click(function() {
                $(".container_post li").removeClass("active");
                $("#public_li").addClass("active");
                radio_checked($("#public"));
                $("#privacy_option_val").html("<i class='fas fa-globe-asia'></i><span>Public</span><i class='fas fa-caret-down'></i>");
                post_privacy = "public";
            });
            $("#friends_li").click(function() {
                $(".container_post li").removeClass("active");
                $("#friends_li").addClass("active");
                radio_checked($("#friends"));
                $("#privacy_option_val").html("<i class='fas fa-user-friends'></i><span>Friends</span><i class='fas fa-caret-down'></i>");
                post_privacy = "friends";
            });
            // $("#specific_li").click(function() {
            //     $(".container_post li").removeClass("active");
            //     $("#specific_li").addClass("active");
            //     radio_checked($("#specific"));
            //     $("#privacy_option_val").html("<i class='fas fa-user'></i><span>Specific</span><i class='fas fa-caret-down'></i>");
            // });
            $("#only_me_li").click(function() {
                $(".container_post li").removeClass("active");
                $("#only_me_li").addClass("active");
                radio_checked($("#only_me"));
                $("#privacy_option_val").html("<i class='fas fa-lock'></i><span>Only me</span><i class='fas fa-caret-down'></i>");
                post_privacy = "only_me";
            });
            // $("#custom_li").click(function() {
            //     $(".container_post li").removeClass("active");
            //     $("#custom_li").addClass("active");
            //     radio_checked($("#custom"));
            //     $("#privacy_option_val").html("<i class='fas fa-cog'></i><span>Custom</span><i class='fas fa-caret-down'></i>");
            // });

            $(document).on("click", "#show_post_modal_", function() {
                $("#container_main_madal").css("transform", "scale(1)");
                $("body").css("overflow", "hidden");
                // if(clear_inter_val_in_post_check != "") {
                //     clearInterval(clear_inter_val_in_post_check);
                // }
            });
            $("#hide_post_modal_btn").click(function() {
                $("#container_main_madal").css("transform", "scale(0)");
                $("body").css("overflow", "auto");
                // check_new_post_in_db();
            });
            $("#container_main_madal .container_post").click(function(event) {
                event.stopImmediatePropagation();
            });
            $(document).on("mouseenter", ".user_time_icon i,.user_time_icon a", function() {
                $(this).tooltip('show');
            });
            $(document).on("click", ".user_time_icon a", function(event) {
                event.preventDefault();
            });
            // $("#container_main_madal").click(function() {
            //     $("#container_main_madal").css("transform", "scale(0)");
            // });


            // const container = document.querySelector(".container_post");
            // privacy = container.querySelector(".post .privacy");
            // arrowBack = container.querySelector(".audience .arrow-back");

            // privacy.addEventListener("click", () => {
            //     container.classList.add("active");
            // });

            // arrowBack.addEventListener("click", () => {
            //     container.classList.remove("active");
            // });

            $("#privacy_option_val").click(function() {
                $(".container_post .wrapper_post .post").css("transform", "translateX(-100%)");
                $(".container_post .wrapper_post .audience").css("transform", "translateX(-100%)");
            });
            $(".container_post .wrapper_post .audience .arrow-back").click(function() {
                $(".container_post .wrapper_post .post").css("transform", "translateX(0%)");
                $(".container_post .wrapper_post .audience").css("transform", "translateX(0%)");
            });

            // post modal js code end

            $("#post_image").change(function(event) {
                // console.log("change");
                // / Read selected files
                var totalfiles = document.getElementById('post_image').files.length;
                // console.log(totalfiles);
                var inner_html_a = "";
                for (var index = 0; index < totalfiles; index++) {
                    file_name = URL.createObjectURL(event.target.files[index]);

                    var file_type = (event.target.files[index].type).split("/")[0];

                    if (file_type == "image") {
                        inner_html_a += "<img src='" + file_name + "'>";
                    } else if (file_type == "video") {
                        inner_html_a += " <video src='" + file_name + "' controls></video>";
                    }
                }

                $("#img_style_post_id").html(inner_html_a);
                if ($("#img_style_post_id").html() == "") {
                    $("#img_style_post_id").parent().css("visibility", "hidden");
                    check_image_post = 0;
                } 
                else {
                    // $("#img_style_post_id").parent().css("display","block");
                    $("#img_style_post_id").parent().css("visibility", "visible");
                    check_image_post = 1;
                }
            });


            $("#post_modal_form").on("submit", function(event) {
                event.preventDefault();
                // var post_privacy = $("#container_main_madal input[type='radio']:checked").val().trim();
                // var post_message = $("#post_mess").val().trim();
                var formData = new FormData(this);
                var post_message = document.querySelector("#text_post .emojionearea-editor").innerHTML;
                formData.append("post_message", post_message);
                formData.append("post_privacy", post_privacy);
                formData.append("post_get_in_c_t", post_get_in_c_t);

                $.ajax({
                    url: "ajax_request/post_data_ajax",
                    type: "POST",
                    beforeSend: function() {
                        $("#post_btn").prepend("<span id='sp_1' class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span>");
                        document.getElementById("post_btn").disabled = true;
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data: formData,
                    dataType: "json",
                    // data: {
                    //     post_privacy: post_privacy,
                    //     post_message: post_message
                    // },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // console.log(data);
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'something went wrong'
                            });
                            // console.log("hh");
                        } 
                        else {
                            // console.log("jj");
                            if (data.post_message != true) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: '<span style="color:red;font-size: 20px;font-weight: 600;">' + data.post_message + '<span>'
                                });
                                document.querySelector("#text_post .emojionearea-editor").innerHTML = "";
                                // console.log(data.post_message);
                            }
                            if (data.post_privacy != true) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: '<span style="color:red;font-size: 20px;font-weight: 600;">' + data.post_privacy + '<span>'
                                });
                            }
                            if (data.file_upload == 1) {
                                if (data.file_check_status != true) {
                                    Swal.fire({
                                        icon: 'warning',
                                        html: '<span style="color:red;font-size: 20px;font-weight: 600;">' + data.file_check_status + '<span>'
                                    });
                                    // console.log("pp");
                                }
                            }
                            var post_fadeout_status = 0;
                            if (data.success == 1) {
                                post_fadeout_status = 1;
                                $("#post_mess").val("");
                                setTimeout(function(){
                                    document.querySelector("#text_post .emojionearea-editor").innerHTML = "";
                                    $("#container_main_madal").css("transform", "scale(0)");
                                    if(data.total_post == 1) {
                                        $("#add_post_data").prepend(data.post_data);
                                    }
                                    else if(data.total_post == 0) {
                                        $("#add_post_data").html(data.post_data);
                                    }
                                    post_get_in_c_t = data.post_get_in_c_t;
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Post Creatrd Successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $("#post_btn #sp_1").remove();
                                    $("#loading_animation_page").fadeOut("fast");
                                    $("#img_style_post_id").html("");
                                    $("#img_style_post_id").parent().css("visibility", "hidden");
                                    $("body").css("overflow", "auto");
                                    // check_new_post_in_db();
                                },1000);
                                // $("#img_style_post_id").parent().css("display","none");
                                $("#post_image").val("");
                                // $("#area_w").css("min-height",$("body").outerHeight(true));
                            }
                            $(window).scrollTop(0);
                            if(post_fadeout_status == 0) {
                                $("#post_btn #sp_1").remove();
                                $("#loading_animation_page").fadeOut("fast");
                            }
                        }
                        document.getElementById("post_btn").disabled = false;
                    }
                });
            });

            // $('#slide_bar_m').offcanvas('hide');
            $("#side_bar_show_btn").click(function() {
                $("#side_bar_show_btn").tooltip('hide');
                $('#slide_bar_m').offcanvas('show');
            });

            $(document).on("click", ".img_style_post_set img", function(event) {
                var ele = $(this).clone();
                $("#image_zoom_modal").modal("show");
                $("#image_zoom_modal_col").html(ele);
            });
            $(document).on("click", ".img_style_post_set video", function(event) {
                event.preventDefault();
                // document.querySelectorAll(".img_style_post_set video").pause();
                for (var ele_video of document.querySelectorAll(".img_style_post_set video")) {
                    ele_video.pause();
                }
                // $(this).pause();
                // this.currentTime = 0;
                var ele = $(this).clone();
                $("#image_zoom_modal").modal("show");
                $("#image_zoom_modal_col").html(ele);
                document.querySelector("#image_zoom_modal_col video").play();
                video_play_state_in_modal = 1;
            });
            $("#image_zoom_modal_close").click(function() {
                if (video_play_state_in_modal == 1) {
                    document.querySelector("#image_zoom_modal_col video").pause();
                    document.querySelector("#image_zoom_modal_col video").currentTime = 0;
                    video_play_state_in_modal = 0;
                }
            });


            function get_all_specific_post_in_all_user() {
                $("#home_icon_ele #home_icon svg path").css("fill", "#1877f2");
                // $("#friend_icon_ele #friend_icon svg path").css("fill", "#000");
                $("#watch_icon_ele #watch_icon svg path").css("fill", "#000");

                $("#home_icon_ele").addClass("active_middle_icon");
                // $("#friend_icon_ele").removeClass("active_middle_icon");
                $("#watch_icon_ele").removeClass("active_middle_icon");

                $("#border_bottom_div").css("transform", "translateX(0%)");

                $("#home_icon_ele").tooltip('hide');

                // $("#left_slide_l_bar").css("display","block");
                // if(clear_inter_val_in_post_check != "") {
                //     if(check_new_post_in_db_f_call_status == 0) {
                //         clearInterval(clear_inter_val_in_post_check);
                //     }
                // }

                $.ajax({
                    url: "ajax_request/get_post_data",
                    type: "POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    dataType:"json",
                    success: function(data) {
                        $("#post_friend_video_ele__show").html(data.mdata);
                        post_get_in_c_t = data.post_get_in_c_t;
                        // console.log(post_get_in_c_t);

                        for (var ele_video of document.querySelectorAll(".img_style_post_set video")) {
                            ele_video.addEventListener("play", function() {
                                for (var ele_video2 of document.querySelectorAll(".img_style_post_set video")) {
                                    if (this != ele_video2) {
                                        ele_video2.pause();
                                    }
                                }
                            })
                        }
                        $("#loading_animation_page").fadeOut("fast");
                        if(check_new_post_in_db_f_call_status == 0) {
                            check_new_post_in_db();
                        }
                        check_new_post_in_db_f_call_status = 1;
                    }
                });
            }


            // function get_all_friend_in_user() {
            //     $("#friend_icon_ele #friend_icon svg path").css("fill", "#1877f2");
            //     $("#home_icon_ele #home_icon svg path").css("fill", "#000");
            //     $("#watch_icon_ele #watch_icon svg path").css("fill", "#000");

            //     $("#home_icon_ele").removeClass("active_middle_icon");
            //     $("#friend_icon_ele").addClass("active_middle_icon");
            //     $("#watch_icon_ele").removeClass("active_middle_icon");

            //     $("#border_bottom_div").css("transform", "translateX(100%)");

            //     $("#friend_icon_ele").tooltip('hide');
            //     // $("#left_slide_l_bar").css("display","none");
            //     $("#post_friend_video_ele__show").html(`<div class="col-xl-6 col-lg-7 res_ele">
            //                                                 <div class="row my-3 align-items-center style_post_any">
            //                                                     Friend
            //                                                 </div>
            //                                             </div>`);
            // }

            function get_all_specific_video_in_all_user() {
                $("#watch_icon_ele #watch_icon svg path").css("fill", "#1877f2");
                $("#home_icon_ele #home_icon svg path").css("fill", "#000");
                // $("#friend_icon_ele #friend_icon svg path").css("fill", "#000");

                $("#home_icon_ele").removeClass("active_middle_icon");
                // $("#friend_icon_ele").removeClass("active_middle_icon");
                $("#watch_icon_ele").addClass("active_middle_icon");

                $("#border_bottom_div").css("transform", "translateX(100%)");
                // $("#left_slide_l_bar").css("display","none");
                $("#watch_icon_ele").tooltip('hide');

                // if(clear_inter_val_in_post_check != "") {
                //     clearInterval(clear_inter_val_in_post_check);
                // }

                $.ajax({
                    url:"ajax_request/get_video_data",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    success: function(data) {
                        $("#post_friend_video_ele__show").html(data);
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });

            }

            <?php
            if ($page_name == "home") {
                ?> get_all_specific_post_in_all_user();<?php
            } 
            else if ($page_name == "watch") {
                ?>get_all_specific_video_in_all_user();<?php
            }
            
            ?>

            function page_change(page_name) {
                <?php
                    $webcite_ssl_or_not = "";
                    if(isset($_SERVER['HTTPS'])) {
                        $webcite_ssl_or_not = "https";
                    }
                    else {
                        $webcite_ssl_or_not = "http";
                    }
                    $current_url = "$webcite_ssl_or_not://{$_SERVER['SERVER_NAME']}" . explode(".", $_SERVER['PHP_SELF'])[0] . "?page_name="; 
                ?>
                var current_url = "<?php echo $current_url; ?>" + page_name;
                // console.log(current_url);
                history.pushState(null, '', current_url)
            }

            $("#home_icon_ele").click(function() {
                get_all_specific_post_in_all_user();
                page_change("home");
            });
            // $("#friend_icon_ele").click(function() {
            //     get_all_friend_in_user();
            //     page_change("friends");
            // });
            $("#watch_icon_ele").click(function() {
                get_all_specific_video_in_all_user();
                page_change("watch");
            });


            $(document).on("click", ".like_div", function(event) {
                var last_child = this.lastElementChild;
                var sibling_ele = this.parentElement.previousElementSibling;
                var post_id = $(sibling_ele).attr("data-p");
                var current_ele = this;
                var first_child = this.firstElementChild;
                var first_child_f = first_child.firstElementChild;
                console.log(first_child);
                console.log(first_child_f);
                // console.log(post_id);
                $.ajax({
                    url: "ajax_request/like_ajax",
                    type: "POST",
                    data: {
                        post_id: post_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        } 
                        else {
                            if (data.rection_state == true) {
                                $(first_child_f).remove();
                                $(first_child).prepend("<img src='img/rection_emoji_icon/like.svg'>");
                                $(first_child.lastElementChild).html("Like");
                            } 
                            else {
                                $(first_child_f).remove();
                                $(first_child).prepend("<i class='far fa-thumbs-up'></i>");
                                $(first_child.lastElementChild).html("Like");
                            }
                            if (data.total_rection_count > 0) {
                                $(sibling_ele).fadeIn();
                            } 
                            else {
                                $(sibling_ele).fadeOut();
                            }
                            $(sibling_ele).find(".no_of_like").html(data.like);
                            $(sibling_ele).find(".no_of_love").html(data.love);
                            $(sibling_ele).find(".no_of_care").html(data.care);
                            $(sibling_ele).find(".no_of_haha").html(data.haha);
                            $(sibling_ele).find(".no_of_wow").html(data.wow);
                            $(sibling_ele).find(".no_of_sad").html(data.sad);
                            $(sibling_ele).find(".no_of_angry").html(data.angry);
                            $(sibling_ele).find(".rection___text").html(data.total_rection_count);
                        }
                        // $(last_child).remove();
                        if ($(current_ele).children(".reaction-box").length == 1) {
                            $(current_ele).children(".reaction-box").remove();
                        }
                    }
                });
            });

            $(document).on("click", ".reaction-box", function(event) {
                event.stopPropagation();
            });
            $(document).on("click", ".reaction-icon label", function(event) {
                event.stopPropagation();
            });
            $(document).on("click", ".reaction-icon", function(event) {
                var rection_type = ($(this).attr("class")).split(" ")[1];
                var sibling_ele = this.parentElement.parentElement.parentElement.previousElementSibling;
                var post_id = $(sibling_ele).attr("data-p");

                var previous_ele_sibling = this.parentElement.previousElementSibling;
                var show_icon_ele = previous_ele_sibling.firstElementChild;
                var show_icon_text = previous_ele_sibling.lastElementChild;

                var current_ele = this;

                // console.log(sibling_ele);
                $.ajax({
                    url: "ajax_request/user_rection_post_ajax",
                    type: "POST",
                    data: {
                        post_id: post_id,
                        rection_type: rection_type
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        } else {
                            if (data.total_rection_count > 0) {
                                $(sibling_ele).fadeIn();
                            } else {
                                $(sibling_ele).fadeOut();
                            }

                            if (data.rection_type == "like") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/like.svg'>");
                                $(show_icon_text).html("Like");
                            } 
                            else if (data.rection_type == "love") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/love.svg'>");
                                $(show_icon_text).html("Love");
                            } 
                            else if (data.rection_type == "care") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/care.svg'>");
                                $(show_icon_text).html("Care");
                            } 
                            else if (data.rection_type == "haha") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/haha.svg'>");
                                $(show_icon_text).html("Haha");
                            } 
                            else if (data.rection_type == "wow") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/wow.svg'>");
                                $(show_icon_text).html("Wow");
                            } 
                            else if (data.rection_type == "sad") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/sad.svg'>");
                                $(show_icon_text).html("Sad");
                            } 
                            else if (data.rection_type == "angry") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/angry.svg'>");
                                $(show_icon_text).html("Angry");
                            }

                            $(sibling_ele).find(".no_of_like").html(data.like);
                            $(sibling_ele).find(".no_of_love").html(data.love);
                            $(sibling_ele).find(".no_of_care").html(data.care);
                            $(sibling_ele).find(".no_of_haha").html(data.haha);
                            $(sibling_ele).find(".no_of_wow").html(data.wow);
                            $(sibling_ele).find(".no_of_sad").html(data.sad);
                            $(sibling_ele).find(".no_of_angry").html(data.angry);
                            $(sibling_ele).find(".rection___text").html(data.total_rection_count);
                            $(current_ele.parentElement).remove();
                        }
                        if ($(current_ele.parentElement).children(".reaction-box").length == 1) {}
                    }
                });
                // console.log(show_icon_ele);
            });

            $("#search__friend").on("input", function() {
                var search_value = $(this).val();

                $.ajax({
                    url: "ajax_request/search_friend",
                    type: "POST",
                    data: {
                        search_value: search_value
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        } else {
                            $("#search_result_ele").html(data.search_result);
                            // document.getElementById("search_result_ele").innerHTML = data.search_result;
                        }
                    }
                });
            });
            
            $(document).on("mouseup",".notifications_child",function(event) {
                var left_notafication_child_ele = $(this).children(".left_notafication_ele");
                var right_notafication_child_ele = $(this).children(".right_notafication_ele");
                var nid = $(this).attr("data-n");
                $(right_notafication_child_ele).remove();
                $(left_notafication_child_ele).css("width", "98%");
                $.ajax({
                    url: "ajax_request/notafication_read_ajax",
                    type: "POST",
                    data: {
                        nid: nid
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        } else if (data.error == 1) {
                            if (data.no_of_notafication > 0) {
                                $("#no_of_notafication").css("display", "block");
                            } else {
                                $("#no_of_notafication").css("display", "none");
                            }
                            $("#inner_no_of_notafication").html(data.no_of_notafication);
                            $(right_notafication_child_ele).remove();
                            $(left_notafication_child_ele).css("width", "98%");
                        }
                    }
                });
            });

            $(document).on("click", ".show_all_specific_post", function(event) {
                event.preventDefault();
                $('#slide_bar_m').offcanvas('hide');
                get_all_specific_post_in_all_user();
                page_change("home");
            });

            // $(document).on("click", ".show_friend_in_user", function(event) {
            //     event.preventDefault();
            //     $('#slide_bar_m').offcanvas('hide');
            //     get_all_friend_in_user();
            //     page_change("friends");
            // });
            $(document).on("click", ".show_all_specific_video_in_all_user", function(event) {
                event.preventDefault();
                $('#slide_bar_m').offcanvas('hide');
                get_all_specific_video_in_all_user();
                page_change("watch");
            });
            $(document).on("click", ".message_all_user", function(event) {
                event.preventDefault();
                $('#slide_bar_m').offcanvas('hide');
                $("#message_modal").modal("show");
                get_all_friend_in_message_modal();
            });
            var body_width_ = $("body").css("width");
            body_width_ = Math.floor(Number(body_width_.substr(0,(body_width_.length)-2)));
            if(body_width_ > 500) {
                $(document).on("keyup","#text_post .emojionearea-editor",function(){
                    var h_e = $("#text_post .emojionearea").css("height");
                    if(h_e == "59.425px") {
                        $("#text_post .emojionearea-picker").addClass("text_post_emojionearea_picker_top1");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top2");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top3");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top4");
                    }
                    else if(h_e == "80.85px") {
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top1");
                        $("#text_post .emojionearea-picker").addClass("text_post_emojionearea_picker_top2");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top3");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top4");
                    }
                    else if(h_e == "102.275px") {
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top1");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top2");
                        $("#text_post .emojionearea-picker").addClass("text_post_emojionearea_picker_top3");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top4");
                    }
                    else if(h_e == "120px") {
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top1");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top2");
                        $("#text_post .emojionearea-picker").removeClass("text_post_emojionearea_picker_top3");
                        $("#text_post .emojionearea-picker").addClass("text_post_emojionearea_picker_top4");
                    }
                });
            }


            
        });
        </script>
        <!-- comment -->
        <script src="js/comment_script.js"></script>
</body>

</html>