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

                if($login_user_id == $current_user_id) {
                    $sql_get_image = "SELECT post_id,post_img_name FROM post WHERE user_id = $current_user_id ORDER BY post_si_no DESC";
                }
                else {
                    $sql_get_image = "SELECT post_id,post_img_name FROM post WHERE (user_id = $current_user_id and post.post_privacy!='only_me') ORDER BY post_si_no DESC";
                }

                $result_get_image = mysqli_query($conn,$sql_get_image) or die("Query Failed get image");
                if(mysqli_num_rows($result_get_image)>0) {
                    $all_image_ele = "";
                    $image_arr = array();
                    $i = 0;
                    while($arr_get_image_video = mysqli_fetch_assoc($result_get_image)) {
                        $post_id_enc = sha1($arr_get_image_video['post_id']);
                        $post_img_video_name = $arr_get_image_video['post_img_name'];

                        if($post_img_video_name != "") {
                            $post_img_video_arr = explode(",",$post_img_video_name);

                            foreach($post_img_video_arr as $img_video__name) {
                                $file_extension = explode(".",$img_video__name)[1];
                                $img_extension = array("jpg","jpeg","png","gif");
                                if(in_array($file_extension,$img_extension)) {
                                    $image_btn_ele = "";
                                    if($login_user_id == $current_user_id) {
                                        $image_btn_ele = "<div class='user_photos_delete_ele' data-p='$post_id_enc' data-img='$img_video__name'>
                                                            <span class='material-symbols-outlined'>delete</span>
                                                        </div>";
                                    }

                                    $all_image_ele .= 
                                    "<div class='photos_inner_ele'>
                                        <img src='post_img/$img_video__name'>
                                        $image_btn_ele
                                    </div>";

                                    $image_arr[$i] = $img_video__name;
                                    $i++;
                                }
                            }
                        }                   
                    }
                    if(count($image_arr) > 0) {
                        $info['photo_status'] = true;

                        $info['photo_data'] = "<div class='col-12' id='photos_m_col'>
                                                    <div class='row m-0 bg-white p-2' style='border-radius: 10px;'>
                                                        <div class='col-12 fw-bold fs-5' style='color: #000;'>Photos : </div>
                                                    </div>
                                                    <div class='row m-0'>
                                                        <div class='col-12 p-0' id='photos_col'>
                                                            $all_image_ele
                                                        </div>
                                                    </div>
                                                </div>";
                    }
                    else {
                        $info['photo_status'] = "<div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Photo Found</div>";
                    }
                }
                else {
                    $info['photo_status'] = "<div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Photo Found</div>";
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