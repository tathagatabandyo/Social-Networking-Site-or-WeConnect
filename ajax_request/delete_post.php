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
                    $info["error"] = 1;

                    $sql_get_post_img_video = "SELECT post_img_name FROM post WHERE post_id='$post__id'";
                    $result_get_post_img_video = mysqli_query($conn,$sql_get_post_img_video) or die("Query Failed get_post_img_video");
                    $arr_get_post_img_video = mysqli_fetch_assoc($result_get_post_img_video);
                    $post_img_video_name = $arr_get_post_img_video['post_img_name'];

                    // delete Post_rection
                    $sql_delete_post_rection = "DELETE FROM user_rection_in_post WHERE post_id = '$post__id'";
                    mysqli_query($conn,$sql_delete_post_rection) or die("Query Failed delete_post_rection");

                    // delete post comment
                    $sql_delete_post_comment = "DELETE FROM post_comment WHERE post_id='$post__id'";
                    mysqli_query($conn,$sql_delete_post_comment) or die("Query Failed delete_post_comment");

                    //delete post
                    $sql_post_delete = "DELETE FROM post WHERE post_id = '$post__id'";
                    mysqli_query($conn,$sql_post_delete) or die("Query Failed post_delete");

                    if($post_img_video_name != "") {
                        $info['post_img_video_name'] = true;
                        $post_img_video_arr = explode(",",$post_img_video_name);
                        foreach($post_img_video_arr as $img_video__name) {
                            unlink("../post_img/".$img_video__name);
                        }
                    }
                    else {
                        $info['post_img_video_name'] = false;
                    }

                    $sql_c_all_post = "SELECT post_id FROM post WHERE user_id='$user_id'";
                    $result_c_all_post = mysqli_query($conn,$sql_c_all_post) or die("Query Failed c_all_post");
                    if(mysqli_num_rows($result_c_all_post) > 0) {
                        $info['post_c_status'] = true;
                    }
                    else {
                        $info['post_c_status'] = "<div class='row my-4 align-items-center style_post_any'>
                                                        <div class='col-12'>
                                                            <div class='row justify-content-start align-items-center position-relative'>
                                                                <div class='col-12 d-flex justify-content-center align-items-center' style='font-weight: bold; font-size: 20px;user-select:none;'>No Post Data Found</div>
                                                            </div>
                                                        </div>
                                                    </div>";
                    }

                    $info['success'] = 1;
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