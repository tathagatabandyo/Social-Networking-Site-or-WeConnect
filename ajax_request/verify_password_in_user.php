<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['v_user_p_password'])) {
            $info["error"]=1;

            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $v_user_p_password = mysqli_real_escape_string($conn,trim($_POST['v_user_p_password']));

            $valid_pass = 0;

            // password checker
            if($v_user_p_password == "") {
                $info['v_user_p_password'] = "Enter the Password.";
                $valid_pass = 0;
            }
            else {
                $info['v_user_p_password'] = true;
                $valid_pass = 1;
            }

            if($valid_pass==1) {
                $info['success'] = 0;

                if (!isset($_SESSION)) {
                    session_start();
                }
                $login_user_id = $_SESSION["user_id"];

                $password = md5($v_user_p_password);

                $q = "SELECT user_name from user WHERE user_id=$login_user_id AND BINARY password='$password'";
                mysqli_set_charset($conn,'utf8mb4');
                $result = mysqli_query($conn,$q) or die("Query Failed");
                if(mysqli_num_rows($result) == 1) {
                    $info['success'] = 1;
                    $_SESSION["user_verify_status"] = true;
                }
            }
            mysqli_close($conn);
        }
        else {
            $info["error"]=0;
        }
        echo json_encode($info);
    }
?>