<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['email'])){
            $info["error"]=1;
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $email = mysqli_real_escape_string($conn,trim($_POST['email']));
            mysqli_close($conn);

            $valid_email = 0;

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

            //Check that email id is Belong to WeConnect or not 
            if($valid_email == 1) {
                $conn = $conn = connected() or die("Connection Failed");

                $sql = "SELECT user_email FROM user WHERE BINARY user_email='$email'";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)==1) {
                    $valid_email = 1;
                    $info['email_e'] = true;
                }
                else {
                    $info['email_e'] = "This E-mail id is Not Belong to WeConnect";
                    $valid_email = 0;
                }
                mysqli_close($conn);
            }

            $info['success'] = 0;
            if($valid_email==1) {
                if(!isset($_SESSION)) {
                    session_start();
                }

                //OTP Generator
                $str = "abcdefghijklmnopqrstuvwxyz";
                $str = substr(str_shuffle($str),0,3);
                $digit = mt_rand(10000,99999);
                $otp = $str.$digit;
                $otp = str_shuffle($otp);

                $_SESSION['otp'] = $otp;
                $_SESSION['email_id'] = $email;

                include "../smtp/PHPMailerAutoload.php";
                $msg = "<h1 style='margin-bottom:0px;text-align: center;background: #0d6efd;color:#fff;font-family: Arial, Helvetica, sans-serif;padding:10px;'>WeConnect Reset Password Verification OTP</h1> <h3 style='margin:0px;padding:15px 10px;text-align:center;background:#198754;color:#fff;font-family: Arial, Helvetica, sans-serif;'>Verification OTP : {$_SESSION['otp']}</h3>";
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