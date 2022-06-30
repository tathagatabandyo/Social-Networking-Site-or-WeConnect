<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['otp'])) {
            $info["error"]=1;
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $otp = mysqli_real_escape_string($conn,trim($_POST['otp']));
            mysqli_close($conn);
            if(!isset($_SESSION)) {
                session_start();
            }

            if($otp == "") {
                $info['otp_info'] = "Enter the OTP.";
            }
            else if($otp == $_SESSION['otp']) {
                $info['otp_info'] = true;
            }
            else {
                $info['otp_info'] = "Enter the Valid OTP.";
            }
        }
        else {
            $info["error"]=0;
        }
        echo json_encode($info);
    }

?>