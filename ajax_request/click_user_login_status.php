<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['friend_user_id'])) {
            require_once "../conn.php";
            require "time_ago_f.php";

            $conn = connected() or die("Connection Failed");

            $friend_user_id = mysqli_real_escape_string($conn,trim($_POST['friend_user_id']));

            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION['user_id'];

            $sql_friend_check_in_user = "SELECT user_id,last_login FROM user WHERE (user_id != $login_user_id && user_id = $friend_user_id)";

            $result_friend_check_in_user = mysqli_query($conn,$sql_friend_check_in_user) or die("Query failed friend_check_in_use");

            if(mysqli_num_rows($result_friend_check_in_user) == 1) {
                $info['error'] = 1;
                date_default_timezone_set("Asia/Kolkata");
                $arr_friend_check_in_user_ = mysqli_fetch_assoc($result_friend_check_in_user);
                $last_login_time =  $arr_friend_check_in_user_['last_login'];
                $last_login_status = "";

                $current_timestamp_ = time();
                if($last_login_time == 0) {
                    $last_login_status = "Offline";
                }
                else if($last_login_time > $current_timestamp_) {
                    $last_login_status = "Online";
                }
                else {
                    $last_login_status = "last seen at ".time_ago($last_login_time - 2);

                }
                $info['last_login_status'] = $last_login_status;
            }
            else {
                $info['error'] = 0;
            }

            mysqli_close($conn);
        }
        else {
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>