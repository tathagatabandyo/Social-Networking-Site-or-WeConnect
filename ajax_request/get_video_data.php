<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        require_once "../conn.php";
        $conn = connected() or die("Connection Failed");
        
        date_default_timezone_set("Asia/Kolkata");

        if(!isset($_SESSION)) {
            session_start();
        }
        $user_id = $_SESSION["user_id"];

        $q = "SELECT post.post_img_name,post.post_privacy,post.user_id FROM post ORDER BY post_si_no DESC";

        $result = mysqli_query($conn,$q) or die("Query Failed");

        
        if(mysqli_num_rows($result)>0) {
            $video_arr = array();
            $i = 0;
            $all_video_data = "";
            while($arr = mysqli_fetch_assoc($result)) {
                $post_img_video_name = $arr['post_img_name'];

                if($arr['user_id'] == $user_id) {

                    if($post_img_video_name != "") {
                        $post_img_video_arr = explode(",",$post_img_video_name);

                        foreach($post_img_video_arr as $img_video__name) {
                            $file_extension = explode(".",$img_video__name)[1];
                            $video_extension = array("mp4");
                            if(in_array($file_extension,$video_extension)) {
                                
                                $all_video_data .= "<div class='row my-4'>
                                                        <div class='col-12 d-flex justify-content-center watch__video_specific__user'>
                                                            <video src='post_img/$img_video__name' controls=''></video>
                                                        </div>
                                                    </div>";

                                $video_arr[$i] = $img_video__name;
                                $i++;
                            }
                        }
                    }
                }
                else {
                    if($arr['post_privacy'] == "only_me") {
                        continue;
                    }
                    else if($arr['post_privacy'] == "friends") {
                        $current_post_user_id =  $arr['user_id'];
                        $login_user_id = $user_id;

                        $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$current_post_user_id AND to_user_id=$login_user_id)";
                        $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
                        if(mysqli_num_rows($result_request_friend_status) > 0) {
                            $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
                            if($arr_request_friend_status['action_name'] == "friends") {
                                
                            }
                            else {
                                continue;
                            }
                        }
                        else {
                            continue;
                        }
                    }
                    if($post_img_video_name != "") {
                        $post_img_video_arr = explode(",",$post_img_video_name);

                        foreach($post_img_video_arr as $img_video__name) {
                            $file_extension = explode(".",$img_video__name)[1];
                            $video_extension = array("mp4");
                            if(in_array($file_extension,$video_extension)) {
                                
                                $all_video_data .= "<div class='row my-4'>
                                                            <div class='col-12 d-flex justify-content-center watch__video_specific__user'>
                                                                <video src='post_img/$img_video__name' controls=''></video>
                                                            </div>
                                                    </div>";

                                $video_arr[$i] = $img_video__name;
                                $i++;
                            }
                        }
                    }
                }
            }
            if(count($video_arr) > 0) {

                echo "<div class='col-12'>
                            $all_video_data
                        </div>";
            }
            else {
                echo "<div class='col-12'>
                        <div class='row my-4'>
                            <div class='col-12 d-flex justify-content-center watch__video_specific__user'>
                                <div class='no_found_video_watch'>
                                    No Video Found
                                </div>
                            </div>
                        </div>
                    </div>";
            }
            
        }
        else {
            echo "<div class='col-12'>
                        <div class='row my-4'>
                            <div class='col-12 d-flex justify-content-center watch__video_specific__user'>
                                <div class='no_found_video_watch'>
                                    No Video Found
                                </div>
                            </div>
                        </div>
                    </div>";
        }
        mysqli_close($conn);
    }
?>