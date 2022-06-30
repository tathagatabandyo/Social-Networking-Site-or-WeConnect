<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['nid'])) {
            
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $nid = mysqli_real_escape_string($conn,$_POST['nid']);

            if(!isset($_SESSION)) {
                session_start();
            }
            $user_id = $_SESSION["user_id"];

            $sql_c = "SELECT notification_read_status FROM notification WHERE (to_receive_notification_user_id=$user_id AND notification_id=$nid)";

            $result_c = mysqli_query($conn,$sql_c) or die("QUERY Failed c");

            if(mysqli_num_rows($result_c)>0) {

                $arr_c = mysqli_fetch_assoc($result_c);
                if($arr_c['notification_read_status'] == 0) {
                    $info["error"] = 1;

                    $sql_u = "UPDATE notification SET notification_read_status=1 WHERE (to_receive_notification_user_id=$user_id AND notification_id=$nid)";
    
                    mysqli_query($conn,$sql_u) or die("QUERY Failed u");
    
                    $sql_notification = "SELECT notification_read_status FROM notification WHERE to_receive_notification_user_id=$user_id";
                    $result_notification = mysqli_query($conn,$sql_notification) or die("Query Failed notification");
                    $no_of_notafication = 0;
                    if(mysqli_num_rows($result_notification)>0) {
                        while($arr_notification = mysqli_fetch_assoc($result_notification)) {
                            if($arr_notification['notification_read_status'] == 0) {
                                $no_of_notafication++;
                            }
                        }
                    }
                    $info['no_of_notafication'] = $no_of_notafication;
                }
                else {
                    $info['error'] = 2;
                }
            }
            else {
                $info["error"] = 0;
            }
            mysqli_close($conn);
        }
        else {
            $info["error"] = 0;
        }
        echo json_encode($info);
    }
?>