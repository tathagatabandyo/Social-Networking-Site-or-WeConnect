<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['current_user_id'])) {
            $info["error"] = 1;
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $current_user_id = mysqli_real_escape_string($conn,$_POST['current_user_id']);

            date_default_timezone_set("Asia/Kolkata");
    
            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION["user_id"];

            $sql_s = "SELECT user_name FROM user WHERE user_id = $current_user_id";
            $result_s = mysqli_query($conn,$sql_s) or die("Query Failed");
            if(mysqli_num_rows($result_s) == 1) {
                $info['user_search_status'] = true;

                $q = "SELECT post.post_id,post.post_message,post.post_img_name,post.post_privacy,post.post_timestamp,post.user_id AS post_user_id,post.total_rection_count,post.like_,post.love,post.care,post.haha,post.wow,post.sad,post.angry,user.user_id,user.user_name,user.image_type,user.profile_image FROM post INNER JOIN user ON post.user_id = user.user_id WHERE user.user_id=$current_user_id ORDER BY post_si_no DESC";
                // if($login_user_id == $current_user_id) {
                // }
                // else {
                //     $q = "SELECT post.post_id,post.post_message,post.post_img_name,post.post_privacy,post.post_timestamp,post.user_id,post.total_rection_count,post.like_,post.love,post.care,post.haha,post.wow,post.sad,post.angry,user.user_id,user.user_name,user.image_type,user.profile_image FROM post INNER JOIN user ON post.user_id = user.user_id WHERE (user.user_id=$current_user_id and post.post_privacy!='only_me') ORDER BY post_si_no DESC";
                // }


                $result = mysqli_query($conn,$q) or die("Query Failed");


                if(mysqli_num_rows($result)>0) {
                    $info['post_data'] = true;
                    $sub_data = "";
                    $inner_post_image__set = "";
                    $img_text__ele_f = "";

                    while($arr = mysqli_fetch_assoc($result)) {

                        $valid_post_ = 0;

                        $current_post_user_id =  $arr['post_user_id'];
                        if($login_user_id == $current_user_id) {
                            $valid_post_ = 1;
                        }
                        else {
                            if($arr["post_privacy"] == "public") {
                                $valid_post_ = 1;
                            }
                            else if($arr["post_privacy"] == "only_me"){
                                $valid_post_ = 0;
                            }
                            else {
                                $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$login_user_id AND to_user_id=$current_user_id)";
                                $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
                                if(mysqli_num_rows($result_request_friend_status) > 0) {
                                    $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
    
                                    if($arr_request_friend_status['action_name'] == "friends") {
                                        $valid_post_ = 1;
                                    }
                                    else {
                                        $valid_post_ = 0;
                                    }
                                }
                                else {
                                    $valid_post_ = 0;
                                }
                            }
                        }

                        if($valid_post_ == 1) {
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
                                                    <div class='rection___text' title='Total Rection'>{$arr['total_rection_count']}</div>
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
    
                            $delete_post_ele_btn = "";
                            if($login_user_id == $current_user_id) {
                                $delete_post_ele_btn = "
                                    <div class='post_delete_ele' data-p = '$post_id_enc'>
                                        <span class='material-symbols-outlined'>delete</span>
                                    </div>";
                            }
    
                            $date = date("d/m/Y",$arr['post_timestamp']);
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
                                                            <span class='user_time_icon'><a href='#' class='me-1'>$date</a> <i class='$icon_class_name'></i></span>
                                                        </div>
                                                    </div>
                                                
                                                    $delete_post_ele_btn
                                                    
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
                                                    <div class='col-6 d-flex align-items-center justify-content-center comment_div'>
                                                        <div class='comment_'>
                                                            <i class='far fa-comment'></i>
                                                            <span class='ms-1'>Comment</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='row mt-2 justify-content-center'>
                                                    <div class='col-2 d-flex justify-content-center'>
                                                        <span class='user_profile_'>
                                                            $img_text__ele
                                                        </span>
                                                    </div>
                                                    <input type='text' class='col-10 show_post_modal_2' placeholder='Write a comment'>
                                                </div>
                                            </div>
                                        </div>"; 
                        }
                    }
                    $add_post_ele = "";
                    if($login_user_id == $current_user_id) {
                        $add_post_ele = "<div class='row my-3 align-items-center style_post_any'>
                        <div class='col-2 d-flex justify-content-center'>
                            <span class='user_profile_'>
                                $img_text__ele_f
                            </span>
                        </div>
                        <div class='col-10' id='show_post_modal_'>Write Something ...</div>
                    </div>";
                    }
                    $data = "
                        <div class='col-lg-5 col-md-11 res_ele'>
        
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
                        $img_text__ele_login_user = "";
                        $sql_get_img = "SELECT user_name,image_type,profile_image FROM user WHERE user_id = '$login_user_id'";
                        $result_get_img = mysqli_query($conn,$sql_get_img) or die("Query Failed get img");

                        $arr_get_img = mysqli_fetch_assoc($result_get_img);
                        if($arr_get_img['image_type'] == "text") {
                            $ch = strtoupper(substr(explode(" ",$arr_get_img['user_name'])[0],0,1));
                            $img_text__ele_login_user = "<div id='profile_side__img_text'>$ch</div>";
                        }
                        else {
                            $image_name_ = $arr_get_img['profile_image'];
                            $img_text__ele_login_user = "<img src='img/profile_img/$image_name_'>";
                        }
                        
                        $info['post_data'] = "<div class='col-lg-5 col-md-11 res_ele'>
        
                            <div class='row my-3 align-items-center style_post_any'>
                                <div class='col-2 d-flex justify-content-center'>
                                    <span class='user_profile_'>
                                        $img_text__ele_login_user
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