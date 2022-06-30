<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if (isset($_POST["post_id"]) && isset($_POST["video_name"])) {
            $info["error"] = 1;

            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $post_id = mysqli_real_escape_string($conn,$_POST['post_id']);
            $video_name = mysqli_real_escape_string($conn,$_POST['video_name']);

            if(!isset($_SESSION)) {
                session_start();
            }
            $user_id = $_SESSION["user_id"];

            $sql = "SELECT post_id FROM post WHERE user_id = $user_id";

            $result = mysqli_query($conn,$sql) or die("Query Failed");

            $post__id = "";
            $post_status = 0;
            $info['success'] = 0;

            if(mysqli_num_rows($result) > 0) {
                while($arr = mysqli_fetch_assoc($result)) {
                    $post_id_enc = sha1($arr['post_id']);
                    if($post_id == $post_id_enc) {
                        $post__id = $arr['post_id'];
                        $post_status = 1;
                        break;
                    }
                }
                if($post_status == 1) {
                    $sql_get_all_photo_video_in_s_p = "SELECT post_img_name FROM post WHERE post_id='$post__id'";
                    $result_all_photo_video_in_s_p = mysqli_query($conn,$sql_get_all_photo_video_in_s_p) or die("Query Failed all_photo_video_in_s_p");

                    $arr_all_photo_video_in_s_p = mysqli_fetch_assoc($result_all_photo_video_in_s_p);
                    $all_photo_video_in_s_p  = $arr_all_photo_video_in_s_p['post_img_name'];

                    if($all_photo_video_in_s_p != "") {
                        $user_all_photo_video_arr = explode(",",$all_photo_video_in_s_p);
                        if(in_array($video_name,$user_all_photo_video_arr)) {
                            $new_img_video_ = "";
                            $i=0;
                            foreach($user_all_photo_video_arr as $img_video) {
                                if($video_name != $img_video) {
                                    $new_img_video_ .= $img_video.",";
                                    $i++;
                                }
                            }
                            if($new_img_video_ != "") {
                                $new_img_video_ = substr($new_img_video_, 0, (strlen($new_img_video_) - 1));
                            }
                            $sql_post_img_video_update = "UPDATE post SET post_img_name='$new_img_video_' WHERE post_id='$post__id'";
                            mysqli_query($conn,$sql_post_img_video_update) or die("Query Failed post_img_video_update");

                            unlink("../post_img/".$video_name);
                            $info['success'] = 1;

                            $sql_c_video = "SELECT post_id,post_img_name FROM post WHERE user_id = $user_id";
                            $result_c_video = mysqli_query($conn,$sql_c_video) or die("Query Failed c img");

                            $video_arr = array();
                            $i=0;

                            while($arr_get_image_video = mysqli_fetch_assoc($result_c_video)) {
                                $post_img_video_name = $arr_get_image_video['post_img_name'];

                                if($post_img_video_name != "") {
                                    $post_img_video_arr = explode(",",$post_img_video_name);

                                    foreach($post_img_video_arr as $img_video__name) {
                                        $file_extension = explode(".",$img_video__name)[1];
                                        $video_extension = array("mp4");

                                        if(in_array($file_extension,$video_extension)) {
                                            $video_arr[$i] = $img_video__name;
                                            $i++;
                                        }
                                    }
                                }
                            }
                            if(count($video_arr) > 0) {
                                $info['video_count'] = true;
                            }
                            else {
                                $info['video_count'] = "<div class='col-12 d-flex justify-content-center align-items-center' style='padding-top: 5px;font-weight: bold; font-size: 20px;user-select: none;'>No Video Found</div>";
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