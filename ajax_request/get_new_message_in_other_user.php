<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['friend_user_id']) && isset($_POST['current_user_message_data_id'])) {
            require_once "../conn.php";
            require "time_ago_f.php";

            $conn = connected() or die("Connection Failed");

            $friend_user_id = mysqli_real_escape_string($conn,trim($_POST['friend_user_id']));
            $current_user_message_data_id =  $_POST['current_user_message_data_id'];

            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION['user_id'];

            $sql_friend_check_in_user = "SELECT user_id,last_login FROM user WHERE (user_id != $login_user_id && user_id = $friend_user_id)";
            mysqli_set_charset($conn,'utf8mb4');
            $result_friend_check_in_user = mysqli_query($conn,$sql_friend_check_in_user) or die("Query failed friend_check_in_use");
            if(mysqli_num_rows($result_friend_check_in_user) == 1) {
                $info['error'] = 1;

                date_default_timezone_set("Asia/Kolkata");
                $arr_friend_check_in_user_ = mysqli_fetch_assoc($result_friend_check_in_user);
                $last_login_time =  $arr_friend_check_in_user_['last_login'];
                $last_login_status = "";

                $current_timestamp_ = time();
                if($last_login_time == 0) {
                    $last_login_status = "Offline";
                }
                else if($last_login_time > $current_timestamp_) {
                    $last_login_status = "Online";
                }
                else {
                    $last_login_status = "last seen at ".time_ago($last_login_time - 2);

                }
                $info['last_login_status'] = $last_login_status;

                $q = "SELECT message_id,message,type,img_video_or_doc_name_s,document_name,message_time,sender_id,receiver_id FROM user_message WHERE (sender_id = $login_user_id AND receiver_id = $friend_user_id) OR (sender_id = $friend_user_id AND receiver_id = $login_user_id) ORDER BY message_time";
                mysqli_set_charset($conn,'utf8mb4');
                $result = mysqli_query($conn,$q) or die("Query Failed 1");
    
                $info['message__data'] = "";

                if(mysqli_num_rows($result)>0) {
                    $current_user_message_data_id_arr = explode("/",$current_user_message_data_id);

                    while($arr = mysqli_fetch_assoc($result)) {
                        $current_mess_user_id_enc = sha1($arr['message_id']);

                        $sender_id = $arr['sender_id'];
                        $receiver_id = $arr['receiver_id'];

                        if(in_array($current_mess_user_id_enc,$current_user_message_data_id_arr)) {
                            continue;
                        }
                        else {
                            if($login_user_id == $sender_id && $friend_user_id == $receiver_id) {
                                continue;
                            }
                            else {
                                $timestamp = $arr['message_time'];
    
                                $date = time_ago($timestamp);
                                
                                $current_user_message_data_id = sha1($arr['message_id'])."/".$current_user_message_data_id;

                                if($arr['type'] == "message") {
                                    $info['message__data'] .= "<div class='row'>
                                                                    <div class='col-12 d-flex my-3'>
                                                                        <div class='user_chat_message'>
                                                                            <div class='user_message_description'>{$arr['message']}</div>
                                                                            <div class='user_message_time_ago'>$date</div>
                                                                        </div>
                                                                    </div>
                                                                </div>";
                                }
                                else if($arr['type'] == "images_videos") {
                                    $set_post_img_video = explode(",",$arr["img_video_or_doc_name_s"]);
                                    $image_video__ele = "";
                                    foreach($set_post_img_video as $image_video_name__s) {
                                        $file_extension = explode(".",$image_video_name__s)[1];
                                        
                                        $img_extension = array("jpg","jpeg","png","gif");
                
                                        if(in_array($file_extension,$img_extension)) {
                                            $image_video__ele .= "<img src='message_i_v_d/$image_video_name__s'>";
                                        }
                                        else {
                                            $image_video__ele .= "<video src='message_i_v_d/$image_video_name__s' controls></video>";
                                        }
                                    }
                                    $info['message__data'] .= "<div class='row'>
                                                                <div class='col-12 d-flex my-3'>
                                                                    <div class='user_chat_message'>
                                                                        <div class='user_message_description_img_video_style'>
                                                                            $image_video__ele
                                                                        </div>
                                                                        <div class='user_message_time_ago'>$date</div>
                                                                    </div>
                                                                </div>
                                                            </div>";
                                }
                                else if($arr['type'] == "documents") {
                                    $set_post_document = explode(",",$arr["img_video_or_doc_name_s"]);
                                    $document_name_arr = explode(",",$arr["document_name"]);
                                    $document__ele = "";
                                    $i = 0;
                                    foreach($set_post_document as $document_name__s) {
                                        $document__ele .= "<div class='row'>
                                                                <div class='col-12 d-flex my-3'>
                                                                    <div class='user_chat_message'>
                                                                        <div class='user_message_description_document_style'>
                                                                            <div class='doc_content'>
                                                                                <div class='document_icon'>
                                                                                    <span class='material-symbols-outlined'>description</span>
                                                                                </div>
                                                                                <div class='document_name'>{$document_name_arr[$i]}</div>
                                                                            </div>
                                                                            <button data-document_src='$document_name__s' class='download_icon'>
                                                                                <img src='img/icon/download_icon.svg'>
                                                                            </button>
                                                                        </div>
                                                                        <div class='user_message_time_ago'>$date</div>
                                                                    </div>
                                                                </div>
                                                            </div>";
                                        $i++;
                                    }
                                    $info['message__data'] .= $document__ele;
                                }
                            }
                        }
                    }
                }
                else {
                    $info['message__data'] = "";
                }

                $q2 = "SELECT user_name,image_type,profile_image FROM user WHERE user_id = $friend_user_id";
                $result2 = mysqli_query($conn,$q2) or die("Query Failed 2");
                if(mysqli_num_rows($result2)>0) {
                    $arr2 = mysqli_fetch_assoc($result2);
    
                    $friend_profile_ = "";
                    if($arr2['image_type'] == 'text') {
                        $ch = strtoupper(substr(explode(" ",$arr2["user_name"])[0],0,1));
                        $friend_profile_ = "<div class='user_details_in_message__top_img_text'>$ch</div>";
                    }
                    else {
                        $friend_profile_ = "<img src='img/profile_img/{$arr2["profile_image"]}'>";
                    }
    
                    $info['friend_user_name'] = $arr2['user_name'];
                    $info['friend_profile_image'] = $friend_profile_;
                    // $info['friend_user_id'] = $friend_user_id;
                }
            }
            else {
                $info['error'] = 0;
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