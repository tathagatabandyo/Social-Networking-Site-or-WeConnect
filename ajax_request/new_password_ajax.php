<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['password'])) {
            $info["error"]=1;
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $password = mysqli_real_escape_string($conn,trim($_POST['password']));
            

            $valid_pass = 0;

            // password checker
            if($password == "") {
                $info['password_e'] = "Enter the Password.";
                $valid_pass = 0;
            }
            else if(strlen($password)<8 || strlen($password)>16) {
                $info['password_e'] = "Sorry, your password must be between 8 and 16 characters long.";
                $valid_pass = 0;
            }
            else if(preg_match("/^[A-Za-z0-9@_!#$%\^\-+=&,\.\"*\/\(\)\\<>\[\]?\`|}{~:]{8,16}$/",$password)) {
                $info['password_e'] = true;
                $valid_pass = 1;
            }
            else {
                $info['password_e'] = "Enter the valid password.";
                $valid_pass = 0;
            }

            $info['success'] = 0;
            if($valid_pass==1) {
                $password = md5($password);
                if(!isset($_SESSION)) {
                    session_start();
                }
                $email = $_SESSION["email_id"];

                session_unset();
                session_destroy();

                $sql = "UPDATE user SET password='$password' WHERE user_email='$email'";

                mysqli_query($conn,$sql) or die("Query Failed");

                $info['success'] = 1;
            }
            mysqli_close($conn);
        }
        else {
            $info["error"]=0;
        }
        echo json_encode($info);
    }
?>