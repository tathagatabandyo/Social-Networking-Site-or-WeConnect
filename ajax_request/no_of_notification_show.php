<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        require_once "../conn.php";

        if(!isset($_SESSION)) {
            session_start();
        }

        if(isset($_SESSION['user_id'])) {
            $info['error'] = 1;
            $user__id = $_SESSION['user_id'];

            $conn = connected() or die("Connection Failed");

            $sql_notification = "SELECT notification_read_status FROM notification WHERE to_receive_notification_user_id=$user__id ORDER BY notification_id DESC";
            mysqli_set_charset($conn,'utf8mb4');
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

            mysqli_close($conn);
        }
        else {
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>