<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();

        if(isset($_POST['user_p_password'])) {
            $info["error"]=1;
            if (!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION["user_id"];

            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $user_p_password = mysqli_real_escape_string($conn,trim($_POST['user_p_password']));

            $valid_pass = 0;

            if(isset($_SESSION["user_verify_status"]) && $_SESSION["user_verify_status"] == true) {
                $info['u_v_s'] = true;

                // password checker
                if($user_p_password == "") {
                    $info['user_p_password'] = "Enter the New Password.";
                    $valid_pass = 0;
                }
                else if(strlen($user_p_password)<8 || strlen($user_p_password)>16) {
                    $info['user_p_password'] = "Sorry, your password must be between 8 and 16 characters long.";
                    $valid_pass = 0;
                }
                else if(preg_match("/^[A-Za-z0-9@_!#$%\^\-+=&,\.\"*\/\(\)\\<>\[\]?\`|}{~:]{8,16}$/",$user_p_password)) {
                    $info['user_p_password'] = true;
                    $valid_pass = 1;
                }
                else {
                    $info['user_p_password'] = "Enter the valid password.";
                    $valid_pass = 0;
                }

                $info['success'] = 0;
                if($valid_pass==1) {
                    $password = md5($user_p_password);

                    $q = "UPDATE user SET password='$password' WHERE user_id=$login_user_id";
                    mysqli_set_charset($conn,'utf8mb4');
                    mysqli_query($conn,$q) or die("Query Failed");
                    $_SESSION["user_verify_status"] = false;
                    $info['success'] = 1;
                }
            }
            else {
                $info['u_v_s'] = "User Not Verified | Reload The Page | Something Went Wrong";
            }
            mysqli_close($conn);
        }
        else {
            $info["error"]=0;
        }
        echo json_encode($info);
    }
?>