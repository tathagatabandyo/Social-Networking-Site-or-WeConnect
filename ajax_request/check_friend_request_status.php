<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['current_user_id'])) {
            $info["error"] = 1;

            require_once "../conn.php";
            require "calculate_num_.php";
            $conn = connected() or die("Connection Failed");
            $current_user_id = mysqli_real_escape_string($conn,$_POST['current_user_id']);

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

                $sql_request_friend_status = "SELECT action_name FROM request_friend WHERE (from_user_id=$login_user_id AND to_user_id=$current_user_id)";

                $result_request_friend_status = mysqli_query($conn,$sql_request_friend_status) or die("Query Failed request_friend_status");
                $action_name = "Add Friend";
                $icon_class_name = "";

                if(mysqli_num_rows($result_request_friend_status) > 0) {
                    $arr_request_friend_status = mysqli_fetch_assoc($result_request_friend_status);
                    $action_name = $arr_request_friend_status['action_name'];
                }

                if($action_name == "Add Friend") {
                    $icon_class_name = "bi bi-person-plus";
                }
                else if($action_name == "Cancel Friend Request") {
                    $icon_class_name = "bi bi-person-x";
                }
                else if($action_name == "Accept Friend Request") {
                    $icon_class_name = "bi bi-person-check";
                }
                else if($action_name == "friends") {
                    $icon_class_name = "bi bi-person-check";
                }

                $info['c_u_f_s'] = "<div class='icon_request_f'><i class='$icon_class_name'></i></div>
                            <div class='friend_request_action_name'>$action_name</div>";
                $info['action_name'] = $action_name;

                $sql_get_total_friends = "SELECT total_friends FROM user WHERE user_id=$current_user_id";
                $result_get_total_friends = mysqli_query($conn,$sql_get_total_friends) or die("Query Failed get_total_friends");
                $arr_get_total_friends = mysqli_fetch_assoc($result_get_total_friends);

                $total_friends = $arr_get_total_friends['total_friends'];

                $total_friends = cal_num_($total_friends,"friend");

                $info['total_friends'] = $total_friends;

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