<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['user_p_name']) && isset($_POST['user_p_dob']) && isset($_POST['user_p_gender'])) {
            $info["error"]=1;

            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $user_p_name = mysqli_real_escape_string($conn,trim($_POST['user_p_name']));
            $user_p_dob = mysqli_real_escape_string($conn,trim($_POST['user_p_dob']));
            $user_p_gender = mysqli_real_escape_string($conn,trim($_POST['user_p_gender']));

            $valid_name = 0;
            $valid_dob = 0;
            $valid_gender = 0;
            


            //name checker
            if($user_p_name == "" ) {
                $info['user_p_name'] = "Enter the Name.";
                $valid = 0;
            }
            else if(preg_match_all("/[@_!#$%\^\-+=&,\.\"*\/\(\)\\<>\[\]?\`|}{~:0-9]/m",$user_p_name)) {
                $info['user_p_name'] = "Sorry, only letters (a-z) or (A-Z) allowed.";
                $valid_name = 0;
            }
            else if(preg_match("/^[a-zA-Z ]{3,30}$/",$user_p_name)) {
                $info['user_p_name'] = true;
                $valid_name = 1;
            }
            else {
                $info['user_p_name'] = "Sorry, your name must be between 3 and 30 characters long.";
                $valid_name = 0;
            }

            // dob checker
            date_default_timezone_set("Asia/Kolkata");
            if($user_p_dob == "") {
                $info['user_p_dob'] = "Select The DOB";
                $valid_dob = 0;
            }
            else if(preg_match("/^[0-9]{2}\/[0-9]{2}\/[1-9]{1}[0-9]{3}$/",$user_p_dob)) {

                $dob_arr = explode("/",$user_p_dob);
                $user_p_dob = $dob_arr[2]."-".$dob_arr[1]."-".$dob_arr[0];

                if(checkdate($dob_arr[1],$dob_arr[0],$dob_arr[2])) {
                    $date1 = date_create($user_p_dob);
                    $date2 = date_create(date("Y-m-d"));
                    $date_diff = date_diff($date1,$date2);
                    $age = $date_diff->y;
                    if(18<=$age) {
                        $info['user_p_dob'] = true;
                        $valid_dob = 1;
                    }
                    else {
                        $info['user_p_dob'] = "Age must be 18 years or greater";
                        $valid_dob = 0;
                    }
                }
                else {
                    $info['user_p_dob'] = "Enter The Valid DOB";
                    $valid_dob = 0;
                }
            }
            else {
                $info['user_p_dob'] = "Enter The Valid DOB Format.(DD/MM/YYYY)";
                $valid_dob = 0;
            }

            // gender checker
            if($user_p_gender =="Male" || $user_p_gender == "Female") {
                $info['user_p_gender'] = true;
                $valid_gender = 1;
            }
            else {
                $info['user_p_gender'] = "Select the Gender";
                $valid_gender = 0;
            }
            $info['success'] = 0;

            if($valid_name==1 && $valid_dob==1 && $valid_gender==1) {
                $info['success'] = 1;

                if (!isset($_SESSION)) {
                    session_start();
                }
                $login_user_id = $_SESSION["user_id"];


                $sql_update = "UPDATE user SET user_name='$user_p_name',dob='$user_p_dob',gender='$user_p_gender' WHERE user_id=$login_user_id";
                mysqli_set_charset($conn,'utf8mb4');
                mysqli_query($conn,$sql_update) or die("Query Failed User Details Update");

                $_SESSION["user_name"] = $user_p_name;

            }
            mysqli_close($conn);
        }
        else {
            $info["error"]=0;
        }
        echo json_encode($info);
    }
?>