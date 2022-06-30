<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['action_name']) && isset($_POST['current_user_id'])) {
            $info["error"] = 1;

            require_once "../conn.php";
            require "calculate_num_.php";
            $conn = connected() or die("Connection Failed");
            $action_name = mysqli_real_escape_string($conn,$_POST['action_name']);
            $current_user_id = mysqli_real_escape_string($conn,$_POST['current_user_id']);

            $valid_action_name = 0;

            date_default_timezone_set("Asia/Kolkata");


            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION["user_id"];
            $login_user_name = $_SESSION['user_name'];

            $sql_s = "SELECT user_name FROM user WHERE (user_id = $current_user_id AND user_id!=$login_user_id)";
            $result_s = mysqli_query($conn,$sql_s) or die("Query Failed");
            if(mysqli_num_rows($result_s) == 1) {
                $info['current_user_search_status'] = true;

                if($action_name == "Add Friend" || $action_name == "Cancel Friend Request" || $action_name == "Accept Friend Request" || $action_name == "friends") {
                    $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$login_user_id AND to_user_id=$current_user_id)";
                    $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
                    if(mysqli_num_rows($result_request_friend_status) > 0) {
                        $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
                        if($arr_request_friend_status['action_name'] == $action_name) {
                            $valid_action_name = 1;
                        }
                        else {
                            $valid_action_name = 0;
                            $info["error"] = 0;
                        }
                    }
                    else if($action_name == "Add Friend") {
                        $valid_action_name = 1;
                    }
                    else {
                        $valid_action_name = 0;
                        $info["error"] = 0;
                    }
                }
                else {
                    $valid_action_name = 0;
                    $info["error"] = 0;
                }

                if($valid_action_name == 1) {
                    $date = time();
                    if($action_name == "Add Friend") {
                        $sql1 = "INSERT INTO request_friend(from_user_id,to_user_id,action_name) VALUES($login_user_id,$current_user_id,'Cancel Friend Request')";
                        $sql2 = "INSERT INTO request_friend(from_user_id,to_user_id,action_name) VALUES($current_user_id,$login_user_id,'Accept Friend Request')";

                        $sql3 = "INSERT INTO notification(from_send_notification_user_id,to_receive_notification_user_id,notification_name,notification_date_time) VALUES($login_user_id,$current_user_id,'<b>$login_user_name</b> Send a Friend Request To You.','$date')";

                        mysqli_query($conn,$sql1) or die("Query Failed sql1");
                        mysqli_query($conn,$sql2) or die("Query Failed sql2");
                        mysqli_query($conn,$sql3) or die("Query Failed sql3");

                        $info['action_name'] = "Cancel Friend Request";
                        $info['icon_request_ele'] = "<i class='bi bi-person-x'>";
                    }
                    else if($action_name == "Cancel Friend Request") {
                        $sql1 = "DELETE FROM request_friend WHERE (from_user_id=$login_user_id AND to_user_id=$current_user_id)";
                        $sql2 = "DELETE FROM request_friend WHERE (from_user_id=$current_user_id AND to_user_id=$login_user_id)";

                        $sql3 = "DELETE FROM notification WHERE (from_send_notification_user_id=$login_user_id AND to_receive_notification_user_id=$current_user_id)";

                        mysqli_query($conn,$sql1) or die("Query Failed sql1");
                        mysqli_query($conn,$sql2) or die("Query Failed sql2");
                        mysqli_query($conn,$sql3) or die("Query Failed sql3");

                        $info['action_name'] = "Add Friend";
                        $info['icon_request_ele'] = "<i class='bi bi-person-plus'>";
                    }
                    else if($action_name == "Accept Friend Request") {
                        $sql1 = "UPDATE request_friend SET action_name='friends' WHERE (from_user_id=$login_user_id AND to_user_id=$current_user_id)";
                        $sql2 = "UPDATE request_friend SET action_name='friends' WHERE (from_user_id=$current_user_id AND to_user_id=$login_user_id)";

                        $sql3 = "INSERT INTO notification(from_send_notification_user_id,to_receive_notification_user_id,notification_name,notification_date_time) VALUES($login_user_id,$current_user_id,'<b>$login_user_name</b> Accept Your Friend Request.','$date')";

                        mysqli_query($conn,$sql1) or die("Query Failed sql1");
                        mysqli_query($conn,$sql2) or die("Query Failed sql2");
                        mysqli_query($conn,$sql3) or die("Query Failed sql3");

                        $sql_login_user = "SELECT total_friends FROM user WHERE user_id=$login_user_id";
                        $sql_current_user = "SELECT total_friends FROM user WHERE user_id=$current_user_id";

                        $result_login_user = mysqli_query($conn,$sql_login_user) or die("Query Failed login_user");
                        $result_current_user = mysqli_query($conn,$sql_current_user) or die("Query Failed current_user");

                        $arr_login_user = mysqli_fetch_assoc($result_login_user);
                        $arr_current_user = mysqli_fetch_assoc($result_current_user);

                        $login_user_total_friend = $arr_login_user['total_friends'] + 1;
                        $current_user_total_friend = $arr_current_user['total_friends'] + 1;

                        $sql_update_login_user = "UPDATE user SET total_friends=$login_user_total_friend WHERE user_id=$login_user_id";
                        $sql_update_current_user = "UPDATE user SET total_friends=$current_user_total_friend WHERE user_id=$current_user_id";

                        mysqli_query($conn,$sql_update_login_user) or die("Query Failed update_login_user");
                        mysqli_query($conn,$sql_update_current_user) or die("Query Failed update_current_user");

                        $info['action_name'] = "friends";
                        $info['icon_request_ele'] = "<i class='bi bi-person-check'>";
                    }
                    else if($action_name == "friends") {
                        $sql1 = "DELETE FROM request_friend WHERE (from_user_id=$login_user_id AND to_user_id=$current_user_id)";
                        $sql2 = "DELETE FROM request_friend WHERE (from_user_id=$current_user_id AND to_user_id=$login_user_id)";

                        $sql3 = "DELETE FROM notification WHERE (from_send_notification_user_id=$login_user_id AND to_receive_notification_user_id=$current_user_id)";
                        $sql4 = "DELETE FROM notification WHERE (from_send_notification_user_id=$current_user_id AND to_receive_notification_user_id=$login_user_id)";

                        mysqli_query($conn,$sql1) or die("Query Failed sql1");
                        mysqli_query($conn,$sql2) or die("Query Failed sql2");
                        mysqli_query($conn,$sql3) or die("Query Failed sql3");
                        mysqli_query($conn,$sql4) or die("Query Failed sql4");

                        $sql_login_user = "SELECT total_friends FROM user WHERE user_id=$login_user_id";
                        $sql_current_user = "SELECT total_friends FROM user WHERE user_id=$current_user_id";

                        $result_login_user = mysqli_query($conn,$sql_login_user) or die("Query Failed login_user");
                        $result_current_user = mysqli_query($conn,$sql_current_user) or die("Query Failed current_user");

                        $arr_login_user = mysqli_fetch_assoc($result_login_user);
                        $arr_current_user = mysqli_fetch_assoc($result_current_user);

                        $login_user_total_friend = $arr_login_user['total_friends'] - 1;
                        $current_user_total_friend = $arr_current_user['total_friends'] - 1;

                        $sql_update_login_user = "UPDATE user SET total_friends=$login_user_total_friend WHERE user_id=$login_user_id";
                        $sql_update_current_user = "UPDATE user SET total_friends=$current_user_total_friend WHERE user_id=$current_user_id";

                        mysqli_query($conn,$sql_update_login_user) or die("Query Failed update_login_user");
                        mysqli_query($conn,$sql_update_current_user) or die("Query Failed update_current_user");

                        $info['action_name'] = "Add Friend";
                        $info['icon_request_ele'] = "<i class='bi bi-person-plus'>";

                        $sql_get_user_rection_in_post1 = "SELECT post_id,rection_type FROM user_rection_in_post WHERE user_id=$login_user_id";

                        $sql_get_user_rection_in_post2 = "SELECT post_id,rection_type FROM user_rection_in_post WHERE user_id=$current_user_id";

                        $result_get_user_rection_in_post1 = mysqli_query($conn,$sql_get_user_rection_in_post1) or die("Query Failed get_user_rection_in_post1");
                        $result_get_user_rection_in_post2 = mysqli_query($conn,$sql_get_user_rection_in_post2) or die("Query Failed get_user_rection_in_post2");

                        if(mysqli_num_rows($result_get_user_rection_in_post1)>0) {
                            while($arr_get_user_rection_in_post1 = mysqli_fetch_assoc($result_get_user_rection_in_post1)) {
                                $post_id = $arr_get_user_rection_in_post1['post_id'];
                                $rection_type = $arr_get_user_rection_in_post1['rection_type'];
                                if($rection_type == "like") {
                                    $rection_type = "like_";
                                }

                                $sql_get_user = "SELECT user_id,$rection_type,total_rection_count FROM post WHERE (post_id='$post_id' AND post_privacy='friends')";

                                $result_get_user = mysqli_query($conn,$sql_get_user) or die(mysqli_error($conn)." Query Failed get_user");

                                if(mysqli_num_rows($result_get_user)>0) {
                                    $arr_get_user = mysqli_fetch_assoc($result_get_user);
    
                                    if(($arr_get_user['user_id'] != $login_user_id) && ($arr_get_user['user_id'] == $current_user_id)) {
                                        $total_selectd_rection = $arr_get_user[$rection_type] - 1;
                                        $total_rection_count = $arr_get_user['total_rection_count'] - 1;
    
                                        $sql_update_user_details = "UPDATE post SET $rection_type=$total_selectd_rection,total_rection_count=$total_rection_count WHERE (post_id='$post_id' AND post_privacy='friends')";
    
                                        mysqli_query($conn,$sql_update_user_details) or die("Query Failed sql_update_user_details");
    
                                        $sql_delete_user_rection_in_post = "DELETE FROM user_rection_in_post WHERE (post_id='$post_id' AND user_id=$login_user_id)";
    
                                        mysqli_query($conn,$sql_delete_user_rection_in_post) or die("Query Failed sql_delete_user_rection_in_post");
                                    }
                                }

                            }
                        }

                        if(mysqli_num_rows($result_get_user_rection_in_post2)>0) {
                            while($arr_get_user_rection_in_post2 = mysqli_fetch_assoc($result_get_user_rection_in_post2)) {
                                $post_id = $arr_get_user_rection_in_post2['post_id'];
                                $rection_type = $arr_get_user_rection_in_post2['rection_type'];
                                if($rection_type == "like") {
                                    $rection_type = "like_";
                                }

                                $sql_get_user = "SELECT user_id,$rection_type,total_rection_count FROM post WHERE (post_id='$post_id' AND post_privacy='friends')";

                                $result_get_user = mysqli_query($conn,$sql_get_user) or die(mysqli_error($conn)." Query Failed get_user");

                                if(mysqli_num_rows($result_get_user)>0) {
                                    $arr_get_user = mysqli_fetch_assoc($result_get_user);
    
                                    if(($arr_get_user['user_id'] != $current_user_id) && ($arr_get_user['user_id'] == $login_user_id)) {
                                        $total_selectd_rection = $arr_get_user[$rection_type] - 1;
                                        $total_rection_count = $arr_get_user['total_rection_count'] - 1;
    
                                        $sql_update_user_details = "UPDATE post SET $rection_type=$total_selectd_rection,total_rection_count=$total_rection_count WHERE (post_id='$post_id' AND post_privacy='friends')";
    
                                        mysqli_query($conn,$sql_update_user_details) or die("Query Failed sql_update_user_details");
    
                                        $sql_delete_user_rection_in_post = "DELETE FROM user_rection_in_post WHERE (post_id='$post_id' AND user_id=$current_user_id)";
    
                                        mysqli_query($conn,$sql_delete_user_rection_in_post) or die("Query Failed sql_delete_user_rection_in_post");
                                    }
                                }

                            }
                        }

                        $sqli_get_comment_d_1 = "SELECT post_id FROM post_comment WHERE user_id=$login_user_id";
                        $sqli_get_comment_d_2 = "SELECT post_id FROM post_comment WHERE user_id=$current_user_id";

                        $result_get_comment_d_1 = mysqli_query($conn,$sqli_get_comment_d_1) or die("Query Failed get_comment_d_1");
                        $result_get_comment_d_2 = mysqli_query($conn,$sqli_get_comment_d_2) or die("Query Failed get_comment_d_2");

                        if(mysqli_num_rows($result_get_comment_d_1)>0) {
                            while($arr_get_comment_d = mysqli_fetch_assoc($result_get_comment_d_1)) {
                                $post_id = $arr_get_comment_d['post_id'];

                                $sql_get_user = "SELECT user_id,total_comment_in_post FROM post WHERE (post_id='$post_id' AND post_privacy='friends')";

                                $result_get_user = mysqli_query($conn,$sql_get_user) or die(mysqli_error($conn)." Query Failed get_user");

                                if(mysqli_num_rows($result_get_user)>0) {
                                    $arr_get_user = mysqli_fetch_assoc($result_get_user);

                                    if(($arr_get_user['user_id'] != $login_user_id) && ($arr_get_user['user_id'] == $current_user_id)) {
                                        $total_comment_in_post = $arr_get_user['total_comment_in_post'] - 1;

                                        $sql_update_user_details = "UPDATE post SET total_comment_in_post=$total_comment_in_post WHERE (post_id='$post_id' AND post_privacy='friends')";
                                        mysqli_query($conn,$sql_update_user_details) or die("Query Failed sql_update_user_details");

                                        $sql_delete_user_comment_in_post = "DELETE FROM post_comment WHERE post_id='$post_id' AND user_id=$login_user_id";
    
                                        mysqli_query($conn,$sql_delete_user_comment_in_post) or die("Query Failed delete_user_comment_in_post");
                                    }
                                }
                            }
                        }

                        if(mysqli_num_rows($result_get_comment_d_2)>0) {
                            while($arr_get_comment_d = mysqli_fetch_assoc($result_get_comment_d_2)) {
                                $post_id = $arr_get_comment_d['post_id'];

                                $sql_get_user = "SELECT user_id,total_comment_in_post FROM post WHERE (post_id='$post_id' AND post_privacy='friends')";

                                $result_get_user = mysqli_query($conn,$sql_get_user) or die(mysqli_error($conn)." Query Failed get_user");

                                if(mysqli_num_rows($result_get_user)>0) {
                                    $arr_get_user = mysqli_fetch_assoc($result_get_user);

                                    if(($arr_get_user['user_id'] != $current_user_id) && ($arr_get_user['user_id'] == $login_user_id)) {
                                        $total_comment_in_post = $arr_get_user['total_comment_in_post'] - 1;

                                        $sql_update_user_details = "UPDATE post SET total_comment_in_post=$total_comment_in_post WHERE (post_id='$post_id' AND post_privacy='friends')";
                                        mysqli_query($conn,$sql_update_user_details) or die("Query Failed sql_update_user_details");

                                        $sql_delete_user_comment_in_post = "DELETE FROM post_comment WHERE post_id='$post_id' AND user_id=$current_user_id";
    
                                        mysqli_query($conn,$sql_delete_user_comment_in_post) or die("Query Failed delete_user_comment_in_post");
                                    }
                                }
                            }
                        }
                    }
                    $sql_get_total_no_of_friend = "SELECT total_friends FROM user WHERE user_id=$current_user_id";
                    $result_get_total_no_of_friend = mysqli_query($conn,$sql_get_total_no_of_friend) or die("Query Failed get_total_no_of_friend");
                    $arr_get_total_no_of_friend = mysqli_fetch_assoc($result_get_total_no_of_friend);

                    
                    $info['total_no_of_friend'] = cal_num_($arr_get_total_no_of_friend['total_friends'],"friend");

                }
            }
            else {
                $info['current_user_search_status'] = "Something Went Wrong | Not Valid User | Reload The Page";
            }
            mysqli_close($conn);
        }
        else {
            $info["error"] = 0;
        }
        echo json_encode($info);
    }
?>