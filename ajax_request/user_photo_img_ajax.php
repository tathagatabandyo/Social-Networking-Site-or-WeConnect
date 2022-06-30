<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";

    // changing the upload limits
    ini_set('upload_max_filesize', '500M');
    ini_set('post_max_size', '550M');
    ini_set('memory_limit', '1024M');
    ini_set('max_input_time', 300);
    ini_set('max_execution_time', 300);

    $info = array();
    if(isset($_FILES['profile_img_ele'])) {
        $info['error'] = 1;

        $profile_image_error = $_FILES['profile_img_ele']['error'];

        if($profile_image_error == 0) {
            $info['profile_image_select_state'] = true;

            $profile_image_name = mt_rand(100,10000)."_".time()."_".$_FILES['profile_img_ele']['name'];
            $profile_image_extension = pathinfo($_FILES['profile_img_ele']['name'])['extension'];
            $profile_image_tmp_name = $_FILES['profile_img_ele']['tmp_name'];

            $valid_extension = array("jpg","jpeg","png","gif");

            if(in_array($profile_image_extension,$valid_extension)) {
                $info["profile_image_extension_status"] = true;
                
                require_once "../conn.php";
                $conn = connected() or die("Connection Failed");
                
                if (!isset($_SESSION)) {
                    session_start();
                }
                $login_user_id = $_SESSION['user_id'];

                $sql_d = "SELECT image_type,profile_image FROM user WHERE user_id = '$login_user_id'";

                $result_d = mysqli_query($conn,$sql_d) or die("Query Failed");
                $arr_d = mysqli_fetch_assoc($result_d);

                $previous_profile_photo_type = $arr_d['image_type'];
                if($previous_profile_photo_type != "text") {
                    $previous_profile_photo_name = $arr_d['profile_image'];
                    unlink("../img/profile_img/".$previous_profile_photo_name);
                }

                $sql = "UPDATE user SET image_type='image',profile_image='$profile_image_name' WHERE user_id = '$login_user_id'";
                mysqli_set_charset($conn,'utf8mb4');
                mysqli_query($conn,$sql) or die("Query Failed");

                move_uploaded_file($profile_image_tmp_name,"../img/profile_img/"."$profile_image_name");

                $info['previous_profile_photo_type'] = $previous_profile_photo_type;
                $info['profile_photo_name'] = $profile_image_name;

                mysqli_close($conn);
            }
            else {
                $info["profile_image_extension_status"] = "Please choose Allowed Image Type - jpg,jpeg,png,gif";
            }
        }
        else {
            $info['profile_image_select_state'] = "Please Choose Your Profile Photo";
        }
    }
    else {
        $info['error'] = 0;
    }
    echo json_encode($info);
}
?>