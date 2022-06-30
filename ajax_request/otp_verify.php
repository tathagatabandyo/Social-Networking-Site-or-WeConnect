<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['otp'])) {
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $otp = mysqli_real_escape_string($conn,trim($_POST['otp']));
            session_start();

            if($otp == "") {
                $info['otp_info'] = "Enter the OTP.";
            }
            else if($otp == $_SESSION['otp']) {
                $sql = $_SESSION['insert_sql_query'];
                mysqli_query($conn,$sql) or die(mysqli_error($conn)." Query Failed otp");
                session_unset();
                session_destroy();
                
                $info['otp_info'] = true;
            }
            else {
                $info['otp_info'] = "Enter the Valid OTP.";
            }
            mysqli_close($conn);
        }
        else {
            $info["error"]=0;
        }
        echo json_encode($info);
    }

?>