<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        require_once "../conn.php";
        $conn = connected() or die("Connection Failed");

        if (!isset($_SESSION)) {
            session_start();
        }
        $login_user_id = $_SESSION["user_id"];

        $sql = "SELECT user_name,user_email,dob,gender,image_type,profile_image FROM user WHERE user_id=$login_user_id";
        mysqli_set_charset($conn,'utf8mb4');
        $result_details = mysqli_query($conn,$sql) or die("Query Failed get user details");

        $arr_get = mysqli_fetch_assoc($result_details);

        if($arr_get['image_type'] == "text") {
            $ch = strtoupper(substr(explode(" ",$arr_get['user_name'])[0],0,1));
            $info['profile_img_t'] = "<div>$ch</div>";
        }
        else {
            $info['profile_img_t'] = "<img src='img/profile_img/{$arr_get['profile_image']}'>";
        }
        $dob_arr = explode("-",$arr_get['dob']);
        $dob = $dob_arr[2]."/".$dob_arr[1]."/".$dob_arr[0];
        $info["user_name"] = $arr_get['user_name'];
        $info["user_email"] = $arr_get['user_email'];
        $info["dob"] = $dob;
        $info["gender"] = $arr_get['gender'];

        mysqli_close($conn);
        echo json_encode($info);
    }
?>