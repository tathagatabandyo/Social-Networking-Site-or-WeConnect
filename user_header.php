<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["user_email"])) {
    header("Location:index");
}
?>
<div id="navbar" class="d-flex justify-content-between align-items-center bg-white position-sticky top-0 start-0">
    <div id="left_div" class="d-flex align-items-center position-relative">
        <div id="side_bar_show_btn" data-bs-toggle="tooltip" data-bs-placement="right" title="Menu Bar">
            <span id="side_bar_show_icon">
                <svg viewBox="0 0 28 28" class="a8c37x1j ms05siws l3qrxjdp b7h9ocf4 py1f6qlh" fill="currentColor" height="28" width="28">
                    <path d="M23.5 4a1.5 1.5 0 110 3h-19a1.5 1.5 0 110-3h19zm0 18a1.5 1.5 0 110 3h-19a1.5 1.5 0 110-3h19zm0-9a1.5 1.5 0 110 3h-19a1.5 1.5 0 110-3h19z">
                    </path>
                </svg>
            </span>
        </div>
        <!-- left bar start  -->
        <div id="left_slide_l_bar">
            <div class="container m-0 p-0">
                <a href="profile?uid=<?php echo $_SESSION['user_id']; ?>" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
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
                                    echo "<div id='profile_side__img'>$ch</div>";
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
                <a href="#" class="row justify-content-start p-3 row_ele_style show_friend_in_user">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/friends.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Friends</div>
                </a>
                <!-- <a href="#" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/group.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Groups</div>
                </a> -->
                <a href="#" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/pages.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Pages</div>
                </a>
                <a href="#" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/messenger.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Messenger</div>
                </a>
                <a href="#" class="row justify-content-start p-3 row_ele_style">
                    <div class="col-2 d-flex justify-content-start">
                        <span class="icon_at_nav">
                            <img src="img/icon/watch.png" alt="Friends">
                        </span>
                    </div>
                    <div class="col-10 d-flex align-items-center">Watch</div>
                </a>
            </div>
        </div>
        <!-- left bar end  -->
        <div id="website_icon">
            <a href="user" class="d-flex align-items-center justify-content-center ms-2">
                <img class="me-2" src="img/icon/icon.svg" alt="" width="40px" height="40px" class="d-inline-block align-text-top">
                <span id="wesite_name">WeConnect</span>
            </a>
        </div>
        <div id="search_ele" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search Friends">
            <label for="search_user" class="d-flex align-items-center">
                <svg fill="currentColor" viewBox="0 0 16 16" width="1em" height="1em" class="a8c37x1j ms05siws l3qrxjdp b7h9ocf4 py1f6qlh gl3lb2sf hhz5lgdu">
                    <g fill-rule="evenodd" transform="translate(-448 -544)">
                        <g fill-rule="nonzero">
                            <path d="M10.743 2.257a6 6 0 1 1-8.485 8.486 6 6 0 0 1 8.485-8.486zm-1.06 1.06a4.5 4.5 0 1 0-6.365 6.364 4.5 4.5 0 0 0 6.364-6.363z" transform="translate(448 544)"></path>
                            <path d="M10.39 8.75a2.94 2.94 0 0 0-.199.432c-.155.417-.23.849-.172 1.284.055.415.232.794.54 1.103a.75.75 0 0 0 1.112-1.004l-.051-.057a.39.39 0 0 1-.114-.24c-.021-.155.014-.356.09-.563.031-.081.06-.145.08-.182l.012-.022a.75.75 0 1 0-1.299-.752z" transform="translate(448 544)"></path>
                            <path d="M9.557 11.659c.038-.018.09-.04.15-.064.207-.077.408-.112.562-.092.08.01.143.034.198.077l.041.036a.75.75 0 0 0 1.06-1.06 1.881 1.881 0 0 0-1.103-.54c-.435-.058-.867.018-1.284.175-.189.07-.336.143-.433.2a.75.75 0 0 0 .624 1.356l.066-.027.12-.061z" transform="translate(448 544)"></path>
                            <path d="m13.463 15.142-.04-.044-3.574-4.192c-.599-.703.355-1.656 1.058-1.057l4.191 3.574.044.04c.058.059.122.137.182.24.249.425.249.96-.154 1.41l-.057.057c-.45.403-.986.403-1.411.154a1.182 1.182 0 0 1-.24-.182zm.617-.616.444-.444a.31.31 0 0 0-.063-.052c-.093-.055-.263-.055-.35.024l.208.232.207-.206.006.007-.22.257-.026-.024.033-.034.025.027-.257.22-.007-.007zm-.027-.415c-.078.088-.078.257-.023.35a.31.31 0 0 0 .051.063l.205-.204-.233-.209z" transform="translate(448 544)"></path>
                        </g>
                    </g>
                </svg>
            </label>
            <input type="text" id="search_user" placeholder="Search Friends">
        </div>


        <div id="search_friend_modal" class="position-absolute">
            <div id="search_items_ele" class="d-flex align-items-center position-sticky top-0 start-0">
                <span id="back_arrow_search" class="me-2">
                    <svg fill="currentColor" viewBox="0 0 20 20" width="24px" height="24px" class="a8c37x1j ms05siws l3qrxjdp b7h9ocf4 py1f6qlh jnigpg78 odw8uiq3">
                        <g fill-rule="evenodd" transform="translate(-446 -350)">
                            <g fill-rule="nonzero">
                                <path d="M100.249 201.999a1 1 0 0 0-1.415-1.415l-5.208 5.209a1 1 0 0 0 0 1.414l5.208 5.209A1 1 0 0 0 100.25 211l-4.501-4.501 4.5-4.501z" transform="translate(355 153.5)"></path>
                                <path d="M107.666 205.5H94.855a1 1 0 1 0 0 2h12.813a1 1 0 1 0 0-2z" transform="translate(355 153.5)"></path>
                            </g>
                        </g>
                    </svg>
                </span>
                <div id="search_items" class="d-flex align-items-center">
                    <label for="search__friend" class="d-flex align-items-center">
                        <svg fill="currentColor" viewBox="0 0 16 16" width="1em" height="1em" class="a8c37x1j ms05siws l3qrxjdp b7h9ocf4 py1f6qlh gl3lb2sf hhz5lgdu">
                            <g fill-rule="evenodd" transform="translate(-448 -544)">
                                <g fill-rule="nonzero">
                                    <path d="M10.743 2.257a6 6 0 1 1-8.485 8.486 6 6 0 0 1 8.485-8.486zm-1.06 1.06a4.5 4.5 0 1 0-6.365 6.364 4.5 4.5 0 0 0 6.364-6.363z" transform="translate(448 544)"></path>
                                    <path d="M10.39 8.75a2.94 2.94 0 0 0-.199.432c-.155.417-.23.849-.172 1.284.055.415.232.794.54 1.103a.75.75 0 0 0 1.112-1.004l-.051-.057a.39.39 0 0 1-.114-.24c-.021-.155.014-.356.09-.563.031-.081.06-.145.08-.182l.012-.022a.75.75 0 1 0-1.299-.752z" transform="translate(448 544)"></path>
                                    <path d="M9.557 11.659c.038-.018.09-.04.15-.064.207-.077.408-.112.562-.092.08.01.143.034.198.077l.041.036a.75.75 0 0 0 1.06-1.06 1.881 1.881 0 0 0-1.103-.54c-.435-.058-.867.018-1.284.175-.189.07-.336.143-.433.2a.75.75 0 0 0 .624 1.356l.066-.027.12-.061z" transform="translate(448 544)"></path>
                                    <path d="m13.463 15.142-.04-.044-3.574-4.192c-.599-.703.355-1.656 1.058-1.057l4.191 3.574.044.04c.058.059.122.137.182.24.249.425.249.96-.154 1.41l-.057.057c-.45.403-.986.403-1.411.154a1.182 1.182 0 0 1-.24-.182zm.617-.616.444-.444a.31.31 0 0 0-.063-.052c-.093-.055-.263-.055-.35.024l.208.232.207-.206.006.007-.22.257-.026-.024.033-.034.025.027-.257.22-.007-.007zm-.027-.415c-.078.088-.078.257-.023.35a.31.31 0 0 0 .051.063l.205-.204-.233-.209z" transform="translate(448 544)"></path>
                                </g>
                            </g>
                        </svg>
                    </label>
                    <input type="text" id="search__friend" placeholder="Search Friends" autocomplete="off">
                </div>
            </div>

            <div class="search_result mt-3" id="search_result_ele"></div>
        </div>
    </div>
    <div id="middle_div" class="d-flex align-items-center position-relative">
        <div id="border_bottom_div" class="position-absolute start-0"></div>
        <div id="home_icon_ele" class="middle_icon_ele active_middle_icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home">
            <span id="home_icon">
                <svg viewBox="0 0 28 28" class="a8c37x1j ms05siws hwsy1cff b7h9ocf4 aaxa7vy3" height="28" width="28">
                    <path d="M25.825 12.29C25.824 12.289 25.823 12.288 25.821 12.286L15.027 2.937C14.752 2.675 14.392 2.527 13.989 2.521 13.608 2.527 13.248 2.675 13.001 2.912L2.175 12.29C1.756 12.658 1.629 13.245 1.868 13.759 2.079 14.215 2.567 14.479 3.069 14.479L5 14.479 5 23.729C5 24.695 5.784 25.479 6.75 25.479L11 25.479C11.552 25.479 12 25.031 12 24.479L12 18.309C12 18.126 12.148 17.979 12.33 17.979L15.67 17.979C15.852 17.979 16 18.126 16 18.309L16 24.479C16 25.031 16.448 25.479 17 25.479L21.25 25.479C22.217 25.479 23 24.695 23 23.729L23 14.479 24.931 14.479C25.433 14.479 25.921 14.215 26.132 13.759 26.371 13.245 26.244 12.658 25.825 12.29"></path>
                </svg>
            </span>
        </div>
        <!-- <div id="friend_icon_ele" class="middle_icon_ele" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Friends">
            <span id="friend_icon">
                <svg viewBox="0 0 28 28" class="a8c37x1j ms05siws hwsy1cff b7h9ocf4 em6zcovv" height="28" width="28">
                    <path d="M10.5 4.5c-2.272 0-2.75 1.768-2.75 3.25C7.75 9.542 8.983 11 10.5 11s2.75-1.458 2.75-3.25c0-1.482-.478-3.25-2.75-3.25zm0 8c-2.344 0-4.25-2.131-4.25-4.75C6.25 4.776 7.839 3 10.5 3s4.25 1.776 4.25 4.75c0 2.619-1.906 4.75-4.25 4.75zm9.5-6c-1.41 0-2.125.841-2.125 2.5 0 1.378.953 2.5 2.125 2.5 1.172 0 2.125-1.122 2.125-2.5 0-1.659-.715-2.5-2.125-2.5zm0 6.5c-1.999 0-3.625-1.794-3.625-4 0-2.467 1.389-4 3.625-4 2.236 0 3.625 1.533 3.625 4 0 2.206-1.626 4-3.625 4zm4.622 8a.887.887 0 00.878-.894c0-2.54-2.043-4.606-4.555-4.606h-1.86c-.643 0-1.265.148-1.844.413a6.226 6.226 0 011.76 4.336V21h5.621zm-7.122.562v-1.313a4.755 4.755 0 00-4.749-4.749H8.25A4.755 4.755 0 003.5 20.249v1.313c0 .518.421.938.937.938h12.125c.517 0 .938-.42.938-.938zM20.945 14C24.285 14 27 16.739 27 20.106a2.388 2.388 0 01-2.378 2.394h-5.81a2.44 2.44 0 01-2.25 1.5H4.437A2.44 2.44 0 012 21.562v-1.313A6.256 6.256 0 018.25 14h4.501a6.2 6.2 0 013.218.902A5.932 5.932 0 0119.084 14h1.861z"></path>
                </svg>
            </span>
        </div> -->
        <div id="watch_icon_ele" class="middle_icon_ele" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Watch">
            <span id="watch_icon">
                <svg viewBox="0 0 28 28" class="a8c37x1j ms05siws l3qrxjdp b7h9ocf4 py1f6qlh" fill="currentColor" height="28" width="28">
                    <path d="M8.75 25.25C8.336 25.25 8 24.914 8 24.5 8 24.086 8.336 23.75 8.75 23.75L19.25 23.75C19.664 23.75 20 24.086 20 24.5 20 24.914 19.664 25.25 19.25 25.25L8.75 25.25ZM17.163 12.846 12.055 15.923C11.591 16.202 11 15.869 11 15.327L11 9.172C11 8.631 11.591 8.297 12.055 8.576L17.163 11.654C17.612 11.924 17.612 12.575 17.163 12.846ZM21.75 20.25C22.992 20.25 24 19.242 24 18L24 6.5C24 5.258 22.992 4.25 21.75 4.25L6.25 4.25C5.008 4.25 4 5.258 4 6.5L4 18C4 19.242 5.008 20.25 6.25 20.25L21.75 20.25ZM21.75 21.75 6.25 21.75C4.179 21.75 2.5 20.071 2.5 18L2.5 6.5C2.5 4.429 4.179 2.75 6.25 2.75L21.75 2.75C23.821 2.75 25.5 4.429 25.5 6.5L25.5 18C25.5 20.071 23.821 21.75 21.75 21.75Z"></path>
                </svg>
            </span>
        </div>
    </div>
    <div id="right_div" class="d-flex align-items-center position-relative">
        <a href="profile?uid=<?php echo $_SESSION['user_id']; ?>" id="profile_ele" class="d-flex align-items-center">
            <div id="profile_img">
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
                        echo "<div id='text_image'>$ch</div>";
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
                        echo "<img src='img/profile_img/$image_name'>";
                    }
                    mysqli_close($conn);
                ?>
            </div>
            <div id="user_f"><?php echo explode(" ",$_SESSION['user_name'])[0]; ?></div>
        </a>
        <div id="message_icon_ele" class="right_icon_elements d-flex" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Message">
            <span id="message_icon" class="user_right_side_items d-flex justify-content-center align-items-center">
                <svg viewBox="0 0 28 28" height="20" width="20" fill="currentColor">
                    <path d="M14 2.042c6.76 0 12 4.952 12 11.64S20.76 25.322 14 25.322a13.091 13.091 0 0 1-3.474-.461.956 .956 0 0 0-.641.047L7.5 25.959a.961.961 0 0 1-1.348-.849l-.065-2.134a.957.957 0 0 0-.322-.684A11.389 11.389 0 0 1 2 13.682C2 6.994 7.24 2.042 14 2.042ZM6.794 17.086a.57.57 0 0 0 .827.758l3.786-2.874a.722.722 0 0 1 .868 0l2.8 2.1a1.8 1.8 0 0 0 2.6-.481l3.525-5.592a.57.57 0 0 0-.827-.758l-3.786 2.874a.722.722 0 0 1-.868 0l-2.8-2.1a1.8 1.8 0 0 0-2.6.481Z"></path>
                </svg>
            </span>
        </div>
        <div id="notafication_icon_ele" class="right_icon_elements d-flex" data-popup_modal_status="0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notafication">
            <span id="notifications_icon" class="user_right_side_items d-flex justify-content-center align-items-center">
                <svg viewBox="0 0 28 28" height="20" width="20">
                    <path fill="currentColor" d="M7.847 23.488C9.207 23.488 11.443 23.363 14.467 22.806 13.944 24.228 12.581 25.247 10.98 25.247 9.649 25.247 8.483 24.542 7.825 23.488L7.847 23.488ZM24.923 15.73C25.17 17.002 24.278 18.127 22.27 19.076 21.17 19.595 18.724 20.583 14.684 21.369 11.568 21.974 9.285 22.113 7.848 22.113 7.421 22.113 7.068 22.101 6.79 22.085 4.574 21.958 3.324 21.248 3.077 19.976 2.702 18.049 3.295 17.305 4.278 16.073L4.537 15.748C5.2 14.907 5.459 14.081 5.035 11.902 4.086 7.022 6.284 3.687 11.064 2.753 15.846 1.83 19.134 4.096 20.083 8.977 20.506 11.156 21.056 11.824 21.986 12.355L21.986 12.356 22.348 12.561C23.72 13.335 24.548 13.802 24.923 15.73Z"></path>
                </svg>
            </span>
            <?php
                require "ajax_request/time_ago_f.php";
                if(!isset($_SESSION)) {
                    session_start();
                }
                $user__id = $_SESSION['user_id'];
                $conn = connected() or die("Connection Failed");
                $sql_notification = "SELECT notification_id,notification_name,from_send_notification_user_id,notification_date_time,notification_read_status FROM notification WHERE to_receive_notification_user_id=$user__id ORDER BY notification_id DESC";
                $result_notification = mysqli_query($conn,$sql_notification) or die("Query Failed notification");
                $notification_data_ele = "";
                $no_of_notafication = 0;
                if(mysqli_num_rows($result_notification)>0) {
                    while($arr_notification = mysqli_fetch_assoc($result_notification)) {

                        $sql_u_img = "SELECT user_name,image_type,profile_image FROM user WHERE user_id={$arr_notification['from_send_notification_user_id']}";
                        $result_u_img = mysqli_query($conn,$sql_u_img) or die("Query Failed u_img");
                        $arr_u_img = mysqli_fetch_assoc($result_u_img);
                        $u_img_p_ = "";
                        if($arr_u_img['image_type'] == "text") {
                            $ch = strtoupper(substr(explode(" ",$arr_u_img['user_name'])[0],0,1));
                            $u_img_p_ = "<div class='from_user_profile_img_text'>$ch</div>";
                        }
                        else {
                            $u_img_p_ = "<img src='img/profile_img/{$arr_u_img['profile_image']}'>";
                        }
                        $right_notafication_ele_ = "";
                        $left_notafication_style = "";
                        if($arr_notification['notification_read_status'] == 0) {
                            $no_of_notafication++;
                            $right_notafication_ele_ = "<div class='right_notafication_ele d-flex align-items-center justify-content-center'>
                                                            <div class='read_unread_notifications'>
                                                                <div class='notifications_status'></div>
                                                            </div>
                                                        </div>";
                        }
                        else {
                            $left_notafication_style = "style='width: 98%;'";
                        }

                        $date_title = date("l, d F Y",$arr_notification['notification_date_time'])." at ".date("h:i:s A",$arr_notification['notification_date_time']);
                        $date = time_ago($arr_notification['notification_date_time']);

                        $notification_data_ele .= "<a href='profile?uid={$arr_notification['from_send_notification_user_id']}' target='_blank' class='notifications_child d-flex align-items-center' data-n = '{$arr_notification['notification_id']}'>
                                                        <div class='left_notafication_ele d-flex align-items-center' $left_notafication_style>
                                                            <div class='notifications_child_img'>
                                                                $u_img_p_
                                                            </div>
                                                            <div class='notifications_details ms-3'>
                                                                <div class='notifications_name'>{$arr_notification['notification_name']}</div>
                                                                <div class='notifications_date_p d-flex justify-content-start align-items-center'>
                                                                    <div class='notifications_date' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$date_title'>$date</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        $right_notafication_ele_
                                                    </a>";
                    }
                }
                else {
                    $notification_data_ele = "<div style='text-align: center; background: #787878a1; border-radius: 6px; padding: 6px 0px;'>No Notification Found</div>";
                }
                mysqli_close($conn);
                $no_of_notafication_style = "";
                if($no_of_notafication > 0) {
                    $no_of_notafication_style = "display: block;";
                }
                else {
                    $no_of_notafication_style = "display: none;";
                }
            ?>
            
            <div id="no_of_notafication" style="<?php echo $no_of_notafication_style; ?>"><div id="inner_no_of_notafication"><?php echo $no_of_notafication; ?></div></div>
        </div>
        <div id="account_icon_ele" class="right_icon_elements d-flex" data-popup_modal_status="0" data-bs-toggle="tooltip" data-bs-placement="left" title="Your Profile">
            <span id="account_icon" class="user_right_side_items d-flex justify-content-center align-items-center">
                <svg fill="currentColor" viewBox="0 0 20 20" width="24px" height="24px" class="a8c37x1j ms05siws l3qrxjdp b7h9ocf4 rs22bh7c jnigpg78 odw8uiq3">
                    <path d="M10 14a1 1 0 0 1-.755-.349L5.329 9.182a1.367 1.367 0 0 1-.205-1.46A1.184 1.184 0 0 1 6.2 7h7.6a1.18 1.18 0 0 1 1.074.721 1.357 1.357 0 0 1-.2 1.457l-3.918 4.473A1 1 0 0 1 10 14z"></path>
                </svg>
            </span>
        </div>

        <div id="popup_ele_modal" class="position-absolute">
            <!-- <div id="all_messages" class="popup_ele">
                <p id="messages_text">Messenger</p>
                <div id="search_friend_message_ele" class="d-flex">
                    <label for="search_friend_mess_input" class="d-flex align-items-center">
                        <svg fill="currentColor" viewBox="0 0 16 16" width="1em" height="1em" class="a8c37x1j ms05siws l3qrxjdp b7h9ocf4 py1f6qlh gl3lb2sf hhz5lgdu">
                            <g fill-rule="evenodd" transform="translate(-448 -544)">
                                <g fill-rule="nonzero">
                                    <path d="M10.743 2.257a6 6 0 1 1-8.485 8.486 6 6 0 0 1 8.485-8.486zm-1.06 1.06a4.5 4.5 0 1 0-6.365 6.364 4.5 4.5 0 0 0 6.364-6.363z" transform="translate(448 544)"></path>
                                    <path d="M10.39 8.75a2.94 2.94 0 0 0-.199.432c-.155.417-.23.849-.172 1.284.055.415.232.794.54 1.103a.75.75 0 0 0 1.112-1.004l-.051-.057a.39.39 0 0 1-.114-.24c-.021-.155.014-.356.09-.563.031-.081.06-.145.08-.182l.012-.022a.75.75 0 1 0-1.299-.752z" transform="translate(448 544)"></path>
                                    <path d="M9.557 11.659c.038-.018.09-.04.15-.064.207-.077.408-.112.562-.092.08.01.143.034.198.077l.041.036a.75.75 0 0 0 1.06-1.06 1.881 1.881 0 0 0-1.103-.54c-.435-.058-.867.018-1.284.175-.189.07-.336.143-.433.2a.75.75 0 0 0 .624 1.356l.066-.027.12-.061z" transform="translate(448 544)"></path>
                                    <path d="m13.463 15.142-.04-.044-3.574-4.192c-.599-.703.355-1.656 1.058-1.057l4.191 3.574.044.04c.058.059.122.137.182.24.249.425.249.96-.154 1.41l-.057.057c-.45.403-.986.403-1.411.154a1.182 1.182 0 0 1-.24-.182zm.617-.616.444-.444a.31.31 0 0 0-.063-.052c-.093-.055-.263-.055-.35.024l.208.232.207-.206.006.007-.22.257-.026-.024.033-.034.025.027-.257.22-.007-.007zm-.027-.415c-.078.088-.078.257-.023.35a.31.31 0 0 0 .051.063l.205-.204-.233-.209z" transform="translate(448 544)"></path>
                                </g>
                            </g>
                        </svg>
                    </label>
                    <input type="text" id="search_friend_mess_input" placeholder="Search">
                </div>
            </div> -->

            <div id="all_notafication" class="popup_ele">
                <p id="notifications_text">Notifications</p>
                <?php
                    echo $notification_data_ele;
                ?>
                
                <!-- <a href="#" class="notifications_child d-flex align-items-center">
                    <div class="left_notafication_ele d-flex align-items-center">
                        <div class="notifications_child_img">
                            <img src="img/profile_img/default_image1.jpg" alt="">
                        </div>
                        <div class="notifications_details ms-3">
                            <div class="notifications_name">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
                            <div class="notifications_date">10/04/2022</div>
                        </div>
                    </div>
                    <div class="right_notafication_ele d-flex align-items-center justify-content-center">
                        <div class="read_unread_notifications">
                            <div class="notifications_status"></div>
                        </div>
                    </div>
                </a>

                <a href="#" class="notifications_child d-flex align-items-center">
                    <div class="left_notafication_ele d-flex align-items-center">
                        <div class="notifications_child_img">
                            <img src="img/profile_img/default_image1.jpg" alt="">
                        </div>
                        <div class="notifications_details ms-3">
                            <div class="notifications_name">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
                            <div class="notifications_date">10/04/2022</div>
                        </div>
                    </div>
                    <div class="right_notafication_ele d-flex align-items-center justify-content-center">
                        <div class="read_unread_notifications">
                            <div class="notifications_status"></div>
                        </div>
                    </div>
                </a>
                <a href="#" class="notifications_child d-flex align-items-center">
                    <div class="left_notafication_ele d-flex align-items-center">
                        <div class="notifications_child_img">
                            <img src="img/profile_img/default_image1.jpg" alt="">
                        </div>
                        <div class="notifications_details ms-3">
                            <div class="notifications_name">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
                            <div class="notifications_date">10/04/2022</div>
                        </div>
                    </div>
                    <div class="right_notafication_ele d-flex align-items-center justify-content-center">
                        <div class="read_unread_notifications">
                            <div class="notifications_status"></div>
                        </div>
                    </div>
                </a> -->
            </div>

            <div id="account_settings" class="popup_ele">
                <a href="profile?uid=<?php echo $_SESSION['user_id']; ?>" id="profile_user_" class="account_settings_child d-flex mb-3">
                    <div id="profile_image_ele">
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
                                echo "<div id='text_profile_image'>$ch</div>";
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
                                echo "<img src='img/profile_img/$image_name'>";
                            }
                            mysqli_close($conn);
                        ?>
                    </div>
                    <div id="profile_user_and_view_profile" class="ms-3">
                        <div id="profile_user_name"><?php echo $_SESSION['user_name']; ?></div>
                        <div id="view_profile_ele">View Profile</div>
                    </div>
                </a>
                <div id="empty_ele" class="mb-3"></div>
                <a href="#" id="settings_privacy" class="account_settings_child d-flex mb-3 p-3 edit_profile__btn">
                    <div id="settings_p_icon">
                        <span class="settings__icon">
                            <i class="fas fa-user-edit"></i>
                        </span>
                    </div>
                    <div id="settings_p_text" class="ms-3">Edit Profile</div>
                </a>
                <a href="logout" id="logout" class="account_settings_child d-flex p-3">
                    <div id="logout_icon">
                        <span class="s_logout_icon">
                            <svg class="feather feather-command" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#000" d="M2 12L7 16 7 13 16 13 16 11 7 11 7 8z"></path>
                                <path fill="#000" d="M13.001,2.999c-2.405,0-4.665,0.937-6.364,2.637L8.051,7.05c1.322-1.322,3.08-2.051,4.95-2.051s3.628,0.729,4.95,2.051 s2.051,3.08,2.051,4.95s-0.729,3.628-2.051,4.95s-3.08,2.051-4.95,2.051s-3.628-0.729-4.95-2.051l-1.414,1.414 c1.699,1.7,3.959,2.637,6.364,2.637s4.665-0.937,6.364-2.637c1.7-1.699,2.637-3.959,2.637-6.364s-0.937-4.665-2.637-6.364 C17.666,3.936,15.406,2.999,13.001,2.999z"></path>
                            </svg>
                        </span>
                    </div>
                    <div id="logout_text" class="ms-3">Log Out</div>
                </a>
            </div>
        </div>
    </div>
</div>