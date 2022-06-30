<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if (isset($_POST["post_id"])) {
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $post_id = mysqli_real_escape_string($conn,$_POST['post_id']);

            if(!isset($_SESSION)) {
                session_start();
            }
            $user_id = $_SESSION["user_id"];
            $info["rection_state"] = "";

            // $sql = "SELECT post_id,post_privacy,user_id FROM post WHERE post_privacy = 'public' OR (user_id = $user_id AND post_privacy = 'only_me')";
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

                    $valid_post_ = 0;

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
                        $sql2 = "SELECT * FROM user_rection_in_post WHERE post_id = '$post__id' AND user_id = $user_id";
                        $result2 = mysqli_query($conn,$sql2) or die("Query Failed2");
                        if(mysqli_num_rows($result2) == 1) {
                            $info["rection_state"] = false;
    
                            $arr_2 = mysqli_fetch_assoc($result2);
                            $rection_type = $arr_2['rection_type'];
                            $rection_column_name = "";
                            if($rection_type == "like") {
                                $rection_column_name = "like_";
                            }
                            else if($rection_type == "love") {
                                $rection_column_name = "love";
                            }
                            else if($rection_type == "care") {
                                $rection_column_name = "care";
                            }
                            else if($rection_type == "haha") {
                                $rection_column_name = "haha";
                            }
                            else if($rection_type == "wow") {
                                $rection_column_name = "wow";
                            }
                            else if($rection_type == "sad") {
                                $rection_column_name = "sad";
                            }
                            else if($rection_type == "angry") {
                                $rection_column_name = "angry";
                            }
    
                            $sql_3 = "SELECT total_rection_count,$rection_column_name FROM post WHERE post_id = '$post__id'";
                            $result_3 = mysqli_query($conn,$sql_3) or die("Query Failed_3");
    
                            if(mysqli_num_rows($result_3) == 1) {
                                $arr = mysqli_fetch_assoc($result_3);
                                $total_r_any_count =  $arr[$rection_column_name];
                                $total_rection_count =  $arr['total_rection_count'];
    
                                $total_r_any_count = $total_r_any_count - 1;
                                $total_rection_count = $total_rection_count - 1;
    
                                $sql_4 = "UPDATE post SET $rection_column_name = $total_r_any_count,total_rection_count = $total_rection_count WHERE post_id = '$post__id'";
    
                                mysqli_query($conn,$sql_4) or die("Query Failed_4");
    
                                $sql_5 = "DELETE FROM user_rection_in_post WHERE post_id = '$post__id' AND user_id = $user_id";
                                mysqli_query($conn,$sql_5) or die("Query Failed_5");
    
                                // echo $total_r_any_count." ".$total_rection_count;
                            }                        
    
                        }
                        else {
                            $info["rection_state"] = true;
    
                            $sql3 = "SELECT total_rection_count,like_ FROM post WHERE post_id = '$post__id'";
                            $result3 = mysqli_query($conn,$sql3) or die("Query Failed3");
                            if(mysqli_num_rows($result3) == 1) {
                                $arr = mysqli_fetch_assoc($result3);
                                $total_like_count =  $arr['like_'];
                                $total_rection_count =  $arr['total_rection_count'];
    
                                $total_like_count = $total_like_count + 1;
                                $total_rection_count = $total_rection_count + 1;
    
                                $sql4 = "UPDATE post SET like_ = $total_like_count,total_rection_count = $total_rection_count WHERE post_id = '$post__id'";
    
                                mysqli_query($conn,$sql4) or die("Query Failed4");
    
                                $sql5 = "INSERT INTO user_rection_in_post(post_id,rection_type,user_id) VALUES('$post__id','like',$user_id)";
                                mysqli_query($conn,$sql5) or die("Query Failed5");
    
                                // echo $total_like_count." ".$total_rection_count;
                            }
                        }
    
                        $sql_g = "SELECT total_rection_count,like_,love,care,haha,wow,sad,angry FROM post WHERE post_id = '$post__id'";
                        $result_g = mysqli_query($conn,$sql_g) or die("Query Failed_g");
                        if(mysqli_num_rows($result_g) == 1) {
                            $arr_g = mysqli_fetch_assoc($result_g);
                            $info["like"] = $arr_g['like_'];
                            $info["love"] = $arr_g['love'];
                            $info["care"] = $arr_g['care'];
                            $info["haha"] = $arr_g['haha'];
                            $info["wow"] = $arr_g['wow'];
                            $info["sad"] = $arr_g['sad'];
                            $info["angry"] = $arr_g['angry'];
                            $info["total_rection_count"] = $arr_g['total_rection_count'];
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