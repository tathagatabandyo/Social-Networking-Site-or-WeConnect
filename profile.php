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
    <link rel="shortcut icon" href="img/icon/icon.png" type="image/x-icon">
    <?php
    if (!isset($_GET['uid']) || $_GET['uid'] == '') {
    ?>
        <title>Error | No User Found | Something Went to Wrong</title>
        <script>
            alert("No User Found | Something Went to Wrong");
        </script>
    <?php
        die("<a href='user' style='text-align: center; display: inline-block; font-size: 40px; text-decoration: none; color: #fff; background-color: #000; width: 250px; font-weight: bold; padding: 19px; border-radius: 10px; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);'>Go To Home Page</a>");
    }
    require_once "conn.php";
    $conn = connected() or die("Connection Failed");
    $current_user_id = mysqli_real_escape_string($conn, $_GET['uid']);
    $sql_search_user = "SELECT user_name,image_type,profile_image,cover_photo,total_friends FROM user WHERE user_id=$current_user_id";
    $search_user_result = mysqli_query($conn, $sql_search_user) or die("Query Failed search User");
    if (mysqli_num_rows($search_user_result) == 0) {
    ?>
        <title>Error | No User Found | Something Went to Wrong</title>
        <script>
            alert("No User Found | Something Went to Wrong");
        </script>
    <?php
        die("<a href='user' style='text-align: center; display: inline-block; font-size: 40px; text-decoration: none; color: #fff; background-color: #000; width: 250px; font-weight: bold; padding: 19px; border-radius: 10px; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);'>Go To Home Page</a>");
    }

    $page_name = "post";
    if(isset($_GET['page_name'])) {
        if($_GET['page_name'] == "post" || $_GET['page_name'] == "friend" || $_GET['page_name'] == "photo" || $_GET['page_name'] == "video") {
            $page_name = $_GET['page_name'];
        }
        else {
            ?>
                <title>Error | No Page Found | Something Went to Wrong</title>
                <script>
                    alert("No Page Found | Something Went to Wrong");
                </script>
            <?php
            die("<a href='user' style='text-align: center; display: inline-block; font-size: 40px; text-decoration: none; color: #fff; background-color: #000; width: 250px; font-weight: bold; padding: 19px; border-radius: 10px; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);'>Go To Home Page</a>");
        }
    }

    $arr_current_user_details = mysqli_fetch_assoc($search_user_result);

    require "ajax_request/calculate_num_.php";

    $total_friends = cal_num_($arr_current_user_details['total_friends'],"friend");
    

    if (!isset($_SESSION)) {
        session_start();
    }
    $login_user_id = $_SESSION['user_id'];
    ?>
    <title><?php echo $arr_current_user_details['user_name']; ?> | WeConnect</title>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="stylesheet" href="css/animation.css">
    <link rel="stylesheet" href="css/user_header.css">
    <link rel="stylesheet" href="css/post_modal1.css">
    <link rel="stylesheet" href="css/emoji_style.css">
    <link rel="stylesheet" href="css/rection_emoji_style.css">
    <!-- <link rel="stylesheet" href="css/floating_style.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/message_modal.css">

    <link rel="stylesheet" href="css/edit_profile_modal.css">
    <link rel="stylesheet" href="css/date_picker.css">

    <style>
        a {
            text-decoration: none;
        }

        #home_icon_ele {
            background-color: #78787842;
        }

        #home_icon_ele svg path {
            fill: #787878;
            transition: fill 0.2s linear 0s;
        }

        #home_icon_ele:hover svg path {
            fill: #1877f2;
        }

        #home_icon_ele:hover {
            background-color: #cebd8c42 !important;
        }

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

        #cover_image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            object-position: center;
            user-select: none;
            border-radius: 0px 0px 12px 12px;
        }

        #profile_side__img_ {
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

        #user_profile_all_img {
            position: relative;
        }

        #profile_photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #0d6efd;
            position: absolute;
            bottom: 0px;
            left: 50%;
            transform: translate(-50%, 50%);
            border: 4px solid #ffffffe8;
            box-shadow: 0px 0px 4px 2px #000;
            user-select: none;
        }

        #profile_photo img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            object-position: top;
        }

        #profile_photo #profile__text_ {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #0d6efd;
            font-weight: 700;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 118px;
            user-select: none;
        }

        #cover_img_form_ele {
            position: absolute;
            right: 20px;
            bottom: 22px;
            display: flex;
            align-items: center;
            border-radius: 8px;

        }

        #cover_photo_change_btn {
            width: 100%;
            display: flex;
            padding: 6px;
            background-color: #fff;
            border-radius: 8px;
            font-weight: 600;
            color: #000;
            font-size: 18px;
            box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000;
            cursor: pointer;
        }

        #cover_photo_change_btn svg {
            margin-right: 8px;
        }

        #profile_img_change_btn {
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        #profile_img_form_ele {
            width: 30px;
            height: 30px;
            position: absolute;
            bottom: 6px;
            right: 8px;
            background: #fff;
            box-shadow: 0px 0px 0px 2px #897e7e;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #profile__name_ {
            font-size: 30px;
            font-weight: 900;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
            user-select: none;
        }

        #total_friends {
            font-size: 20px;
            font-weight: 600;
            color: #56422f;

        }

        #add_friend_request_btn,
        #friend_message_btn {
            box-shadow: none;
            transition: transform 0.12s linear 0s;
            font-weight: 600;
        }

        #add_friend_request_btn:active,
        #friend_message_btn:active {
            transform: scale(1.1);
        }
        #add_friend_request_btn .icon_request_f {
            font-size: 20px;
            margin-right: 8px;
        }

        #add_friend_request_btn svg,
        #friend_message_btn svg {
            margin-right: 8px;
        }

        #user_all_data {
            width: 100%;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000;
            padding: 5px 0px;
        }

        .user_data_show_ {
            width: calc(100% / 4);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0px;
            cursor: pointer;
            transition: background-color 0.25s linear 0s;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        .user_data_show_:hover {
            background-color: #c5bebe66;
        }

        .user_data_show_:active {
            background-color: #c5bebec4;
        }

        .active_user_data_show_:hover,
        .active_user_data_show_:active {
            background-color: transparent;
        }

        #border_bottom_ele_slide {
            width: calc(100% / 4);
            bottom: 0px;
            border-radius: 24px;
            height: 5px;
            background-color: #0a58ca;
            transition: transform 0.2s linear 0s;
            transform: translateX(0%);
        }

        .style_post_any {
            /* margin: 20px 0; */
            padding: 10px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 6px 1px #000;
            transition: transform 0.2s linear 0s;
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

        #show_post_modal_ {
            border-radius: 16px;
            background-color: #e4e6eb;
            padding: 10px 15px;
            user-select: none;
            cursor: pointer;
            transition: background-color 0.1s linear 0s;
        }

        #profile_side__img_text,
        .profile___text_ {
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

        .user_name_span {
            font-weight: 600;
            color: #000;
            text-decoration: underline solid transparent;
            transition: text-decoration 0.2s linear 0s;
        }

        .user_time_icon a {
            color: #000;
            font-size: 12px;
            text-decoration: underline solid transparent;
            transition: text-decoration 0.2s linear 0s;
        }

        .user_time_icon i {
            font-size: 12px;
        }

        .rection__emoji_row {
            border-top: 1px solid #acaeb3;
            user-select: none;
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

        .rection___img {
            /* width: 50px; */
            /* min-width: 50px; */
            max-width: 100px;
            background-color: #d7dce2;
            padding: 4px 8px;
            border-radius: 14px;
            margin: 8px 4px;
        }

        .rection___img img {
            width: 20px;
            height: 20px;
            margin-right: 6px;
        }

        .rection___text {
            background-color: #000000;
            padding: 4px 9px;
            border-radius: 10px;
            color: #fff;
        }

        .style_border_add {
            border-top: 1px solid #acaeb3;
            /* border-bottom: 1px solid #acaeb3; */
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

        .like_div {
            position: relative;
            background-color: transparent;
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

        .like_div:hover,
        .comment_div:hover {
            background-color: #c5bebe74;
        }

        /* .show_post_modal_2 {
            border-radius: 16px;
            background-color: #ced0d3;
            padding: 10px 15px;
            outline: none;
            border: none;
        } */

        .post__mess_style img {
            width: 24px;
            height: 24px;
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

        #friends_col,
        #photos_col,
        #videos_col {
            /* border: 1px solid; */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            /* padding: 2px; */
            /* overflow-y: auto; */
            border-radius: 10px;
            /* margin-bottom: 11px; */
            width: 100%;
            /* margin: 50px auto; */
            background-color: #fff;
        }

        .photos_inner_ele,
        .videos_inner_ele {
            width: 23%;
            margin: 8px;
            position: relative;
        }

        #photos_col img,
        .videos_inner_ele video {
            width: 100%;
            height: 168.5px;
            cursor: pointer;
            border-radius: 10px;
            object-fit: cover;
            object-position: center;
            border: 1px solid #000;
            transition: transform 0.2s linear 0s;
        }

        #photos_col img:hover,
        .videos_inner_ele video:hover {
            transform: scale(1.05);
        }

        .user_photos_delete_ele,
        .user_videos_delete_ele,
        .post_delete_ele {
            width: 32px;
            height: 32px;
            user-select: none;
            background-color: #000000e0;
            border-radius: 50%;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            box-shadow: 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff;
        }

        .user_photos_delete_ele span,
        .user_videos_delete_ele span,
        .post_delete_ele span {
            font-size: 20px;
        }

        .show_friends_block {
            /* width: 23%; */
            width: 18%;
            /* max-width: 330px; */
            display: flex;
            align-items: center;
            flex-direction: column;
            /* justify-content: space-between; */
            border: 1px solid #000;
            border-radius: 10px;
            margin: 10px;
            box-shadow: 0px 0px 4px 1px #000, 0px 0px 4px 1px #fff, 0px 0px 4px 1px #000;
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            /* background-color: #9c6129; */
            background-color: #56422f;
            transition: transform 0.2s linear 0s;
        }

        .show_friends_block:hover {
            color: #fff;
            transform: scale(1.05);
        }

        .show_friends_block img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            object-position: top;
            border-radius: 10px 10px 0px 0px;
            border: 1px solid #787878;
        }
        .unfriend_btn {
            margin: 12px 0px 18px 0px;
            /* box-shadow: none; */
            transition: transform 0.12s linear 0s;
            font-weight: 600;
            box-shadow: 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff !important;
        }
        .unfriend_btn:hover {
            transform: scale(1.1);
        }
        .icon_unfriend_f {
            font-size: 20px;
            margin-right: 8px;
        }
        .user_profile_img_text {
            width: 100%;
            height: 160px;
            background: #0d6efd;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px 10px 0px 0px;
            font-weight: 700;
            color: #fff;
            font-size: 140px;
        }

        #friends_m_col,
        #photos_m_col,
        #videos_m_col {
            padding: 5px 0px 10px 0px;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 4px 2px #000;
        }

        .friends__name {
            /* margin-left: 13px; */
            margin: 0px auto;
            padding: 6px;
        }

        #cover_img_ele,
        #profile_img_ele {
            display: none;
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
        #text_post .emojionearea .emojionearea-picker.emojionearea-picker-position-top {
            /* top: 366px !important; */
            left: 0px !important;
            transform: translate(0%, -100%) !important;
        }
        #text_post .emojionearea .emojionearea-picker {
            background: rgb(255, 255, 255) !important;
            box-shadow: 0px 0px 4px 2px #000 !important;
        }
        #text_post {
            margin-top: 30px;
            margin-bottom: 20px;
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
        #text_post .emojionearea-editor:empty:before {
            color: #000000;
        }
        /* comment style start */
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
        /* comment style end */
        .post__mess_style {
            word-break: break-word;
        }
        @media screen and (max-width:1200px) {
            .show_friends_block {
                width: 22%;
            }
        }
        @media screen and (max-width:992px) {
            .show_friends_block {
                width: 30%;
            }

            .photos_inner_ele,
            .videos_inner_ele {
                width: 31%;
            }
        }

        @media screen and (max-width:768px) {
            .show_friends_block {
                width: 46%;
            }

            .photos_inner_ele,
            .videos_inner_ele {
                width: 46%;
            }
        }
        @media screen and (max-width:524px) {
            .show_friends_block {
                width: 45%;
            }
        }
        @media screen and (max-width:500px) {
            #text_post .emojionearea-editor {
                height: 39.5px !important;
            }
        }
        @media screen and (max-width:480px) {
            .photos_inner_ele,
            .videos_inner_ele {
                width: 80%;
            }
            #photos_col img,
            .videos_inner_ele video {
                height: 100%;
            }
        }
        @media screen and (max-width:468px) {
            .friends__name {
                font-size: 14px;
            }
        }
        @media screen and (max-width:440px) {
            .show_friends_block {
                width: 90%;
            }
            .user_profile_img_text {
                height: 100%;
            }
            .show_friends_block img {
                height: 100%;
            }
            .friends__name {
                font-size: 16px;
            }

            .photos_inner_ele,
            .videos_inner_ele {
                width: 92%;
            }
        }

        @media screen and (max-width:370px) {
            .photos_inner_ele,
            .videos_inner_ele {
                width: 94%;
            }
        }

        @media screen and (max-width: 578px) {
            .res_ele {
                width: 96% !important;
            }
            #user_all_data {
                width: 96%;
            }
        }

        @media screen and (max-width:768px) {
            #cover_photo_text__ {
                display: none;
            }

            #cover_photo_change_btn svg {
                margin-right: 0px;
            }
        }

        @media screen and (max-width:576px) {
            #cover_image {
                border-radius: 0px;
            }
        }
        @media screen and (max-width:480px) {
            .like_, .comment_,.like_ span {
                font-size: 17px;
            }
            .like_ img {
                width: 20px;
                height: 20px;
            }

        }

        @media screen and (max-width:462px) {
            #profile__name_ {
                font-size: 26px;
            }
        }

        @media screen and (max-width:415px) {
            .user_data_show_ {
                font-size: 15px;
            }
        }

        @media screen and (max-width:401px) {
            #profile__name_ {
                font-size: 22px;
            }
        }

        @media screen and (max-width:342px) {
            #profile__name_ {
                font-size: 18px;
            }

            #total_friends {
                font-size: 18px;
            }
        }
    </style>

