<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['dob']) && isset($_POST['gender'])) {
            $info["error"]=1;
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $name = mysqli_real_escape_string($conn,trim($_POST['name']));
            $email = mysqli_real_escape_string($conn,trim($_POST['email']));
            $password = mysqli_real_escape_string($conn,trim($_POST['password']));
            $dob = mysqli_real_escape_string($conn,trim($_POST['dob']));
            $gender = mysqli_real_escape_string($conn,trim($_POST['gender']));
            mysqli_close($conn);


            $valid_name = 0;
            $valid_email = 0;
            $valid_pass = 0;
            $valid_dob = 0;
            $valid_gender = 0;

            //name checker
            if($name == "" ) {
                $info['name_e'] = "Enter the Name.";
                $valid = 0;
            }
            else if(preg_match_all("/[@_!#$%\^\-+=&,\.\"*\/\(\)\\<>\[\]?\`|}{~:0-9]/m",$name)) {
                $info['name_e'] = "Sorry, only letters (a-z) or (A-Z) allowed.";
                $valid_name = 0;
            }
            else if(preg_match("/^[a-zA-Z ]{3,30}$/",$name)) {
                $info['name_e'] = true;
                $valid_name = 1;
            }
            else {
                $info['name_e'] = "Sorry, your name must be between 3 and 30 characters long.";
                $valid_name = 0;
            }

            // email checker
            if($email == "" ) {
                $info['email_e'] = "Enter the Email ID.";
                $valid_email = 0;
            }
            else if(preg_match("/^[a-z][a-z0-9_\.]+\@[a-z]{2,}(\.[a-z]{2,5}){1,2}$/",$email)) {
                $info['email_e'] = true;
                $valid_email = 1;
            }
            else {
                $info['email_e'] = "Enter the valid Email ID.";
                $valid_email = 0;
            }

            //email check that email is taken or not 
            if($valid_email == 1) {
                $conn = $conn = connected() or die("Connection Failed");

                $sql = "SELECT user_email FROM user WHERE BINARY user_email='$email'";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0) {
                    $valid_email = 0;
                    $info['email_e'] = "That Email ID is taken. Try another Email ID.";
                }
                mysqli_close($conn);
            }

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
            // dob checker
            date_default_timezone_set("Asia/Kolkata");
            if($dob == "") {
                $info['age_e'] = "Select The DOB";
                $valid_dob = 0;
            }
            else if(preg_match("/^[0-9]{2}\/[0-9]{2}\/[1-9]{1}[0-9]{3}$/",$dob)) {
                
                $dob_arr = explode("/",$dob);
                $dob = $dob_arr[2]."-".$dob_arr[1]."-".$dob_arr[0];

                if(checkdate($dob_arr[1],$dob_arr[0],$dob_arr[2])) {
                    $date1 = date_create($dob);
                    $date2 = date_create(date("Y-m-d"));
                    $date_diff = date_diff($date1,$date2);
                    $age = $date_diff->y;
                    if(18<=$age) {
                        $info['age_e'] = true;
                        $valid_dob = 1;
                    }
                    else {
                        $info['age_e'] = "Age must be 18 years or greater";
                        $valid_dob = 0;
                    }
                }
                else {
                    $info['age_e'] = "Enter The Valid DOB";
                    $valid_dob = 0;
                }
    
            }
            else {
                $info['age_e'] = "Enter The Valid DOB Format.(DD/MM/YYYY)";
                $valid_dob = 0;
            }

            // gender checker
            if($gender =="Male" || $gender == "Female") {
                $info['gender_e'] = true;
                $valid_gender = 1;
            }
            else {
                $info['gender_e'] = "Select the Gender";
                $valid_gender = 0;
            }
            $info['success'] = 0;
            if($valid_name==1 && $valid_email==1 && $valid_pass==1 && $valid_dob==1 && $valid_gender==1) {
                $password = md5($password);
                $q = "INSERT INTO user(user_name,user_email,password,dob,gender) VALUES('$name','$email','$password','$dob','$gender')";
                if(!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION["insert_sql_query"] = $q;

                //OTP Generator
                $str = "abcdefghijklmnopqrstuvwxyz";
                $str = substr(str_shuffle($str),0,3);
                $digit = mt_rand(10000,99999);
                $otp = $str.$digit;
                $otp = str_shuffle($otp);

                $_SESSION['otp'] = $otp;

                include "../smtp/PHPMailerAutoload.php";
                $msg = "<h1 style='margin-bottom:0px;text-align: center;background: #0d6efd;color:#fff;font-family: Arial, Helvetica, sans-serif;padding:10px;'>WeConnect Verification OTP</h1> <h3 style='margin:0px;padding:15px 10px;text-align:center;background:#198754;color:#fff;font-family: Arial, Helvetica, sans-serif;'>Verification OTP : {$_SESSION['otp']}</h3>";
                $subject = "WeConnect Verification OTP";
                $to = $email;

                $mail = new PHPMailer(); 
                $mail->SMTPDebug  = 0;
                $mail->IsSMTP(); 
                $mail->SMTPAuth = true; 
                $mail->SMTPSecure = 'tls'; 
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587; 
                $mail->IsHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Username = "Enter Your Mail ID";
                $mail->Password = "Enter Your Password";
                $mail->SetFrom("Enter Your Mail ID");
                $mail->Subject = $subject;
                $mail->Body =$msg;
                $mail->AddAddress($to);
                $mail->SMTPOptions=array('ssl'=>array(
                    'verify_peer'=>false,
                    'verify_peer_name'=>false,
                    'allow_self_signed'=>false
                ));
                if(!$mail->Send()){
                    echo $mail->ErrorInfo;
                }
                else{
                    // echo "<br>send e-mail";
                    // $otp_modal_show = true;
                    $info['success'] = 1;
                    $info['email_content'] = "Let us know that this email address belongs to you. Enter the code from the email sent to <b>".$email."</b>";
                }
            }
        }
        else {
            $info["error"]=0;
        }
        echo json_encode($info);
    }

?>