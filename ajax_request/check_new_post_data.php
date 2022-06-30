<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        require_once "../conn.php";
        require "time_ago_f.php";
        require "calculate_num_.php";

        if (isset($_POST["post_get_in_c_t"])) {
            $info['error'] = 1;
            $post_get_in_c_t = trim($_POST["post_get_in_c_t"]);
            
            $conn = connected() or die("Connection Failed");
        
            date_default_timezone_set("Asia/Kolkata");

            if(!isset($_SESSION)) {
                session_start();
            }
            $user_id = $_SESSION["user_id"];

            $sql_get_login_user_details = "SELECT user_name,image_type,profile_image FROM user WHERE user_id=$user_id";
            $result_get_login_user_details = mysqli_query($conn,$sql_get_login_user_details) or die("Query Failed get_login_user_details");
            $arr_get_login_user_details = mysqli_fetch_assoc($result_get_login_user_details);

            // $user__profile_img__text = "";
            $user_profile_img_text__comment__style = "";

            if($arr_get_login_user_details['image_type'] == "text") {
                $ch = strtoupper(substr(explode(" ",$arr_get_login_user_details["user_name"])[0],0,1));
                // $user__profile_img__text = "<div id='profile_side__img_text'>$ch</div>";
                $user_profile_img_text__comment__style = "<div class='user_profile_img_text_comment_style_'>$ch</div>";
            }
            else {
                // $user__profile_img__text = "<img src='img/profile_img/{$arr_get_login_user_details["profile_image"]}'>";
                $user_profile_img_text__comment__style = "<img src='img/profile_img/{$arr_get_login_user_details["profile_image"]}'>";
            }


            $q = "SELECT post.post_id,post.post_message,post.post_img_name,post.post_privacy,post.post_timestamp,post.user_id,post.total_rection_count,post.like_,post.love,post.care,post.haha,post.wow,post.sad,post.angry,post.total_comment_in_post,user.user_id,user.user_name,user.image_type,user.profile_image FROM post INNER JOIN user ON post.user_id = user.user_id ORDER BY post_si_no DESC";
            mysqli_set_charset($conn,'utf8mb4');

            $result = mysqli_query($conn,$q) or die("Query Failed");

            $sub_data = "";
            $total_no_of_post = 0;

            
            if(mysqli_num_rows($result)>0) {
                $post_get_in_c_t_arr = explode("/",$post_get_in_c_t);
                $inner_post_image__set = "";

                while($arr = mysqli_fetch_assoc($result)) {
                    $current_post_id_enc = sha1($arr['post_id']);

                    if(in_array($current_post_id_enc,$post_get_in_c_t_arr)) {
                        continue;
                    }
                    else {
                        if($arr['user_id'] == $user_id) {
                            continue;
                        }
                        else {
                            $inner_post_image__set = "";
    
                            if($arr["post_img_name"] != "") {
                                $set_post_img = explode(",",$arr["post_img_name"]);
                                $image__ele = "";
                                foreach($set_post_img as $image_name__s) {
                                    $file_extension = explode(".",$image_name__s)[1];
                                    
                                    $img_extension = array("jpg","jpeg","png","gif");
            
                                    if(in_array($file_extension,$img_extension)) {
                                        $image__ele .= "<img src='post_img/$image_name__s'>";
                                    }
                                    else {
                                        $image__ele .= "<video src='post_img/$image_name__s' controls></video>";
                                    }
                                }
                                $inner_post_image__set = "<div class='row'><div class='col-12 p-2 img_style_post_set'>$image__ele</div></div>";
                            }
    
                            $style_add = "";
                            if($arr['total_rection_count'] == 0) {
                                $style_add = "display:none"; 
                            }
    
                            $post_id_enc = sha1($arr['post_id']);
    
                            $rection_ele = "<div class='row p-2 rection__emoji_row justify-content-between align-items-center flex-nowrap' style='$style_add' data-p='$post_id_enc'>
                                        <div class='col-10'>
                                            <div class='row show_rection__emoji'>
                                                <div class='col-12 rection_section'>
                                                    <div class='rection___img rection___img_like d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/like.svg'>
                                                        <div class='no_of_like'>{$arr['like_']}</div>
                                                    </div>
                                                    <div class='rection___img rection___img_love d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/love.svg'>
                                                        <div class='no_of_love'>{$arr['love']}</div>
                                                    </div>
                                                    <div class='rection___img rection___img_care d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/care.svg'>
                                                        <div class='no_of_care'>{$arr['care']}</div>
                                                    </div>
                                                    <div class='rection___img rection___img_haha d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/haha.svg'>
                                                        <div class='no_of_haha'>{$arr['haha']}</div>
                                                    </div>
                                                    <div class='rection___img rection___img_wow d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/wow.svg'>
                                                        <div class='no_of_wow'>{$arr['wow']}</div>
                                                    </div>
                                                    <div class='rection___img rection___img_sad d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/sad.svg'>
                                                        <div class='no_of_sad'>{$arr['sad']}</div>
                                                    </div>
                                                    <div class='rection___img rection___img_angry d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/angry.svg'>
                                                        <div class='no_of_angry'>{$arr['angry']}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col d-flex justify-content-end'>
                                            <div class='rection___text' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Total Rection'>{$arr['total_rection_count']}</div>
                                        </div>
                                    </div>";
                            // check user rection a post or Not
                            $post_id = $arr['post_id'];
                            $sql_2 = "SELECT * FROM user_rection_in_post WHERE post_id = '$post_id' AND user_id = $user_id";
                            $result_2 = mysqli_query($conn,$sql_2) or die(mysqli_error($conn));
                            $rection_icon_ele = "";
                            if(mysqli_num_rows($result_2) == 1) {
                                $arr_2 = mysqli_fetch_assoc($result_2);
                                if($arr_2['rection_type'] == "like") {
                                    $rection_icon_ele = "<img src='img/rection_emoji_icon/like.svg'><span class='ms-1'>Like</span>";
                                }
                                else if($arr_2['rection_type'] == "love") {
                                    $rection_icon_ele = "<img src='img/rection_emoji_icon/love.svg'><span class='ms-1'>Love</span>";
                                }
                                else if($arr_2['rection_type'] == "care") {
                                    $rection_icon_ele = "<img src='img/rection_emoji_icon/care.svg'><span class='ms-1'>Care</span>";
                                }
                                else if($arr_2['rection_type'] == "haha") {
                                    $rection_icon_ele = "<img src='img/rection_emoji_icon/haha.svg'><span class='ms-1'>Haha</span>";
                                }
                                else if($arr_2['rection_type'] == "wow") {
                                    $rection_icon_ele = "<img src='img/rection_emoji_icon/wow.svg'><span class='ms-1'>Wow</span>";
                                }
                                else if($arr_2['rection_type'] == "sad") {
                                    $rection_icon_ele = "<img src='img/rection_emoji_icon/sad.svg'><span class='ms-1'>Sad</span>";
                                }
                                else if($arr_2['rection_type'] == "angry") {
                                    $rection_icon_ele = "<img src='img/rection_emoji_icon/angry.svg'><span class='ms-1'>Angry</span>";
                                }
                            }
                            else {
                                $rection_icon_ele = "<i class='far fa-thumbs-up'></i><span class='ms-1'>Like</span>";
                            }
    
                            // check user Profile image or text
                            $image_type_ = $arr['image_type'];
                            $img_text__ele = "";
                            
                            
                            if($image_type_ == "text") {
                                $ch = strtoupper(substr(explode(" ",$arr['user_name'])[0],0,1));
                                $img_text__ele = "<div class='profile___text_'>$ch</div>";
                            }
                            else  {
                                $image_name_ = $arr['profile_image'];
                                $img_text__ele = "<img src='img/profile_img/$image_name_'>";
                            }
    
                            $date = time_ago($arr['post_timestamp']);
                            $date_title = date("l, d F Y",$arr['post_timestamp'])." at ".date("h:i:s A",$arr['post_timestamp']);
    
                            $total_comment = cal_num_($arr['total_comment_in_post'],"comment");

                            $icon_class_name = "";
                            if($arr['post_privacy'] == "public") {
                                $icon_class_name = "fas fa-globe-asia";
                                $post_get_in_c_t = sha1($arr['post_id'])."/".$post_get_in_c_t;
                            }
                            else if($arr['post_privacy'] == "friends") {

                                $current_post_user_id =  $arr['user_id'];
                                $login_user_id = $user_id;
                                $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$current_post_user_id AND to_user_id=$login_user_id)";
                                $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
                                if(mysqli_num_rows($result_request_friend_status) > 0) {
                                    $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
                                    if($arr_request_friend_status['action_name'] == "friends") {
                                        $icon_class_name = "fas fa-user-friends";
                                        $post_get_in_c_t = sha1($arr['post_id'])."/".$post_get_in_c_t;
                                    }
                                    else {
                                        continue;
                                    }
                                }
                                else {
                                    continue;
                                }
        
                            }
                            else if($arr['post_privacy'] == "only_me") {
                                $icon_class_name = "fas fa-lock";
                                continue;
                            }
                            $sub_data .= "<div class='row my-4 align-items-center style_post_any'>
                                <div class='col-12'>
                                    <div class='row justify-content-between align-items-center'>
                                        <div class='col-12 d-flex align-items-center'>
                                            <div class='me-2'>
                                                <span class='user_profile_'>
                                                    $img_text__ele
                                                </span>
                                            </div>
                                            <div class='d-flex flex-column ms-2'>
                                                <a href='profile?uid={$arr['user_id']}' class='user_name_span' target='_blank'>{$arr['user_name']}</a>
                                                <span class='user_time_icon'><a href='#' class='me-1' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$date_title'>$date</a> <i class='$icon_class_name' data-bs-toggle='tooltip' data-bs-placement='bottom' title='{$arr['post_privacy']}'></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-12 p-2 post__mess_style'>
                                            {$arr['post_message']}
                                        </div>
                                    </div>
                                    $inner_post_image__set
                                    $rection_ele
                                    <div class='row py-2 style_border_add'>
                                        <div class='col-6 d-flex align-items-center justify-content-center like_div'>
                                            <div class='like_'>
                                                $rection_icon_ele
                                            </div>
                                        </div>
                                        <div class='col-6 d-flex align-items-center justify-content-center comment_div' data-comment_show_hide_staus='0' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$total_comment'>
                                            <div class='comment_'>
                                                <i class='far fa-comment'></i>
                                                <span class='ms-1'>Comment</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row my-2 justify-content-center align-items-center comment_show_hide_element'>
                                        <div class='col-12 p-0'>
                                            <div class='row m-0 justify-content-center align-items-center'>
                                                <span class='p-0 user_profile_comment_style'>
                                                    $user_profile_img_text__comment__style
                                                </span>
                                                <form class='p-0 comment__column__ele'>
                                                    <textarea class='show_post_modal_2' placeholder='Write a comment'></textarea>
                                                </form>
                                                <div class='w-100 mt-3 all__comment__ele'>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                            $total_no_of_post++;

                        }
                    }
                }

                if (!isset($_SESSION)) {
                    session_start();
                }
                $login__user_id = $_SESSION["user_id"];
                $total_post = 0;
                $sql_total_post = "SELECT post_privacy,user_id FROM post";
                $result_total_post = mysqli_query($conn,$sql_total_post) or die("Query Failed total_post");

                if(mysqli_num_rows($result_total_post)>0) {
                    while($arr_result_total_post = mysqli_fetch_assoc($result_total_post)) {
                        $c_post_privacy = $arr_result_total_post['post_privacy'];
                        $post_user_id_ = $arr_result_total_post['user_id'];

                        if($c_post_privacy == "public") {
                            $total_post++;
                        }
                        else if($c_post_privacy == "only_me") {
                            if($login__user_id == $post_user_id_) {
                                $total_post++;
                            }
                        }
                        else if($c_post_privacy == "friends") {
                            if($login__user_id == $post_user_id_) {
                                $total_post++;
                            }
                            else {
                                $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$post_user_id_ AND to_user_id=$login__user_id)";
                                $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
    
                                if(mysqli_num_rows($result_request_friend_status) > 0) {
                                    $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
    
                                    if($arr_request_friend_status['action_name'] == "friends") {
                                        $total_post++;
                                    }
                                }
                            }
                        }
                    }
                }
                $total_post = $total_post - $total_no_of_post;
                if($total_post > 0) {
                    $info['total_post'] = 1;
                }
                else {
                    $info['total_post'] = 0;
                }
                $info['mdata'] = $sub_data;
            }
            mysqli_close($conn);
            $info['post_get_in_c_t'] = $post_get_in_c_t;
        }
        else {
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>