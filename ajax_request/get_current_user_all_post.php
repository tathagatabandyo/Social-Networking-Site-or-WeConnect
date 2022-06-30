<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['current_user_id'])) {
            $info["error"] = 1;
            require_once "../conn.php";
            require "time_ago_f.php";
            require "calculate_num_.php";
            $conn = connected() or die("Connection Failed");
            $current_user_id = mysqli_real_escape_string($conn,$_POST['current_user_id']);


            date_default_timezone_set("Asia/Kolkata");
    
            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION["user_id"];


            $sql_get_login_user_details = "SELECT user_name,image_type,profile_image FROM user WHERE user_id=$login_user_id";
            $result_get_login_user_details = mysqli_query($conn,$sql_get_login_user_details) or die("Query Failed get_login_user_details");
            $arr_get_login_user_details = mysqli_fetch_assoc($result_get_login_user_details);

            $user__profile_img__text = "";
            $user_profile_img_text__comment__style = "";

            if($arr_get_login_user_details['image_type'] == "text") {
                $ch = strtoupper(substr(explode(" ",$arr_get_login_user_details["user_name"])[0],0,1));
                $user_profile_img_text__comment__style = "<div class='user_profile_img_text_comment_style_'>$ch</div>";
                $user__profile_img__text = "<div id='profile_side__img_text'>$ch</div>";
            }
            else {
                $user_profile_img_text__comment__style = "<img src='img/profile_img/{$arr_get_login_user_details["profile_image"]}'>";
                $user__profile_img__text = "<img src='img/profile_img/{$arr_get_login_user_details["profile_image"]}'>";
            }


            $sql_s = "SELECT user_name FROM user WHERE user_id = $current_user_id";
            $result_s = mysqli_query($conn,$sql_s) or die("Query Failed");
            if(mysqli_num_rows($result_s) == 1) {
                $info['user_search_status'] = true;
                
                $q = "SELECT post.post_id,post.post_message,post.post_img_name,post.post_privacy,post.post_timestamp,post.user_id,post.total_rection_count,post.like_,post.love,post.care,post.haha,post.wow,post.sad,post.angry,post.total_comment_in_post,user.user_id,user.user_name,user.image_type,user.profile_image FROM post INNER JOIN user ON post.user_id = user.user_id WHERE user.user_id=$current_user_id ORDER BY post_si_no DESC";
                mysqli_set_charset($conn,'utf8mb4');
                $result = mysqli_query($conn,$q) or die("Query Failed");

                if(mysqli_num_rows($result)>0) {
                    $post_count = 0;
                    $sub_data = "";
                    $inner_post_image__set = "";
                    $img_text__ele_f = "";

                    while($arr = mysqli_fetch_assoc($result)) {

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

                        $post_id = $arr['post_id'];
                        $sql_2 = "SELECT * FROM user_rection_in_post WHERE post_id = '$post_id' AND user_id = $login_user_id";
                        $result_2 = mysqli_query($conn,$sql_2) or die("Query Failed2");
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
                        $img_text__ele_f = "";
                        
                        if($image_type_ == "text") {
                            $ch = strtoupper(substr(explode(" ",$arr['user_name'])[0],0,1));
                            $img_text__ele = "<div class='profile___text_'>$ch</div>";
                            $img_text__ele_f = "<div id='profile_side__img_text'>$ch</div>";
                        }
                        else  {
                            $image_name_ = $arr['profile_image'];
                            $img_text__ele = "<img src='img/profile_img/$image_name_'>";
                            $img_text__ele_f = "<img src='img/profile_img/$image_name_'>";
                        }

                        $date = time_ago($arr['post_timestamp']);
                        $date_title = date("l, d F Y",$arr['post_timestamp'])." at ".date("h:i:s A",$arr['post_timestamp']);

                        $total_comment = cal_num_($arr['total_comment_in_post'],"comment");

                        if($current_user_id == $login_user_id) {
                            $icon_class_name = "";
                            if($arr['post_privacy'] == "public") {
                                $icon_class_name = "fas fa-globe-asia";
                            }
                            else if($arr['post_privacy'] == "friends") {
                                $icon_class_name = "fas fa-user-friends";
                            }
                            // else if($arr['post_privacy'] == "specific") {
                            //     $icon_class_name = "fas fa-user";
                            // }
                            else if($arr['post_privacy'] == "only_me") {
                                $icon_class_name = "fas fa-lock";
                            }
                            // else if($arr['post_privacy'] == "custom") {
                            //     $icon_class_name = "fas fa-cog";
                            // }
                            // $date = date("d/m/Y",$arr['post_timestamp']);
                            
                            $sub_data .= "<div class='row my-4 align-items-center style_post_any'>
                                            <div class='col-12'>
                                                <div class='row justify-content-start align-items-center position-relative'>
                                                    <div class='col-11 d-flex align-items-center'>
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
                                                
                                                    <div class='post_delete_ele' data-p = '$post_id_enc'>
                                                        <span class='material-symbols-outlined'>delete</span>
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
                            $post_count++;
                        }
                        else {
                            $icon_class_name = "";
                            if($arr['post_privacy'] == "public") {
                                $icon_class_name = "fas fa-globe-asia";
                            }
                            else if($arr['post_privacy'] == "only_me") {
                                $icon_class_name = "fas fa-lock";
                                continue;
                            }
                            else if($arr['post_privacy'] == "friends") {
                                $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$current_user_id AND to_user_id=$login_user_id)";
                                $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
                                if(mysqli_num_rows($result_request_friend_status) > 0) {
                                    $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
                                    if($arr_request_friend_status['action_name'] == "friends") {
                                        $icon_class_name = "fas fa-user-friends";
                                    }
                                    else {
                                        continue;
                                    }
                                }
                                else {
                                    continue;
                                }
                            }
                            // $date = date("d/m/Y",$arr['post_timestamp']);
                            $sub_data .= "<div class='row my-4 align-items-center style_post_any'>
                                            <div class='col-12'>
                                                <div class='row justify-content-start align-items-center position-relative'>
                                                    <div class='col-11 d-flex align-items-center'>
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
                            $post_count++;
                        }
                    }
                    $add_post_ele = "";
                    if($login_user_id == $current_user_id) {
                        $add_post_ele = "<div class='row my-3 align-items-center style_post_any'>
                                            <div class='col-2 d-flex justify-content-center'>
                                                <span class='user_profile_'>
                                                    $user__profile_img__text
                                                </span>
                                            </div>
                                            <div class='col-10' id='show_post_modal_'>Write Something ...</div>
                                        </div>";
                    }
                    if($post_count > 0) {
                        $info['post_data'] = true;
                        $data = "
                        <div class='col-xl-5 col-lg-7 col-md-9 res_ele p-0'>
        
                            $add_post_ele
                                    
                            <div class='row'>
                                <div class='col-12' id='add_post_data'>
                                    
                                    $sub_data
        
                                </div>
                            </div>
                        </div>"; 
                        $info['post_data_t'] = $data;   
                    }
                    else {
                        if($login_user_id == $current_user_id) {
                            $info['post_data'] = "<div class='col-lg-5 col-md-11 res_ele'>
        
                                    <div class='row my-3 align-items-center style_post_any'>
                                        <div class='col-2 d-flex justify-content-center'>
                                            <span class='user_profile_'>
                                                $user__profile_img__text
                                            </span>
                                        </div>
                                        <div class='col-10' id='show_post_modal_'>Write Something ...</div>
                                    </div>
                                            
                                    <div class='row'>
                                        <div class='col-12' id='add_post_data'>
                                            
                                            <div class='row my-4 align-items-center style_post_any'>
                                                <div class='col-12'>
                                                    <div class='row justify-content-start align-items-center position-relative'>
                                                        <div class='col-12 d-flex justify-content-center align-items-center' style='font-weight: bold; font-size: 20px;user-select:none;'>No Post Data Found</div>
                                                    </div>
                                                </div>
                                            </div>
                
                                        </div>
                                    </div>
                                </div>";
                        }
                        else {
                            $info['post_data'] = "<div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Post Data Found</div>";
                        }
                    }
                }
                else {
                    if($login_user_id == $current_user_id) {
                        $info['post_data'] = "<div class='col-lg-5 col-md-11 res_ele'>
        
                            <div class='row my-3 align-items-center style_post_any'>
                                <div class='col-2 d-flex justify-content-center'>
                                    <span class='user_profile_'>
                                        $user__profile_img__text
                                    </span>
                                </div>
                                <div class='col-10' id='show_post_modal_'>Write Something ...</div>
                            </div>
                                    
                            <div class='row'>
                                <div class='col-12' id='add_post_data'>
                                    
                                    <div class='row my-4 align-items-center style_post_any'>
                                        <div class='col-12'>
                                            <div class='row justify-content-start align-items-center position-relative'>
                                                <div class='col-12 d-flex justify-content-center align-items-center' style='font-weight: bold; font-size: 20px;user-select:none;'>No Post Data Found</div>
                                            </div>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                        </div>";
                    }
                    else {
                        $info['post_data'] = "<div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Post Data Found</div>";
                    }
                }
            }
            else {
                $info['user_search_status'] = "Something Went Wrong | Not Valid User | Reload The Page";
            }
            mysqli_close($conn);
        }
        else {
            $info["error"] = 0;
        }
        echo json_encode($info);
    }
?>