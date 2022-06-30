<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();

        if (isset($_POST["comment_data"]) && isset($_POST["post_id"])) {
            $info['error'] = 1;
            require_once "../conn.php";
            require "time_ago_f.php";
            require "calculate_num_.php";

            $conn = connected() or die("Connection Failed");

            $comment_data = trim($_POST['comment_data']);
            $post_id = mysqli_real_escape_string($conn,$_POST['post_id']);


            // if(str_ends_with($comment_data,"<div><br></div>")) {
            //     $em = strlen($comment_data) - strlen("<div><br></div>");

            //     // "hello i<div><br></div>"//22//15//7
            //     $comment_data = substr($comment_data,0,$em);
            // }

            if (!isset($_SESSION)) {
                session_start();
            }
            $user_id = $_SESSION["user_id"];
            $user_name = $_SESSION["user_name"];

            $sql = "SELECT post_id,post_privacy,user_id FROM post";

            $result = mysqli_query($conn,$sql) or die("Query Failed");

            $post__id = "";
            $post_status = 0;
            $current_post_user_id = "";
            $post_privacy = "";

            if(mysqli_num_rows($result) > 0) {
                while($arr = mysqli_fetch_assoc($result)) {
                    $post_id_enc = sha1($arr['post_id']);
                    if($post_id == $post_id_enc) {
                        $post__id = $arr['post_id'];
                        $current_post_user_id = $arr['user_id'];
                        $post_privacy = $arr['post_privacy'];
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

                        // comment data checker
                        if ($comment_data == "" || $comment_data == "<div><br></div>") {
                            $info['comment_data'] = "Type a Comment";
                        }
                        else if(preg_match("/^[<div><br><\/div,\s,&nbsp;]+$/",$comment_data)) {
                            $info['comment_data'] = "Type a Comment";
                        }
                        else {
                            $info['comment_data'] = true;

                            if(str_ends_with($comment_data,"<div><br></div>")) {
                                $em = strlen($comment_data) - strlen("<div><br></div>");
                
                                $comment_data = substr($comment_data,0,$em);
                            }
                            if(str_ends_with($comment_data,"<div></div>")) {
                                $em = strlen($comment_data) - strlen("<div></div>");
                
                                $comment_data = substr($comment_data,0,$em);
                            }
                            
                            $comment_id = time()."_comment_" . mt_rand(100, 100000) . "_" . mt_rand(200, 90000)."_".date("s");
                            $comment_id_enc = sha1($comment_id);

                            date_default_timezone_set("Asia/Kolkata");
                            $date = time();

                            $sql_insert_comment_data = "INSERT INTO post_comment(comment_id,comment_description,post_id,user_id,comment_time) VALUES('$comment_id','$comment_data','$post__id',$user_id,'$date')";
                            mysqli_set_charset($conn,'utf8mb4');
                            mysqli_query($conn,$sql_insert_comment_data) or die(mysqli_error($conn)." Query Failed insert_comment_data");

                            $date_title = date("l, d F Y",$date)." at ".date("h:i:s A",$date);
                            $date = time_ago($date);

                            $sql_get_login_user_details = "SELECT user_name,image_type,profile_image FROM user WHERE user_id=$user_id";
                            $result_get_login_user_details = mysqli_query($conn,$sql_get_login_user_details) or die("Query Failed get_login_user_details");
                            $arr_get_login_user_details = mysqli_fetch_assoc($result_get_login_user_details);

                            $user_profile_img_text__comment__style = "";

                            if($arr_get_login_user_details['image_type'] == "text") {
                                $ch = strtoupper(substr(explode(" ",$arr_get_login_user_details["user_name"])[0],0,1));
                                $user_profile_img_text__comment__style = "<div class='comment_user_profile_img_text__style_'>$ch</div>";
                            }
                            else {
                                $user_profile_img_text__comment__style = "<img src='img/profile_img/{$arr_get_login_user_details["profile_image"]}'>";
                            }

                            $info['comment_description'] = "<div class='row mt-3'>
                                                                <span class='p-0 comment_user_profile__style d-flex justify-content-center align-items-center'>
                                                                    $user_profile_img_text__comment__style
                                                                </span>
                                                                <span class='p-0 comment__details'>
                                                                    <span class='comment__details_style comment__details_style_margin_r'>
                                                                        <div class='name_of_user_who_comment'><a href='profile?uid=$user_id' target='_blank'>$user_name</a></div>
                                                                        <div class='comment__description'>$comment_data</div>
                                                                        <div class='comment_date_time_p_ele d-flex justify-content-end align-items-center'>
                                                                            <div class='comment_date_time_ele' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$date_title'>$date</div>
                                                                        </div>
                                                                        <div class='delete_comment_btn' data-cid='$comment_id_enc'>
                                                                            <span class='material-symbols-outlined'>delete</span>
                                                                        </div>
                                                                    </span>
                                                                </span>
                                                            </div>";
                            
                            $sql_get_comment = "SELECT total_comment_in_post FROM post WHERE post_id='$post__id'";
                            $result_get_comment = mysqli_query($conn,$sql_get_comment) or die("Query Failed get_comment");
                            $total_comment = 0;
                            if(mysqli_num_rows($result_get_comment)>0) {
                                $arr_get_comment = mysqli_fetch_assoc($result_get_comment);

                                $total_comment = $arr_get_comment['total_comment_in_post'];
                            }

                            $info["total_comment"] = $total_comment;

                            $total_comment = $total_comment + 1;

                            $info['comment_title'] = cal_num_($total_comment,"comment");

                            $sql_update_total_comment = "UPDATE post SET total_comment_in_post=$total_comment WHERE post_id='$post__id'";
                            mysqli_query($conn,$sql_update_total_comment) or die("Query Failed update_total_comment");
                        }
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
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>