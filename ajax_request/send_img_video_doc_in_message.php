<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // changing the upload limits
        // ini_set('upload_max_filesize', '500M');
        // ini_set('post_max_size', '550M');
        // ini_set('memory_limit', '1024M');
        // ini_set('max_input_time', 300);
        // ini_set('max_execution_time', 300);
        ini_set('upload_max_filesize', '1000M');
        ini_set('post_max_size', '1020M');
        ini_set('memory_limit', '1024M');
        ini_set('max_input_time', 600);
        ini_set('max_execution_time', 600);

        $info = array();
        if(((isset($_FILES['image_send_m'])) ||(isset($_FILES['document_send_m']))) && (isset($_POST['friend_user_id'])) && (isset($_POST['current_user_message_data_id']))) {

            require_once "../conn.php";
            require "time_ago_f.php";

            $conn = connected() or die("Connection Failed");

            $friend_user_id = mysqli_real_escape_string($conn,trim($_POST['friend_user_id']));
            $current_user_message_data_id = trim($_POST['current_user_message_data_id']);

            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION['user_id'];
            

            $sql_friend_check_in_user = "SELECT user_id FROM user WHERE (user_id != $login_user_id && user_id = $friend_user_id)";

            $result_friend_check_in_user = mysqli_query($conn,$sql_friend_check_in_user) or die("Query failed friend_check_in_use");

            if(mysqli_num_rows($result_friend_check_in_user) == 1) {
                $info['error'] = 1;
                $file_name = [];
                $file_type = [];
                $tmp_name = [];
                $files_name_s = "";
                $file_check_status = 0;

                date_default_timezone_set("Asia/Kolkata");
                $timestamp = time();
                $date = time_ago($timestamp);
                $info["img_video"] = 0;
                $info["document"] = 0;

                $message_id = time() . "_" . mt_rand(1000, 200000) . "_" . mt_rand(500, 99000)."_".date("s");

                if($_FILES['image_send_m']['error'][0] != 4) {
                    $no_of_file = count($_FILES["image_send_m"]["error"]);
                    $info["img_video"] = 1;

                    foreach($_FILES["image_send_m"] as $key => $inner_arr) {
                        if($key == "name") {
                            $file_name = $inner_arr;
                        }
                        else if($key == "type") {
                            $file_type = $inner_arr;
                        }
                        else if($key == "tmp_name") {
                            $tmp_name = $inner_arr;
                        }
                    }

                    for($i = 0;$i<$no_of_file;$i++) {
                        $filename = $file_name[$i];
                        $extension = pathinfo($filename)['extension'];
                        $valid_extension = array("jpg","jpeg","png","gif","mp4");
                        if(in_array($extension,$valid_extension)) {
                            $file_check_status = 1;
                            $files_name_s .= time()."_".mt_rand(1,10000)."_".$file_name[$i].",";
                            $info["file_check_status"] = true;   
                        }
                        else {
                            $file_check_status = 0;
                            $info["file_check_status"] = "Please choose Allowed File Type(Photo/Video) - jpg,jpeg,png,gif,mp4";
                            break;
                        }
                    }

                    if($file_check_status == 1) {
                        $files_name_s = substr($files_name_s,0,(strlen($files_name_s)-1));

                        $sql = "INSERT INTO user_message(message_id,img_video_or_doc_name_s,type,message_time,sender_id,receiver_id) VALUES('$message_id','$files_name_s','images_videos','$timestamp',$login_user_id,$friend_user_id)";
                        mysqli_set_charset($conn,'utf8mb4');
                        mysqli_query($conn,$sql) or die("Query Failed foe insert image_video");

                        $current_user_message_data_id = sha1($message_id)."/".$current_user_message_data_id;

                        $file_name = explode(",",$files_name_s);
                        $file_ele = "";
                        $inner_post_file_set = "";

                        for($i = 0;$i<$no_of_file;$i++) {
                            move_uploaded_file($tmp_name[$i],("../message_i_v_d/".$file_name[$i]));
                            $file_extension = pathinfo($file_name[$i])['extension'];
                            $img_extension = array("jpg","jpeg","png","gif");
    
                            if(in_array($file_extension,$img_extension)) {
                                $file_ele .= "<img src='message_i_v_d/$file_name[$i]'>";
                            }
                            else {
                                $file_ele .= "<video src='message_i_v_d/$file_name[$i]' controls></video>";
                            }
                        }

                        $info["file_data"] = "<div class='row'>
                                                    <div class='col-12 d-flex my-3 chat_send_col'>
                                                        <div class='user_chat_message chat_send'>
                                                            <div class='user_message_description_img_video_style'>
                                                                $file_ele
                                                            </div>
                                                            <div class='user_message_time_ago'>$date</div>
                                                        </div>
                                                    </div>
                                                </div>";
                    }
                }

                if($_FILES['document_send_m']['error'][0] != 4) {
                    $no_of_file = count($_FILES["document_send_m"]["error"]);
                    $info["document"] = 1;
                    $document_name = "";

                    foreach($_FILES["document_send_m"] as $key => $inner_arr) {
                        if($key == "name") {
                            $file_name = $inner_arr;
                        }
                        else if($key == "type") {
                            $file_type = $inner_arr;
                        }
                        else if($key == "tmp_name") {
                            $tmp_name = $inner_arr;
                        }
                    }

                    for($i = 0;$i<$no_of_file;$i++) {
                        $filename = $file_name[$i];
                        $extension = pathinfo($filename)['extension'];
                        $invalid_extension = array("js","json","xml");
    
                        if(in_array($extension,$invalid_extension)) {
                            $file_check_status = 0;
                            $info["file_check_status"] = "Don't Allowed .js,.json,.xml File";
                            break;
                        }
                        else {
                            $file_check_status = 1;
                            $files_name_s .= time()."_".mt_rand(1,10000)."_".$file_name[$i].",";
                            $document_name .= $file_name[$i].",";
                            $info["file_check_status"] = true;
                        }
                    }

                    if($file_check_status == 1) {
                        $files_name_s = substr($files_name_s,0,(strlen($files_name_s)-1));
                        $document_name = substr($document_name,0,(strlen($document_name)-1));

                        $sql = "INSERT INTO user_message(message_id,img_video_or_doc_name_s,type,document_name,message_time,sender_id,receiver_id) VALUES('$message_id','$files_name_s','documents','$document_name','$timestamp',$login_user_id,$friend_user_id)";
                        mysqli_set_charset($conn,'utf8mb4');
                        mysqli_query($conn,$sql) or die("Query Failed");

                        $current_user_message_data_id = sha1($message_id)."/".$current_user_message_data_id;

                        $file_name = explode(",",$files_name_s);
                        $document_name_arr = explode(",",$document_name);
                        $document__ele = "";

                        for($i = 0;$i<$no_of_file;$i++) {
                            move_uploaded_file($tmp_name[$i],("../message_i_v_d/".$file_name[$i]));
                            
                            $document__ele .= "<div class='row'>
                                                    <div class='col-12 d-flex my-3 chat_send_col'>
                                                        <div class='user_chat_message chat_send'>
                                                            <div class='user_message_description_document_style'>
                                                                <div class='doc_content'>
                                                                    <div class='document_icon'>
                                                                        <span class='material-symbols-outlined'>description</span>
                                                                    </div>
                                                                    <div class='document_name'>{$document_name_arr[$i]}</div>
                                                                </div>
                                                                <button data-document_src='{$file_name[$i]}' class='download_icon'>
                                                                    <img src='img/icon/download_icon.svg'>
                                                                </button>
                                                            </div>
                                                            <div class='user_message_time_ago'>$date</div>
                                                        </div>
                                                    </div>
                                                </div>";
                        }
                        $info["file_data"] = $document__ele;
                    }
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