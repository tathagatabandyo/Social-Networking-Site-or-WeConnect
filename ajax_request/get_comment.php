<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if (isset($_POST["post_id"])) {
            require_once "../conn.php";
            require "time_ago_f.php";
            require "calculate_num_.php";

            $conn = connected() or die("Connection Failed");
            $post_id = mysqli_real_escape_string($conn,$_POST['post_id']);

            if(!isset($_SESSION)) {
                session_start();
            }
            $user_id = $_SESSION["user_id"];
            
            $sql = "SELECT post_id,post_privacy,user_id,total_comment_in_post FROM post";

            $result = mysqli_query($conn,$sql) or die("Query Failed");

            $post__id = "";
            $post_status = 0;
            $current_post_user_id = "";
            $post_privacy = "";
            $total_comment_in_post = 0;
            
            if(mysqli_num_rows($result) > 0) {
                while($arr = mysqli_fetch_assoc($result)) {
                    $post_id_enc = sha1($arr['post_id']);
                    if($post_id == $post_id_enc) {
                        $post__id = $arr['post_id'];
                        $current_post_user_id = $arr['user_id'];
                        $post_privacy = $arr['post_privacy'];
                        $total_comment_in_post = $arr['total_comment_in_post'];
                        $post_status = 1;
                        break;
                    }
                }
                if($post_status == 1) {
                    $info["error"] = 1;

                    $login_user_id = $user_id;

                    if($post_privacy == "public") {
                        $valid_post_ = 1;
                    }
                    else if($post_privacy == "only_me") {
                        if($login_user_id == $current_post_user_id) {
                            $valid_post_ = 1;
                        }
                        else {
                            $valid_post_ = 0;
                        }
                    }
                    else {
                        if($login_user_id == $current_post_user_id) {
                            $valid_post_ = 1;
                        }
                        else {
                            $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$current_post_user_id AND to_user_id=$login_user_id)";
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
                        $sql_get_comment = "SELECT * FROM post_comment WHERE post_id='$post__id' ORDER BY comment_si_no DESC";
                        mysqli_set_charset($conn,'utf8mb4');
                        $result_get_comment = mysqli_query($conn,$sql_get_comment) or die("Query Failed get_comment");
                        if(mysqli_num_rows($result_get_comment)>0) {
                            $post_comment = "";
                            while($arr_get_comment = mysqli_fetch_assoc($result_get_comment)) {
                                

                                $sql_current_comment_user_details = "SELECT user_name,image_type,profile_image FROM user WHERE user_id={$arr_get_comment['user_id']}";
                                mysqli_set_charset($conn,'utf8mb4');
                                $result_current_comment_user_details = mysqli_query($conn,$sql_current_comment_user_details) or die("Query Failed current_comment_user_details");

                                $arr_current_comment_user_details = mysqli_fetch_assoc($result_current_comment_user_details);

                                $user_profile_img_text__comment__style = "";
                                
                                if($arr_current_comment_user_details['image_type'] == "text") {
                                    $ch = strtoupper(substr(explode(" ",$arr_current_comment_user_details["user_name"])[0],0,1));
                                    $user_profile_img_text__comment__style = "<div class='comment_user_profile_img_text__style_'>$ch</div>";
                                }
                                else {
                                    $user_profile_img_text__comment__style = "<img src='img/profile_img/{$arr_current_comment_user_details["profile_image"]}'>";
                                }

                                $comment_delete_ele = "";
                                $css_class_name_ = "";
                                if($user_id == $arr_get_comment['user_id']) {
                                    $comment_id_enc = sha1($arr_get_comment['comment_id']);
                                    $css_class_name_ = "comment__details_style_margin_r";
                                    $comment_delete_ele = "<div class='delete_comment_btn' data-cid='$comment_id_enc'>
                                                                <span class='material-symbols-outlined'>delete</span>
                                                            </div>";
                                }

                                $date = time_ago($arr_get_comment['comment_time']);
                                $date_title = date("l, d F Y",$arr_get_comment['comment_time'])." at ".date("h:i:s A",$arr_get_comment['comment_time']);

                                $post_comment .= "<div class='row mt-3'>
                                                    <span class='p-0 comment_user_profile__style d-flex justify-content-center align-items-center'>
                                                        $user_profile_img_text__comment__style
                                                    </span>
                                                    <span class='p-0 comment__details'>
                                                        <span class='comment__details_style $css_class_name_'>
                                                            <div class='name_of_user_who_comment'><a href='profile?uid={$arr_get_comment['user_id']}' target='_blank'>{$arr_current_comment_user_details["user_name"]}</a></div>
                                                            <div class='comment__description'>{$arr_get_comment['comment_description']}</div>
                                                            <div class='comment_date_time_p_ele d-flex justify-content-end align-items-center'>
                                                                <div class='comment_date_time_ele' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$date_title'>$date</div>
                                                            </div>
                                                            $comment_delete_ele
                                                        </span>
                                                    </span>
                                                </div>";
                            }
                            $info['post_comment'] = $post_comment;
                        }
                        else {
                            $info['post_comment'] = "<div class='row mt-3 justify-content-center align-items-center no_comment_found_ele'>
                                                        No Comment found
                                                    </div>";
                        }
                        $info['comment_title'] = cal_num_($total_comment_in_post,"comment");
                    }
                    else {
                        $info["error"] = 0;
                    }
                }
                else {
                    $info["error"] = 0;
                }
            }
            else {
                $info["error"] = 0;
            }
            mysqli_close($conn);
        }
        else {
            $info["error"] = 0;
        }
        echo json_encode($info);
    }
?>