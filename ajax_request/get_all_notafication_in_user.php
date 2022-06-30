<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        require_once "../conn.php";
        require "time_ago_f.php";
        if(!isset($_SESSION)) {
            session_start();
        }
        if(isset($_SESSION['user_id'])) {
            $info['error'] = 1;
            $user__id = $_SESSION['user_id'];
            $conn = connected() or die("Connection Failed");
            $sql_notification = "SELECT notification_id,notification_name,from_send_notification_user_id,notification_date_time,notification_read_status FROM notification WHERE to_receive_notification_user_id=$user__id ORDER BY notification_id DESC";
            mysqli_set_charset($conn,'utf8mb4');
            $result_notification = mysqli_query($conn,$sql_notification) or die("Query Failed notification");
            $notification_data_ele = "";
            $no_of_notafication = 0;
    
            if(mysqli_num_rows($result_notification)>0) {
                while($arr_notification = mysqli_fetch_assoc($result_notification)) {
                    $sql_u_img = "SELECT user_name,image_type,profile_image FROM user WHERE user_id={$arr_notification['from_send_notification_user_id']}";
                        $result_u_img = mysqli_query($conn,$sql_u_img) or die("Query Failed u_img");
                        $arr_u_img = mysqli_fetch_assoc($result_u_img);
                        $u_img_p_ = "";
                        if($arr_u_img['image_type'] == "text") {
                            $ch = strtoupper(substr(explode(" ",$arr_u_img['user_name'])[0],0,1));
                            $u_img_p_ = "<div class='from_user_profile_img_text'>$ch</div>";
                        }
                        else {
                            $u_img_p_ = "<img src='img/profile_img/{$arr_u_img['profile_image']}'>";
                        }
                        $right_notafication_ele_ = "";
                        $left_notafication_style = "";
                        if($arr_notification['notification_read_status'] == 0) {
                            $no_of_notafication++;
                            $right_notafication_ele_ = "<div class='right_notafication_ele d-flex align-items-center justify-content-center'>
                                                            <div class='read_unread_notifications'>
                                                                <div class='notifications_status'></div>
                                                            </div>
                                                        </div>";
                        }
                        else {
                            $left_notafication_style = "style='width: 98%;'";
                        }
                        $date_title = date("l, d F Y",$arr_notification['notification_date_time'])." at ".date("h:i:s A",$arr_notification['notification_date_time']);
                        $date = time_ago($arr_notification['notification_date_time']);
    
                        $notification_data_ele .= "<a href='profile?uid={$arr_notification['from_send_notification_user_id']}' target='_blank' class='notifications_child d-flex align-items-center' data-n = '{$arr_notification['notification_id']}'>
                                                            <div class='left_notafication_ele d-flex align-items-center' $left_notafication_style>
                                                                <div class='notifications_child_img'>
                                                                    $u_img_p_
                                                                </div>
                                                                <div class='notifications_details ms-3'>
                                                                    <div class='notifications_name'>{$arr_notification['notification_name']}</div>
                                                                    <div class='notifications_date_p d-flex justify-content-start align-items-center'>
                                                                        <div class='notifications_date' data-bs-toggle='tooltip' data-bs-placement='bottom' title='$date_title'>$date</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            $right_notafication_ele_
                                                        </a>";
                }
            }
            else {
                $notification_data_ele = "<div style='text-align: center; background: #787878a1; border-radius: 6px; padding: 6px 0px;'>No Notification Found</div>";
            }
            $info['notification_data_ele'] = "<p id='notifications_text'>Notifications</p>".$notification_data_ele;
        }
        else {
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>