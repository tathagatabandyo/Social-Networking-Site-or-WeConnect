<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if(isset($_POST['current_user_id'])) {
            $info["error"] = 1;
            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $current_user_id = mysqli_real_escape_string($conn,$_POST['current_user_id']);

            date_default_timezone_set("Asia/Kolkata");
    
            if(!isset($_SESSION)) {
                session_start();
            }
            $login_user_id = $_SESSION["user_id"];

            $sql_s = "SELECT user_name FROM user WHERE user_id = $current_user_id";
            $result_s = mysqli_query($conn,$sql_s) or die("Query Failed");
            if(mysqli_num_rows($result_s) == 1) {
                $info['user_search_status'] = true;

                $sql_get_friend = "SELECT action_name,to_user_id FROM request_friend WHERE (from_user_id=$current_user_id AND action_name='friends')";
                $result_get_friend = mysqli_query($conn,$sql_get_friend) or die("Query Failed get_friend");
                if(mysqli_num_rows($result_get_friend)>0) {
                    $all_friend = "";
                    
                    while($arr_get_friend = mysqli_fetch_assoc($result_get_friend)) {
                        $f_uid = $arr_get_friend['to_user_id'];

                        $sql_f_details = "SELECT user_name,image_type,profile_image FROM user WHERE user_id=$f_uid";
                        
                        $result_f_details = mysqli_query($conn,$sql_f_details) or die("Query Failed f_details");

                        $arr_f_details = mysqli_fetch_assoc($result_f_details);

                        $f_img_text="";
                        if($arr_f_details['image_type'] == "text") {
                            $ch = strtoupper(substr(explode(" ",$arr_f_details['user_name'])[0],0,1));
                            $f_img_text = "<div class='user_profile_img_text'>$ch</div>";
                        }
                        else {
                            $f_img_text = "<img src='img/profile_img/{$arr_f_details['profile_image']}'>";
                        }
                        $un_f_btn = "";
                        if($login_user_id == $current_user_id) {
                            $un_f_btn = "<button class='btn btn-primary active d-flex justify-content-center align-items-center unfriend_btn' data-action_n='{$arr_get_friend['action_name']}' data-c='$f_uid'>
                                            <div class='icon_unfriend_f'><i class='bi bi-person-check'></i></div>
                                            <div class='unfriend__action_name'>friends</div>
                                        </button>";
                        }
                        $all_friend .= "<a href='profile?uid=$f_uid' target='_blank' class='show_friends_block'>
                                            $f_img_text
                                            <div class='friends__name'>{$arr_f_details['user_name']}</div>
                                            $un_f_btn
                                        </a>";
                    }


                    $info['friend_data'] ="<div class='col-12' id='friends_m_col'>
                                                <div class='row m-0 bg-white p-2' style='border-radius: 10px;'>
                                                    <div class='col-12 fw-bold fs-5' style='color: #000;'>Friends : </div>
                                                </div>
                                                <div class='row m-0'>
                                                    <div class='col-12 p-0' id='friends_col'>
                                                        $all_friend
                                                    </div>
                                                </div>
                                            </div>";
                }
                else {
                    $info['friend_data'] = "<div class='col-12 my-3 d-flex justify-content-center align-items-center' style='background-color: #fff; box-shadow: 0px 0px 4px 2px #000, 0px 0px 4px 2px #fff, 0px 0px 4px 2px #000; padding: 10px 0px; border-radius: 6px; font-weight: bold; font-size: 20px;user-select: none;'>No Friend Found</div>";
                }
            }
            else {
                $info['user_search_status'] = "Something Went Wrong | Not Valid User | Reload The Page";
            }
            mysqli_close($conn);
        }
        else {
            $info["error"] = 0;
        }
        echo json_encode($info);
    }
?>