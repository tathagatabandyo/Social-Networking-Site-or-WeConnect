<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(!isset($_SESSION)) {
            session_start();
        }
        $login_user_id = $_SESSION['user_id'];
        require_once "../conn.php";

        if (isset($_SESSION["user_email"])) {
            date_default_timezone_set("Asia/Kolkata");
            $current_timestamp_ = time() + 2;

            $conn = connected() or die("Connection Failed");
            $sql_time_update = "UPDATE user SET last_login=$current_timestamp_ WHERE user_id=$login_user_id";
            mysqli_set_charset($conn,'utf8mb4');
            mysqli_query($conn,$sql_time_update) or die("Query Failed Time Update");
            mysqli_close($conn);
        }
    }
?>