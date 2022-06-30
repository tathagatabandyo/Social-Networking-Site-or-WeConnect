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

                $sql_get_image = "SELECT post_id,post_privacy,post_img_name FROM post WHERE user_id = $current_user_id ORDER BY post_si_no DESC";

                $result_get_image = mysqli_query($conn,$sql_get_image) or die("Query Failed get image");
                if(mysqli_num_rows($result_get_image)>0) {
                    $all_video_ele = "";
                    $video_arr = array();
                    $i = 0;

                    while($arr_get_image_video = mysqli_fetch_assoc($result_get_image)) {
                        $post_id_enc = sha1($arr_get_image_video['post_id']);
                        $post_img_video_name = $arr_get_image_video['post_img_name'];
                        $post_privacy = $arr_get_image_video['post_privacy'];

                        if($login_user_id == $current_user_id) {

                            if($post_img_video_name != "") {
                                $post_img_video_arr = explode(",",$post_img_video_name);
    
                                foreach($post_img_video_arr as $img_video__name) {
                                    $file_extension = explode(".",$img_video__name)[1];
                                    $video_extension = array("mp4");
                                    if(in_array($file_extension,$video_extension)) {
                                        
                                        $all_video_ele .= 
                                        "<div class='videos_inner_ele'>
                                            <video src='post_img/$img_video__name' controls=''></video>
                                            <div class='user_videos_delete_ele' data-p='$post_id_enc' data-video='$img_video__name'>
                                                <span class='material-symbols-outlined'>delete</span>
                                            </div>
                                        </div>";
    
                                        $video_arr[$i] = $img_video__name;
                                        $i++;
                                    }
                                }
                            }
                        }
                        else {
                            if($post_privacy == "only_me") {
                                continue;
                            }
                            else if($post_privacy == "friends") {
                                $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$current_user_id AND to_user_id=$login_user_id)";
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
                                        
                                        $all_video_ele .= 
                                        "<div class='videos_inner_ele'>
                                            <video src='post_img/$img_video__name' controls=''></video>
                                        </div>";
    
                                        $video_arr[$i] = $img_video__name;
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                    if(count($video_arr) > 0) {
                        $info['video_status'] = true;

                        $info['video_data'] = "<div class='col-12' id='videos_m_col'>
                                                    <div class='row m-0 bg-white p-2' style='border-radius: 10px;'>
                                                        <div class='col-12 fw-bold fs-5' style='color: #000;'>Videos : </div>
                                                    </div>
                                                    <div class='row m-0'>
                                                        <div class='col-12 p-0' id='videos_col'>
                                                            $all_video_ele
                                                        </div>
                                                    </div>
                                                </div>";
                    }
                    else {
                        $info['video_status'] = "<div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Video Found</div>";
                    }

                }
                else {
                    $info['video_status'] = "<div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Video Found</div>";
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