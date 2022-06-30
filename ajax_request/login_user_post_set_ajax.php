<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // changing the upload limits
        // ini_set('upload_max_filesize', '500M');
        // ini_set('post_max_size', '550M');
        // ini_set('memory_limit', '1024M');
        // ini_set('max_input_time', 300);
        // ini_set('max_execution_time', 300);
        ini_set('upload_max_filesize', '1000M');
        ini_set('post_max_size', '1020M');
        ini_set('memory_limit', '1024M');
        ini_set('max_input_time', 600);
        ini_set('max_execution_time', 600);


        $info = array();
        $post_id = time() . "_" . mt_rand(100, 100000) . "_" . mt_rand(200, 90000)."_".date("s");
        if (isset($_POST["post_message"]) && isset($_POST["post_privacy"]) && isset($_FILES['post_image'])) {
            $info['error'] = 1;
            require_once "../conn.php";
            require "time_ago_f.php";
            $conn = connected() or die("Connection Failed");
            // $post_message = mysqli_real_escape_string($conn,trim($_POST['post_message']));
            $post_message = trim($_POST['post_message']);
            $post_privacy = mysqli_real_escape_string($conn, trim($_POST['post_privacy']));

            $valid_post_message = 0;
            $valid_post_privacy = 0;

            // post_message checker
            if ($post_message == "" || $post_message == "<div><br></div>") {
                $info['post_message'] = "Type a message";
                $valid_post_message = 0;
            }
            else if(preg_match("/^[<div><br><\/div,\s,&nbsp;]+$/",$post_message)) {
                $info['post_message'] = "Type a message";
                $valid_post_message = 0;
            }
            else {
                if(str_ends_with($post_message,"<div><br></div>")) {
                    $em = strlen($post_message) - strlen("<div><br></div>");

                    $post_message = substr($post_message,0,$em);
                }
                if(str_ends_with($post_message,"<div></div>")) {
                    $em = strlen($post_message) - strlen("<div></div>");

                    $post_message = substr($post_message,0,$em);
                }
                $info['post_message'] = true;
                $valid_post_message = 1;
            }

            // post privacy checker
            if ($post_privacy == "public" || $post_privacy == "friends" || $post_privacy == "only_me") {
                $valid_post_privacy = 1;
                $info['post_privacy'] = true;
            } else {
                $valid_post_privacy = 0;
                $info['post_privacy'] = "Something Went Wrong";
            }
            $info["file_upload"] = 0;
            $info['success'] = 0;

            // $info['total_post'] = 1;

            if (($valid_post_message == 1) && ($valid_post_privacy == 1)) {
                $file_name = [];
                $file_type = [];
                $tmp_name = [];
                $files_name_s = "";
                $no_of_file = count($_FILES["post_image"]["error"]);
                $file_check_status = 0;

                if (!isset($_SESSION)) {
                    session_start();
                }
                $user_id = $_SESSION["user_id"];
                $user_name = $_SESSION["user_name"];



                $sql_get_login_user_details = "SELECT user_name,image_type,profile_image FROM user WHERE user_id=$user_id";
                $result_get_login_user_details = mysqli_query($conn,$sql_get_login_user_details) or die("Query Failed get_login_user_details");
                $arr_get_login_user_details = mysqli_fetch_assoc($result_get_login_user_details);

                $user_profile_img_text__comment__style = "";

                if($arr_get_login_user_details['image_type'] == "text") {
                    $ch = strtoupper(substr(explode(" ",$arr_get_login_user_details["user_name"])[0],0,1));
                    $user_profile_img_text__comment__style = "<div class='user_profile_img_text_comment_style_'>$ch</div>";
                }
                else {
                    $user_profile_img_text__comment__style = "<img src='img/profile_img/{$arr_get_login_user_details["profile_image"]}'>";
                }


    
                date_default_timezone_set("Asia/Kolkata");
                $timestamp = time();

                $icon_class_name = "";
                if ($post_privacy == "public") {
                    $icon_class_name = "fas fa-globe-asia";
                } else if ($post_privacy == "friends") {
                    $icon_class_name = "fas fa-user-friends";
                }
                // else if($post_privacy == "specific") {
                //     $icon_class_name = "fas fa-user";
                // }
                else if ($post_privacy == "only_me") {
                    $icon_class_name = "fas fa-lock";
                }
                // else if($post_privacy == "custom") {
                //     $icon_class_name = "fas fa-cog";
                // }

                // user profile image check
                $profile_img_text_ = "";
                $sql_ = "SELECT image_type FROM user WHERE user_id='$user_id'";
                $result_ = mysqli_query($conn,$sql_) or die("Query Failed");
                $image_type_ = "";
                if(mysqli_num_rows($result_) > 0) {
                    while($arr_ = mysqli_fetch_assoc($result_)) {
                        $image_type_ = $arr_["image_type"];
                    }
                }
                if($image_type_ == "text") {
                    $ch = strtoupper(substr(explode(" ",$_SESSION['user_name'])[0],0,1));
                    $profile_img_text_ = "<div class='profile___text_'>$ch</div>";
                }
                else  {
                    $sql2_ = "SELECT profile_image FROM user WHERE user_id='$user_id'";
                    $result2_ = mysqli_query($conn,$sql2_) or die("Query Failed");
                    $image_name_ = "";
                    if(mysqli_num_rows($result2_) > 0) {
                        while($arr__ = mysqli_fetch_assoc($result2_)) {
                            $image_name_ = $arr__["profile_image"];
                        }
                    }
                    $profile_img_text_ = "<img src='img/profile_img/$image_name_'>";
                }

                // $date = date("d/m/Y", $timestamp);
                $date = time_ago($timestamp);
                $date_title = date("l, d F Y",$timestamp)." at ".date("h:i:s A",$timestamp);

                $post_id_enc = sha1($post_id);
                $rection_ele = "<div class='row p-2 rection__emoji_row justify-content-between align-items-center flex-nowrap' style='display:none;' data-p='$post_id_enc'>
                                        <div class='col-10'>
                                            <div class='row show_rection__emoji'>
                                                <div class='col-12 rection_section'>
                                                    <div class='rection___img rection___img_like d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/like.svg'>
                                                        <div class='no_of_like'>0</div>
                                                    </div>
                                                    <div class='rection___img rection___img_love d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/love.svg'>
                                                        <div class='no_of_love'>0</div>
                                                    </div>
                                                    <div class='rection___img rection___img_care d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/care.svg'>
                                                        <div class='no_of_care'>0</div>
                                                    </div>
                                                    <div class='rection___img rection___img_haha d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/haha.svg'>
                                                        <div class='no_of_haha'>0</div>
                                                    </div>
                                                    <div class='rection___img rection___img_wow d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/wow.svg'>
                                                        <div class='no_of_wow'>0</div>
                                                    </div>
                                                    <div class='rection___img rection___img_sad d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/sad.svg'>
                                                        <div class='no_of_sad'>0</div>
                                                    </div>
                                                    <div class='rection___img rection___img_angry d-flex align-items-center justify-content-between'>
                                                        <img src='img/rection_emoji_icon/angry.svg'>
                                                        <div class='no_of_angry'>0</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col d-flex justify-content-end'>
                                            <div class='rection___text' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Total Rection'>0</div>
                                        </div>
                                    </div>";
                
                if ($_FILES['post_image']['error'][0] != 4) {
                    $info["file_upload"] = 1;

                    foreach ($_FILES["post_image"] as $key => $inner_arr) {
                        if ($key == "name") {
                            $file_name = $inner_arr;
                        } else if ($key == "type") {
                            $file_type = $inner_arr;
                        } else if ($key == "tmp_name") {
                            $tmp_name = $inner_arr;
                        }
                    }

                    for ($i = 0; $i < $no_of_file; $i++) {
                        $filename = $file_name[$i];
                        $extension = pathinfo($filename)['extension'];
                        $valid_extension = array("jpg", "jpeg", "png", "gif", "mp4");
                        if (in_array($extension, $valid_extension)) {
                            $file_check_status = 1;
                            $files_name_s .= time() . "_" . mt_rand(1, 10000) . "_" . $file_name[$i] . ",";
                            $info["file_check_status"] = true;
                        } else {
                            $file_check_status = 0;
                            $info["file_check_status"] = "Please choose Allowed File Type(Photo/Video) - jpg,jpeg,png,gif,mp4";
                            break;
                        }
                    }

                    if ($file_check_status == 1) {
                        $files_name_s = substr($files_name_s, 0, (strlen($files_name_s) - 1));
                        $sql = "INSERT INTO post(post_id,post_message,post_img_name,post_privacy,user_id,post_timestamp) VALUES('$post_id','$post_message','$files_name_s','$post_privacy',$user_id,'$timestamp')";
                        mysqli_set_charset($conn,'utf8mb4');

                        mysqli_query($conn, $sql) or die("Query Failed");

                        $file_name = explode(",", $files_name_s);
                        $file_ele = "";
                        $inner_post_file_set = "";

                        for ($i = 0; $i < $no_of_file; $i++) {
                            move_uploaded_file($tmp_name[$i], ("../post_img/" . $file_name[$i]));
                            $file_extension = pathinfo($file_name[$i])['extension'];
                            $img_extension = array("jpg", "jpeg", "png", "gif");
    
                            if (in_array($file_extension, $img_extension)) {
                                $file_ele .= "<img src='post_img/$file_name[$i]'>";
                            } else {
                                $file_ele .= "<video src='post_img/$file_name[$i]' controls></video>";
                            }
                        }
                        $inner_post_file_set = "<div class='row'><div class='col-12 p-2 img_style_post_set'>$file_ele</div></div>";

                        $info['post_data'] = "<div class='row my-4 align-items-center style_post_any'>
                                                <div class='col-12'>
                                                    <div class='row justify-content-start align-items-center position-relative'>
                                                        <div class='col-11 d-flex align-items-center'>
                                                            <div class='me-2'>
                                                                <span class='user_profile_'>
                                                                    $profile_img_text_
                                                                </span>
                                                            </div>
                                                            <div class='d-flex flex-column ms-2'>
                                                                <a href='profile?uid=$user_id' class='user_name_span' target='_blank'>$user_name</a>
                                                                <span class='user_time_icon'><a href='#' class='me-1' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$date_title'>$date</a> <i class='$icon_class_name' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$post_privacy'></i></span>
                                                            </div>
                                                        </div>
                                                    
                                                        <div class='post_delete_ele' data-p = '$post_id_enc'>
                                                            <span class='material-symbols-outlined'>delete</span>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class='row'>
                                                        <div class='col-12 p-2 post__mess_style'>
                                                            $post_message
                                                        </div>
                                                    </div>
                                                    $inner_post_file_set
                                                    $rection_ele
                                                    <div class='row py-2 style_border_add'>
                                                        <div class='col-6 d-flex align-items-center justify-content-center like_div'>
                                                            <div class='like_'>
                                                                <i class='far fa-thumbs-up'></i>
                                                                <span class='ms-1'>Like</span>
                                                            </div>
                                                        </div>
                                                        <div class='col-6 d-flex align-items-center justify-content-center comment_div' data-comment_show_hide_staus='0' data-bs-toggle='tooltip' data-bs-placement='bottom' title='0 comment'>
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
                        $info['success'] = 1;
                    }

                }
                else {
                    $sql = "INSERT INTO post(post_id,post_message,post_privacy,user_id,post_timestamp) VALUES('$post_id','$post_message','$post_privacy',$user_id,'$timestamp')";
                    mysqli_set_charset($conn,'utf8mb4');

                    mysqli_query($conn, $sql) or die("Query Failed");

                    $info['post_data'] = "<div class='row my-4 align-items-center style_post_any'>
                                            <div class='col-12'>
                                                <div class='row justify-content-start align-items-center position-relative'>
                                                    <div class='col-11 d-flex align-items-center'>
                                                        <div class='me-2'>
                                                            <span class='user_profile_'>
                                                                $profile_img_text_
                                                            </span>
                                                        </div>
                                                        <div class='d-flex flex-column ms-2'>
                                                            <a href='profile?uid=$user_id' class='user_name_span' target='_blank'>$user_name</a>
                                                            <span class='user_time_icon'><a href='#' class='me-1' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$date_title'>$date</a> <i class='$icon_class_name' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$post_privacy'></i></span>
                                                        </div>
                                                    </div>
                                                
                                                    <div class='post_delete_ele' data-p = '$post_id_enc'>
                                                        <span class='material-symbols-outlined'>delete</span>
                                                    </div>
                                                    
                                                </div>
                                                <div class='row'>
                                                    <div class='col-12 p-2 post__mess_style'>
                                                        $post_message
                                                    </div>
                                                </div>
                                                $rection_ele
                                                <div class='row py-2 style_border_add'>
                                                    <div class='col-6 d-flex align-items-center justify-content-center like_div'>
                                                        <div class='like_'>
                                                            <i class='far fa-thumbs-up'></i>
                                                            <span class='ms-1'>Like</span>
                                                        </div>
                                                    </div>
                                                    <div class='col-6 d-flex align-items-center justify-content-center comment_div' data-comment_show_hide_staus='0' data-bs-toggle='tooltip' data-bs-placement='bottom' title='0 comment'>
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
                    $info['success'] = 1;
                }
                
                $sql_total_post = "SELECT COUNT(post_id) AS post_count FROM post WHERE user_id=$user_id";
                $result_total_post = mysqli_query($conn,$sql_total_post) or die("Query Failed total_post");

                $arr_result_total_post = mysqli_fetch_assoc($result_total_post);

                $post_count = $arr_result_total_post['post_count'] - 1;
                
                if($post_count > 0) {
                    $info['total_post'] = 1;
                }
                else {
                    $info['total_post'] = 0;
                }
            }
            mysqli_close($conn);
        }
        else {
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>