<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        $info['message__data'] = "";
        if(isset($_POST['message']) && isset($_POST['friend_user_id']) && isset($_POST['current_user_message_data_id'])) {
            require_once "../conn.php";
            require "time_ago_f.php";

            $conn = connected() or die("Connection Failed");

            $message = trim($_POST['message']);
            $friend_user_id = mysqli_real_escape_string($conn,trim($_POST['friend_user_id']));
            $current_user_message_data_id = trim($_POST['current_user_message_data_id']);

            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION['user_id'];

            if($message == "") {
                $info['message_empty'] = "Type a Message";
            }
            else {
                $info['message_empty'] = true;
                $sql_friend_check_in_user = "SELECT user_id FROM user WHERE (user_id != $login_user_id && user_id = $friend_user_id)";
    
                $result_friend_check_in_user = mysqli_query($conn,$sql_friend_check_in_user) or die("Query failed friend_check_in_use");
                if(mysqli_num_rows($result_friend_check_in_user) == 1) {
                    $info['error'] = 1;
                    date_default_timezone_set("Asia/Kolkata");
                    $timestamp = time();
        
                    $date = time_ago($timestamp);

                    $message_id = time() . "_" . mt_rand(1000, 200000) . "_" . mt_rand(500, 99000)."_".date("s");

                    $current_user_message_data_id = sha1($message_id)."/".$current_user_message_data_id;
        
                    $q = "INSERT INTO user_message(message_id,message,type,message_time,sender_id,receiver_id) VALUES('$message_id','$message','message','$timestamp',$login_user_id,$friend_user_id)";
                    mysqli_set_charset($conn,'utf8mb4');
                    mysqli_query($conn,$q) or die(mysqli_error($conn)." Query Failed");

                    $q_update_user = "UPDATE user SET use_message_send_status=$timestamp WHERE user_id=$login_user_id";
                    
                    $info['message_send_data'] =  "<div class='row'>
                                <div class='col-12 d-flex my-3 chat_send_col'>
                                    <div class='user_chat_message chat_send'>
                                        <div class='user_message_description'>$message</div>
                                        <div class='user_message_time_ago'>$date</div>
                                    </div>
                                </div>
                            </div>";
                }
                else { 
                    $info['error'] = 0;
                }
            }
            $info['current_user_message_data_id'] = $current_user_message_data_id;

            mysqli_close($conn);
        }
        else {
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>