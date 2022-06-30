<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if (isset($_POST["comment_id"]) && isset($_POST["post_id"])) {
            require_once "../conn.php";
            require "calculate_num_.php";
            $conn = connected() or die("Connection Failed");
            $post_id = mysqli_real_escape_string($conn,trim($_POST['post_id']));
            $comment_id = mysqli_real_escape_string($conn,trim($_POST['comment_id']));

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
                        $sql_comment_d = "SELECT comment_id FROM post_comment WHERE user_id=$user_id";

                        $result_comment_d = mysqli_query($conn,$sql_comment_d) or die("Query Failed comment_d");

                        if(mysqli_num_rows($result_comment_d) > 0) {
                            $comment__id = "";
                            $comment_status = 0;
                            while($arr_comment_d = mysqli_fetch_assoc($result_comment_d)) {
                                $comment_id_enc = sha1($arr_comment_d['comment_id']);
                                if($comment_id == $comment_id_enc) {
                                    $comment__id = $arr_comment_d['comment_id'];
                                    $comment_status = 1;
                                    break;
                                }
                            }
                            if($comment_status == 1) {
                                $info["error"] = 1;

                                $sql_delete_post_comment = "DELETE FROM post_comment WHERE comment_id='$comment__id'";
                                mysqli_query($conn,$sql_delete_post_comment) or die("Query Failed delete_post_comment");

                                $total_comment_in_post = $total_comment_in_post - 1;

                                $sql_post_update = "UPDATE post SET total_comment_in_post=$total_comment_in_post WHERE post_id='$post__id'";
                                mysqli_query($conn,$sql_post_update) or die("Query Failed post_update");

                                $info['total_comment_in_post'] = $total_comment_in_post;

                                if($total_comment_in_post == 0) {
                                    $info["comment_des"] = "<div class='row mt-3 justify-content-center align-items-center no_comment_found_ele'>
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