</head>

<body>
    <div id="loading_animation_page">
        <div id="loading_ani_p">
            <!-- <img src="img/icon/loading_icon.svg"> -->
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
    require_once "profile_header.php";
    ?>

    <!-- slide bar Start -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="slide_bar_m" aria-labelledby="slide_bar_mLabel">
        <div class="offcanvas-header d-flex align-items-center justify-content-end">
            <!-- <h5 class="offcanvas-title" id="slide_bar_mLabel">Offcanvas</h5> -->
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container m-0 p-0">
                <?php
                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    $user__id = $_SESSION['user_id'];
                ?>
                <a href="profile?uid=<?php echo $user__id; ?>" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav" id="profile__user____img_div_ele">
                            <!-- <img id='profile__user____img_ele' src="img/profile_img/default_image1.jpg" alt=""> -->
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
                                echo "<img id='profile__user____img_ele' src='img/profile_img/$image_name'>";
                            }
                            mysqli_close($conn);
                            ?>
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center"><?php echo $_SESSION['user_name']; ?></div>
                </a>
                <a href="user?page_name=home" class="row justify-content-start p-3 row_ele_style show_all_specific_post">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/home.svg" alt="post">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Post</div>
                </a>
                <!-- <a href="user?page_name=friends" class="row justify-content-start p-3 row_ele_style">
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
                            <img src="img/icon/group.png" alt="Groups">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Groups</div>
                </a> -->
                <a href="user?page_name=watch" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/watch.png" alt="Watch">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Watch</div>
                </a>
                <a href="#" class="row justify-content-start p-3 row_ele_style message_all_user">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/messenger.png" alt="Messenger">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Messenger</div>
                </a>
                <!-- <a href="#" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/pages.png" alt="Pages">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Pages</div>
                </a> -->
            </div>
        </div>
    </div>
    <!-- slide bar end -->

    <div class="container">
        <div class="row">
            <div class="col-12 p-0" id="user_profile_all_img">
                <img id="cover_image" src="img/cover_photo/<?php echo $arr_current_user_details['cover_photo']; ?>" alt="">

                <?php
                if ($login_user_id == $current_user_id) {
                ?>
                    <form id="cover_img_form_ele">
                        <label id="cover_photo_change_btn" for="cover_img_ele">
                            <svg class="gb_kb" enable-background="new 0 0 24 24" focusable="false" height="24" viewBox="0 0 24 24" width="24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M20 5h-3.17L15 3H9L7.17 5H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 14H4V7h16v12zM12 9c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"></path>
                            </svg>
                            <div id="cover_photo_text__">Edit Cover Photo</div>
                        </label>
                        <input type="file" name="cover_img_ele" id="cover_img_ele" accept="image/png, image/jpeg,image/gif">
                    </form>
                <?php
                }
                ?>

                <div id="profile_photo">
                    <?php
                    $current_user_profile_img = "";
                    if ($arr_current_user_details['image_type'] == "text") {
                        $ch = strtoupper(substr(explode(" ", $arr_current_user_details['user_name'])[0], 0, 1));
                        $current_user_profile_img = "<div id='profile__text_'>$ch</div>";
                    } else {
                        $current_user_profile_img = "<img id='user__profile__image' src='img/profile_img/{$arr_current_user_details['profile_image']}'>";
                    }
                    echo $current_user_profile_img;
                    ?>
                    <?php
                    if ($login_user_id == $current_user_id) {
                    ?>
                        <form id="profile_img_form_ele">
                            <label id="profile_img_change_btn" for="profile_img_ele">
                                <svg class="gb_kb" enable-background="new 0 0 24 24" focusable="false" height="24" viewBox="0 0 24 24" width="24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="M20 5h-3.17L15 3H9L7.17 5H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 14H4V7h16v12zM12 9c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"></path>
                                </svg>
                            </label>
                            <input type="file" name="profile_img_ele" id="profile_img_ele" accept="image/png, image/jpeg,image/gif">
                        </form>
                    <?php
                    }
                    ?>
                </div>

            </div>
        </div>
        <div class="row" style="margin-top: 92px;">
            <div class="col-12 p-0 d-flex justify-content-center align-items-center" id="profile__name_"><?php echo $arr_current_user_details['user_name']; ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-12 p-0 d-flex justify-content-center align-items-center" id="total_friends"><?php echo $total_friends; ?></div>
        </div>

        <?php
        if ($login_user_id != $current_user_id) {
            $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$login_user_id AND to_user_id=$current_user_id)";
            $conn = connected() or die("Connection Failed");
            $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
            $action_name = "Add Friend";
            $icon_class_name = "";
            if(mysqli_num_rows($result_request_friend_status) > 0) {
                $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
                $action_name = $arr_request_friend_status['action_name'];
            }

            if($action_name == "Add Friend") {
                $icon_class_name = "bi bi-person-plus";
            }
            else if($action_name == "Cancel Friend Request") {
                $icon_class_name = "bi bi-person-x";
            }
            else if($action_name == "Accept Friend Request") {
                $icon_class_name = "bi bi-person-check";
            }
            else if($action_name == "friends") {
                $icon_class_name = "bi bi-person-check";
            }
        ?>
            <div class="row my-3">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <button class="btn btn-primary active me-2 d-flex justify-content-center align-items-center" id="add_friend_request_btn" data-action_n = '<?php echo $action_name; ?>'>

                        <div class="icon_request_f"><i class='<?php echo $icon_class_name; ?>'></i></div>
                        <div class="friend_request_action_name"><?php echo $action_name; ?></div>

                    </button>
                    <button type="button" class="btn btn-secondary active ms-2 d-flex justify-content-center align-items-center" id="friend_message_btn">
                        <svg viewBox="0 0 28 28" height="20" width="20" fill="currentColor">
                            <path d="M14 2.042c6.76 0 12 4.952 12 11.64S20.76 25.322 14 25.322a13.091 13.091 0 0 1-3.474-.461.956 .956 0 0 0-.641.047L7.5 25.959a.961.961 0 0 1-1.348-.849l-.065-2.134a.957.957 0 0 0-.322-.684A11.389 11.389 0 0 1 2 13.682C2 6.994 7.24 2.042 14 2.042ZM6.794 17.086a.57.57 0 0 0 .827.758l3.786-2.874a.722.722 0 0 1 .868 0l2.8 2.1a1.8 1.8 0 0 0 2.6-.481l3.525-5.592a.57.57 0 0 0-.827-.758l-3.786 2.874a.722.722 0 0 1-.868 0l-2.8-2.1a1.8 1.8 0 0 0-2.6.481Z"></path>
                        </svg>
                        <div>Message</div>
                    </button>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="row mb-5">
            <div class="col-12 p-0 d-flex justify-content-center align-items-center">
                <div id="user_all_data" class="d-flex align-items-center position-relative">
                    <div id="border_bottom_ele_slide" class="position-absolute start-0"></div>
                    <div id="user_all_post_btn" class="user_data_show_">Post</div>
                    <div id="user_all_friend_btn" class="user_data_show_">Friends</div>
                    <div id="user_all_Photo_btn" class="user_data_show_">Photos</div>
                    <div id="user_all_video_btn" class="user_data_show_">Videos</div>
                </div>
            </div>
        </div>

        <div class="row m-0 justify-content-center" id="all_insert_element">

                    <!-- <div class='col-12' id='friends_m_col'>
                        <div class='row m-0 bg-white p-2' style='border-radius: 10px;'>
                            <div class='col-12 fw-bold fs-5' style='color: #000;'>Friends : </div>
                        </div>
                        <div class='row m-0'>
                            <div class='col-12 p-0' id='friends_col'>
                                <a href='profile?uid=' target='_blank' class='show_friends_block'>
                                    <div class='user_profile_img_text'>T</div>
                                    <div class='friends__name'>Tathagata Bandyopadhyay1</div>
                                    <button class="btn btn-primary active d-flex justify-content-center align-items-center unfriend_btn" data-action_n="">
                                        <div class="icon_unfriend_f"><i class="bi bi-person-check"></i></div>
                                        <div class="unfriend__action_name">friends</div>
                                    </button>
                                </a>
                                <a href='profile?uid=' target='_blank' class='show_friends_block'>
                                    <img src='img/profile_img/default_image1.jpg'>
                                    <div class='friends__name'>Jonty Bandyopadhyay</div>
                                    <button class="btn btn-primary active d-flex justify-content-center align-items-center unfriend_btn" data-action_n="">
                                        <div class="icon_unfriend_f"><i class="bi bi-person-check"></i></div>
                                        <div class="unfriend__action_name">friends</div>
                                    </button>
                                </a>
                                <a href='profile?uid=' target='_blank' class='show_friends_block'>
                                    <img src='img/profile_img/default_image1.jpg'>
                                    <div class='friends__name'>demo Bandyopadhyay</div>
                                    <button class="btn btn-primary active d-flex justify-content-center align-items-center unfriend_btn" data-action_n="">
                                        <div class="icon_unfriend_f"><i class="bi bi-person-check"></i></div>
                                        <div class="unfriend__action_name">friends</div>
                                    </button>
                                </a>

                            </div>
                        </div>
                    </div> -->
                    <!-- <div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Friend Found</div> -->

        </div>
    </div>

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

    <?php
        if ($login_user_id == $current_user_id) {
            ?>
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
                                            if(!isset($_SESSION)) {
                                                session_start();
                                            }
                                            $user__id = $_SESSION['user_id'];
                                            require_once "conn.php";
                                            $conn = connected() or die("Connection Failed");
                                            $sql = "SELECT image_type FROM user WHERE user_id='$user__id'";
                                            $result = mysqli_query($conn,$sql) or die("Query Failed");
                                            $image_type = "";
                                            if(mysqli_num_rows($result) > 0) {
                                                while($arr = mysqli_fetch_assoc($result)) {
                                                    $image_type = $arr["image_type"];
                                                }
                                            }
                                            if($image_type == "text") {
                                                $ch = strtoupper(substr(explode(" ",$_SESSION['user_name'])[0],0,1));
                                                echo "<div id='profile_side__img_'>$ch</div>";
                                            }
                                            else  {
                                                $sql2 = "SELECT profile_image FROM user WHERE user_id='$user__id'";
                                                $result2 = mysqli_query($conn,$sql2) or die("Query Failed");
                                                $image_name = "";
                                                if(mysqli_num_rows($result2) > 0) {
                                                    while($arr = mysqli_fetch_assoc($result2)) {
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
            <?php
        }
    ?>

    <!-- Message modal -->
    <?php require "message_modal.php" ?>

    <!-- Edit Profile modal -->
    <?php require "edit_profile_modal.php" ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- sweetalert2 js -->
    <script src="js/sweetalert2.js"></script>

    <!-- floating_script js -->
    <!-- <script src="js/floating_script.js"></script> -->

    <!-- emoji script -->
    <script src="js/emoji_script.js"></script>

    <!-- user_header.js -->
    <script src="js/user_header.js"></script>

    <!-- message_modal.js -->
    <script src="js/message_modal.js"></script>

    <!-- edit_profile_modal.js -->
    <script src="js/edit_profile_modal.js"></script>

    <script>
        $(document).ready(function(){
            var current_user_id = <?php echo $current_user_id;?>;
            var clear_set_interval_check_friend_request_status = "";
            function all_post_get_in_user() {

                $("#border_bottom_ele_slide").css("transform", "translateX(0%)");

                $("#user_all_post_btn").addClass("active_user_data_show_");
                $("#user_all_friend_btn").removeClass("active_user_data_show_");
                $("#user_all_Photo_btn").removeClass("active_user_data_show_");
                $("#user_all_video_btn").removeClass("active_user_data_show_");

                $.ajax({
                    url:"ajax_request/get_current_user_all_post",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data:{current_user_id:current_user_id},
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.user_search_status == true) {
                                if(data.post_data == true) {
                                    $("#all_insert_element").html(data.post_data_t);
                                }
                                else {
                                    $("#all_insert_element").html(data.post_data);
                                }
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.user_search_status
                                });
                            }
                        }
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });
            }
            function all_friend_get_in_user() {

                $("#border_bottom_ele_slide").css("transform", "translateX(100%)");

                $("#user_all_post_btn").removeClass("active_user_data_show_");
                $("#user_all_friend_btn").addClass("active_user_data_show_");
                $("#user_all_Photo_btn").removeClass("active_user_data_show_");
                $("#user_all_video_btn").removeClass("active_user_data_show_");

                $.ajax({
                    url:"ajax_request/get_current_user_all_friend",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data:{current_user_id:current_user_id},
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.user_search_status == true) {
                                $("#all_insert_element").html(data.friend_data);
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.user_search_status
                                });
                            }
                        }
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });
            }
            function all_photo_get_in_user() {

                $("#border_bottom_ele_slide").css("transform", "translateX(200%)");

                $("#user_all_post_btn").removeClass("active_user_data_show_");
                $("#user_all_friend_btn").removeClass("active_user_data_show_");
                $("#user_all_Photo_btn").addClass("active_user_data_show_");
                $("#user_all_video_btn").removeClass("active_user_data_show_");
                
                $.ajax({
                    url:"ajax_request/get_current_user_all_photo",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data:{current_user_id:current_user_id},
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.user_search_status == true) {
                                if(data.photo_status == true) {
                                    $("#all_insert_element").html(data.photo_data);
                                }
                                else {
                                    $("#all_insert_element").html(data.photo_status);
                                }
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.user_search_status
                                });
                            }
                        }
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });
            }
            function all_video_get_in_user() {

                $("#border_bottom_ele_slide").css("transform", "translateX(300%)");

                $("#user_all_post_btn").removeClass("active_user_data_show_");
                $("#user_all_friend_btn").removeClass("active_user_data_show_");
                $("#user_all_Photo_btn").removeClass("active_user_data_show_");
                $("#user_all_video_btn").addClass("active_user_data_show_");

                $.ajax({
                    url:"ajax_request/get_current_user_all_video",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data:{current_user_id:current_user_id},
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.user_search_status == true) {
                                if(data.video_status == true) {
                                    $("#all_insert_element").html(data.video_data);
                                }
                                else {
                                    $("#all_insert_element").html(data.video_status);
                                }
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.user_search_status
                                });
                            }
                        }
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });
            }
            <?php
                if($page_name == "post") {
                    ?>all_post_get_in_user();<?php
                }
                else if($page_name == "friend") {
                    ?>all_friend_get_in_user();<?php
                }
                else if($page_name == "photo") {
                    ?>all_photo_get_in_user();<?php
                }
                else if($page_name == "video") {
                    ?>all_video_get_in_user();<?php
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
                    $current_url = "$webcite_ssl_or_not://{$_SERVER['SERVER_NAME']}".explode(".",$_SERVER['PHP_SELF'])[0]."?uid=$current_user_id&page_name="; 
                ?>
                var current_url = "<?php echo $current_url; ?>"+page_name;
                history.pushState(null, '', current_url)
            }

            $("#user_all_post_btn").click(function() {
                all_post_get_in_user();
                page_change("post");
                
            });
            $("#user_all_friend_btn").click(function() {
                all_friend_get_in_user();
                page_change("friend");
            });
            $("#user_all_Photo_btn").click(function() {
                all_photo_get_in_user();
                page_change("photo");
            });
            $("#user_all_video_btn").click(function() {
                all_video_get_in_user();
                page_change("video");
            });

            $("#side_bar_show_btn").click(function() {
                $("#side_bar_show_btn").tooltip('hide');
                $('#slide_bar_m').offcanvas('show');
            });

            var video_play_state_in_modal = 0;
            var post_privacy = "public";
            $(document).on("click", ".img_style_post_set img", function(event) {
                var ele = $(this).clone();
                $("#image_zoom_modal").modal("show");
                $("#image_zoom_modal_col").html(ele);
            });
            $(document).on("click", "video", function(event) {
                event.preventDefault();
                // document.querySelectorAll(".img_style_post_set video").pause();
                for (var ele_video of document.querySelectorAll("video")) {
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

            // user photo zoom
            $(document).on("click", "#photos_col img", function(event) {
                var ele = $(this).clone();
                $("#image_zoom_modal").modal("show");
                $("#image_zoom_modal_col").html(ele);
            });

            // user stop video
            for (var ele_video of document.querySelectorAll(" video")) {
                ele_video.addEventListener("play", function() {
                    for (var ele_video2 of document.querySelectorAll("video")) {
                        if (this != ele_video2) {
                            ele_video2.pause();
                        }
                    }
                })
            }

            // rection
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

            <?php 
                if ($login_user_id == $current_user_id) {
            ?>
            $("#post_mess").emojioneArea({
                tonesStyle: "radio",
                // searchPosition: "bottom",
                pickerPosition: 'top',
                // filtersPosition: "bottom",
                placeholder: "Type a message",
                // useInternalCDN: true,
            });

            setTimeout(function() {
                $(".emojionearea-button").css("order", "-100");
                $(".emojionearea-button").css("margin-right", "16px");
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

            $(document).on("click","#show_post_modal_",function() {
                $("#container_main_madal").css("transform", "scale(1)");
                $("body").css("overflow","hidden");
            });
            $("#hide_post_modal_btn").click(function() {
                $("#container_main_madal").css("transform", "scale(0)");
                $("body").css("overflow","auto");
            });
            $("#container_main_madal .container_post").click(function(event) {
                event.stopImmediatePropagation();
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

            $("#privacy_option_val").click(function(){
                $(".container_post .wrapper_post .post").css("transform","translateX(-100%)");
                $(".container_post .wrapper_post .audience").css("transform","translateX(-100%)");
            });
            $(".container_post .wrapper_post .audience .arrow-back").click(function(){
                $(".container_post .wrapper_post .post").css("transform","translateX(0%)");
                $(".container_post .wrapper_post .audience").css("transform","translateX(0%)");
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
                } else {
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

                $.ajax({
                    url: "ajax_request/login_user_post_set_ajax",
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
                        } 
                        else {
                            if (data.post_message != true) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: '<span style="color:red;font-size: 20px;font-weight: 600;">' + data.post_message + '<span>'
                                });
                                document.querySelector("#text_post .emojionearea-editor").innerHTML = "";
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
                                    $("body").css("overflow","auto");

                                },1000);
                                // $("#img_style_post_id").parent().css("display","none");
                                $("#post_image").val("");
                                // $("#area_w").css("min-height",$("body").outerHeight(true));
                                // console.log(data.obj);
                            }
                            // $(window).scrollTop(0);
                            if(post_fadeout_status == 0) {
                                $("#post_btn #sp_1").remove();
                                $("#loading_animation_page").fadeOut("fast");
                            }
                        }
                        document.getElementById("post_btn").disabled = false;
                    }
                });
            });

            var body_width_ = $("body").css("width");
            body_width_ = Math.floor(Number(body_width_.substr(0,(body_width_.length)-2)));
            if(body_width_ > 500) {
                $(document).on("keyup","#text_post .emojionearea-editor",function(){
                    var h_e = $("#text_post .emojionearea").css("height");
                    // console.log(h_e);
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


            $("#cover_img_ele").change(function() {
                $("#cover_img_form_ele").submit();
            });
            $("#cover_img_form_ele").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "ajax_request/user_cover_img_ajax",
                    type: "POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    dataType: "json",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong'
                            });
                        } 
                        else {
                            if(data.cover_image_select_state == true) {
                                if(data.cover_image_extension_status == true) {
                                    document.getElementById("cover_image").src = "img/cover_photo/"+data.cover_photo_name;
                                }
                                else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: data.cover_image_extension_status
                                    });
                                }
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.cover_image_select_state
                                });
                            }
                        }
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });
            });
            $("#profile_img_ele").change(function() {
                $("#profile_img_form_ele").submit();
            });
            $("#profile_img_form_ele").submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    url: "ajax_request/user_photo_img_ajax",
                    type: "POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    dataType: "json",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong'
                            });
                        } 
                        else {
                            if(data.profile_image_select_state == true) {
                                if(data.profile_image_extension_status == true) {
                                    if(data.previous_profile_photo_type == "text") {
                                        $("#profile__text_").remove();
                                        $("#text_image").remove();
                                        $("#profile_side__img_").remove();
                                        $("#profile_side__img_text").remove();
                                        $(".profile___text_").remove();
                                        $(".user_profile_ img").remove();
                                        $("#text_profile_image").remove();

                                        var profile_ele = "<img id='user__profile__image' src='img/profile_img/"+data.profile_photo_name+"'>";
                                        var profile_ele_r = "<img id='profile__img_r' src='img/profile_img/"+data.profile_photo_name+"'>";
                                        var profile_img_ele = "<img id='profile__user____img_ele' src='img/profile_img/"+data.profile_photo_name+"'>";
                                        var profile_image_ele = "<img src='img/profile_img/"+data.profile_photo_name+"'>";
                                        $("#profile_photo").prepend(profile_ele);
                                        $("#profile_img").prepend(profile_ele_r);
                                        $("#profile__user____img_div_ele").prepend(profile_img_ele);
                                        $(".user_profile_").prepend(profile_image_ele);
                                        $("#profile_image_ele").prepend(profile_image_ele);
                                    }
                                    else {
                                        document.getElementById("user__profile__image").src = "img/profile_img/"+data.profile_photo_name;
                                        document.getElementById("profile__img_r").src = "img/profile_img/"+data.profile_photo_name;
                                        document.getElementById("profile__user____img_ele").src = "img/profile_img/"+data.profile_photo_name;
                                        $(".user_profile_ img").attr("src","img/profile_img/"+data.profile_photo_name);
                                        $("#profile_image_ele img").attr("src","img/profile_img/"+data.profile_photo_name);
                                    }
                                }
                                else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: data.profile_image_extension_status
                                    });
                                }
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.profile_image_select_state
                                });
                            }
                        }
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });
            });
            $(document).on("click",".post_delete_ele",function(){
                var post_id = $(this).attr("data-p");
                var main_parent_ele = $(this).parents(".style_post_any");
                $.ajax({
                    url:"ajax_request/delete_post",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data:{post_id:post_id},
                    dataType:"json",
                    success:function(data) {
                        $("#loading_animation_page").fadeOut("fast");
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.success == 1) {
                                $(main_parent_ele).fadeOut("fast",function(){
                                    $(main_parent_ele).remove();
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Post Deleted Successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                if(data.post_c_status != true) {
                                    $("#add_post_data").html(data.post_c_status);
                                }
                            }
                        }
                    }
                });
            });
            $(document).on("click",".user_photos_delete_ele",function(){
                var post_id = $(this).attr("data-p");
                var img_name = $(this).attr("data-img");
                var main_parent_ele = $(this).parent();
                
                $.ajax({
                    url:"ajax_request/delete_photo",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data:{
                        post_id:post_id,
                        img_name:img_name
                    },
                    dataType:"json",
                    success:function(data) {
                        $("#loading_animation_page").fadeOut("fast");

                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.success == 1) {
                                $(main_parent_ele).fadeOut("fast",function(){
                                    $(main_parent_ele).remove();
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Photo Deleted Successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                if(data.img_count != true) {
                                    $("#photos_m_col").html(data.img_count);
                                }
                            }
                        }
                    }
                });
            });
            $(document).on("click",".user_videos_delete_ele",function(){
                var post_id = $(this).attr("data-p");
                var video_name = $(this).attr("data-video");
                var main_parent_ele = $(this).parent();
                
                $.ajax({
                    url:"ajax_request/delete_video",
                    type:"POST",
                    beforeSend: function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    data:{
                        post_id:post_id,
                        video_name:video_name
                    },
                    dataType:"json",
                    success:function(data) {
                        $("#loading_animation_page").fadeOut("fast");

                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.success == 1) {
                                $(main_parent_ele).fadeOut("fast",function(){
                                    $(main_parent_ele).remove();
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Video Deleted Successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                if(data.video_count != true) {
                                    $("#videos_m_col").html(data.video_count);
                                }
                            }
                        }
                    }
                });
            });


            $(document).on("click",".unfriend_btn",function(event){
                event.preventDefault();
                var parent_ele = $(this).parent();
                var action_name = $(this).attr("data-action_n");
                var f_user_id = $(this).attr("data-c");
                var icon_unfriend_f_ele = $(this).children(".icon_unfriend_f");
                var current_ele = this;
                
                $(parent_ele).fadeOut("fast",function(){
                    $(parent_ele).remove();
                });

                $.ajax({
                    url:"ajax_request/remove_friend",
                    type:"POST",
                    beforeSend:function(){
                        $("#loading_animation_page").fadeIn("fast");
                        // $(icon_unfriend_f_ele).html("<img src='img/icon/friend_request_load.svg'>");
                        current_ele.disabled = true;
                    },
                    data:{
                        action_name:action_name,
                        current_user_id:f_user_id,
                        friend_list:"friend_list"
                    },
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.current_user_search_status == true) {
                                if (data.error == 1) {
                                    $("#total_friends").html(data.total_no_of_friend+" friends");
                                    if(data.total_no_of_friend_status == true) {
                                        $(parent_ele).fadeOut("fast",function(){
                                            $(parent_ele).remove();
                                        });
                                    }
                                    else {
                                        $("#all_insert_element").html(data.total_no_of_friend_status);
                                    }
                                    $("#loading_animation_page").fadeOut("fast");
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Friend Removed Successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.current_user_search_status
                                });
                            }
                        }
                    }
                });
            });
            <?php
            }
            ?>

            $(document).on("click",".like_div",function(event){
                var last_child = this.lastElementChild;
                var sibling_ele = this.parentElement.previousElementSibling;
                var post_id = $(sibling_ele).attr("data-p");
                var current_ele = this;
                var first_child = this.firstElementChild;
                var first_child_f = first_child.firstElementChild;
                // console.log(first_child);
                // console.log(first_child_f);
                // console.log(sibling_ele);
                // console.log(post_id);
                $.ajax({
                    url:"ajax_request/like_ajax",
                    type:"POST",
                    data : {
                        post_id : post_id
                    },
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.rection_state == true) {
                                $(first_child_f).remove();
                                $(first_child).prepend("<img src='img/rection_emoji_icon/like.svg'>");
                                $(first_child.lastElementChild).html("Like");
                            }
                            else {
                                $(first_child_f).remove();
                                $(first_child).prepend("<i class='far fa-thumbs-up'></i>");
                                $(first_child.lastElementChild).html("Like");
                            }
                            if(data.total_rection_count > 0) {
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
                        if($(current_ele).children(".reaction-box").length == 1) {
                            $(current_ele).children(".reaction-box").remove();
                        }
                    }
                });
            });

            $(document).on("click",".reaction-box",function(event){
                event.stopPropagation();
            });
            $(document).on("click",".reaction-icon label",function(event){
                event.stopPropagation();
            });

            $(document).on("click",".reaction-icon",function(event){
                var rection_type = ($(this).attr("class")).split(" ")[1];
                var sibling_ele = this.parentElement.parentElement.parentElement.previousElementSibling;
                var post_id = $(sibling_ele).attr("data-p");

                var previous_ele_sibling = this.parentElement.previousElementSibling;
                var show_icon_ele = previous_ele_sibling.firstElementChild;
                var show_icon_text = previous_ele_sibling.lastElementChild;

                var current_ele = this;
                
                // console.log(sibling_ele);
                $.ajax({
                    url:"ajax_request/user_rection_post_ajax",
                    type:"POST",
                    data : {
                        post_id : post_id,
                        rection_type : rection_type
                    },
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.total_rection_count > 0) {
                                $(sibling_ele).fadeIn();
                            }
                            else {
                                $(sibling_ele).fadeOut();
                            }

                            if(data.rection_type == "like") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/like.svg'>");
                                $(show_icon_text).html("Like");
                            }
                            else if(data.rection_type == "love") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/love.svg'>");
                                $(show_icon_text).html("Love");
                            }
                            else if(data.rection_type == "care") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/care.svg'>");
                                $(show_icon_text).html("Care");
                            }
                            else if(data.rection_type == "haha") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/haha.svg'>");
                                $(show_icon_text).html("Haha");
                            }
                            else if(data.rection_type == "wow") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/wow.svg'>");
                                $(show_icon_text).html("Wow");
                            }
                            else if(data.rection_type == "sad") {
                                $(show_icon_ele).remove();
                                $(previous_ele_sibling).prepend("<img src='img/rection_emoji_icon/sad.svg'>");
                                $(show_icon_text).html("Sad");
                            }
                            else if(data.rection_type == "angry") {
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
                        if($(current_ele.parentElement).children(".reaction-box").length == 1) {
                        }
                    }
                });
                // console.log(show_icon_ele);
            });

            $("#search__friend").on("input",function() {
                var search_value = $(this).val();

                $.ajax({
                    url:"ajax_request/search_friend",
                    type:"POST",
                    data:{search_value:search_value},
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            $("#search_result_ele").html(data.search_result);
                        }
                    }
                });
            });

            <?php
            if ($login_user_id != $current_user_id) {
            ?>
            $(document).on("click","#add_friend_request_btn",function(){
                var action_name = $(this).attr("data-action_n");
                var current_ele = this;
                
                $.ajax({
                    url:"ajax_request/friend_request",
                    type:"POST",
                    beforeSend:function(){
                        $(".icon_request_f").html("<img src='img/icon/friend_request_load.svg'>");
                        document.getElementById("add_friend_request_btn").disabled = true;
                    },
                    data:{
                        action_name:action_name,
                        current_user_id:current_user_id
                    },
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else {
                            if(data.current_user_search_status == true) {
                                if (data.error == 1) {
                                    $(".icon_request_f").html(data.icon_request_ele);
                                    $(".friend_request_action_name").html(data.action_name);
                                    $(current_ele).attr("data-action_n",data.action_name);
                                    $("#total_friends").html(data.total_no_of_friend);
                                }
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.current_user_search_status
                                });
                            }
                        }
                        document.getElementById("add_friend_request_btn").disabled = false;
                    }
                });
            });
            check_friend_request_status_f();
            function check_friend_request_status_f() {
                clear_set_interval_check_friend_request_status = setInterval(function(){
                    $.ajax({
                        url:"ajax_request/check_friend_request_status",
                        type:"POST",
                        beforeSend:function(){
                            clearInterval(clear_set_interval_check_friend_request_status);
                        },
                        data:{
                            current_user_id:current_user_id
                        },
                        dataType:"json",
                        success:function(data) {
                            if (data.error == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Something Went Wrong | Reload The Page'
                                });
                            }
                            else {
                                if(data.current_user_search_status == true) {
                                    $("#add_friend_request_btn").attr("data-action_n",data.action_name);
                                    $("#add_friend_request_btn").html(data.c_u_f_s);
                                    $("#total_friends").html(data.total_friends);
                                    check_friend_request_status_f();
                                }
                                else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: data.current_user_search_status
                                    });
                                }
                            }
                        }
                    });
                },1000);
            }


            <?php
            }
            ?>

            $(document).on("mouseup",".notifications_child",function(event){
                var left_notafication_child_ele = $(this).children(".left_notafication_ele");
                var right_notafication_child_ele = $(this).children(".right_notafication_ele");
                var nid = $(this).attr("data-n");
                $(right_notafication_child_ele).remove();
                $(left_notafication_child_ele).css("width","98%");
                $.ajax({
                    url:"ajax_request/notafication_read_ajax",
                    type:"POST",
                    data:{nid:nid},
                    dataType:"json",
                    success:function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | Reload The Page'
                            });
                        }
                        else if(data.error == 1){
                            if(data.no_of_notafication >0) {
                                $("#no_of_notafication").css("display","block");
                            }
                            else {
                                $("#no_of_notafication").css("display","none");
                            }
                            $("#inner_no_of_notafication").html(data.no_of_notafication);
                            $(right_notafication_child_ele).remove();
                            $(left_notafication_child_ele).css("width","98%");
                        }
                    }
                });
            });
            $(document).on("mouseenter", ".user_time_icon i,.user_time_icon a", function() {
                $(this).tooltip('show');
            });
            $(document).on("click",".user_time_icon a",function(event){
                event.preventDefault();
            });

            $(document).on("click", ".message_all_user", function(event) {
                event.preventDefault();
                $('#slide_bar_m').offcanvas('hide');
                $("#message_modal").modal("show");
                get_all_friend_in_message_modal();
            });

            $(document).on("click","#friend_message_btn",function(){

                $.ajax({
                    url:"ajax_request/get_click_friend_details_in_messsage",
                    type:"POST",
                    data:{
                        friend_user_id:current_user_id
                    },
                    beforeSend:function() {
                        $("#loading_animation_page").fadeIn("fast");
                    },
                    dataType:"json",
                    success:function(data){
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Went Wrong | User Not Valid | Reload The Page'
                            });
                        }
                        else {
                            $("#message_modal").modal("show");
                            $("#message_user_ele").css("transform","translateX(-100%)");
                            $("#message_details_ele").css("transform","translateX(-100%)");
                            
                            // get_c_f_login_status(current_user_id);

                            $(".message_user_details_middle").html(data.message__data);

                            current_user_message_data_id = data.current_user_message_data_id;
                            console.log(current_user_message_data_id);

                            $(".user_details_in_message__top_img_text_ele").html(data.friend_profile_image);
                            $(".user_details_in_message__top_friend_name").html(data.friend_user_name);
                            $(".user_details_in_message__top_friend_name").attr("data-current_fid",data.friend_user_id);
                            $(".user_details_in_message__top_friend_online_status").html(data.last_login_status);

                            check_new_message_in_other_user();

                            setTimeout(function(){
                                var child_ele = $(".message_user_details_middle").children();
                                var child_ele_height = 0;
                                for (c_ele of child_ele) {
                                    child_ele_height += Number(($(c_ele).css("height")).split("p")[0]);
                                }
                                $(".message_user_details_middle").scrollTop(child_ele_height + 100000000000);
                            },500)
                        }
                        $("#loading_animation_page").fadeOut("fast");
                    }
                });
            });
        });
        </script>
        <!-- comment -->
        <script src="js/comment_script.js"></script>

</body>

</html>