<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $info = array();
        if (isset($_POST["search_value"])) {
            $info['error'] = 1;

            require_once "../conn.php";
            $conn = connected() or die("Connection Failed");
            $search_value = mysqli_real_escape_string($conn,trim($_POST['search_value']));

            if($search_value != "") {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $user_id = $_SESSION["user_id"];
    
                $sql_search = "SELECT user_id,user_name,image_type,profile_image FROM user WHERE (user_id!=$user_id AND user_name LIKE '%$search_value%');";
                mysqli_set_charset($conn,'utf8mb4');
                $result_search = mysqli_query($conn,$sql_search) or die("Query Failed Search");
                
                $info['search_result'] = "";
    
                if(mysqli_num_rows($result_search) > 0) {
                    while($arr_search = mysqli_fetch_assoc($result_search)) {
    
                        $profile_img_text = "";
                        
                        if($arr_search['image_type'] == "text") {
                            $ch = strtoupper(substr(explode(" ",$arr_search['user_name'])[0],0,1));
                            $profile_img_text = "<div class='profile_text_img_'>$ch</div>";
                        }
                        else {
                            $profile_img_text = "<img src='img/profile_img/{$arr_search['profile_image']}'>";
                        }
                        
                        $info['search_result'] .= "<a href='profile?uid={$arr_search['user_id']}' target='_blank' class='search_res d-flex align-items-center'>
                                                        <div class='left_item_fri d-flex align-items-center'>
                                                            <div class='search__log d-flex align-items-center justify-content-center me-3'>
                                                                <span class='span_search__log d-flex align-items-center justify-content-center'>
                                                                    <svg fill='currentColor' viewBox='0 0 16 16' width='1em' height='1em' class='a8c37x1j ms05siws l3qrxjdp b7h9ocf4 py1f6qlh gl3lb2sf hhz5lgdu'>
                                                                        <g fill-rule='evenodd' transform='translate(-448 -544)'>
                                                                            <g fill-rule='nonzero'>
                                                                                <path d='M10.743 2.257a6 6 0 1 1-8.485 8.486 6 6 0 0 1 8.485-8.486zm-1.06 1.06a4.5 4.5 0 1 0-6.365 6.364 4.5 4.5 0 0 0 6.364-6.363z' transform='translate(448 544)'></path>
                                                                                <path d='M10.39 8.75a2.94 2.94 0 0 0-.199.432c-.155.417-.23.849-.172 1.284.055.415.232.794.54 1.103a.75.75 0 0 0 1.112-1.004l-.051-.057a.39.39 0 0 1-.114-.24c-.021-.155.014-.356.09-.563.031-.081.06-.145.08-.182l.012-.022a.75.75 0 1 0-1.299-.752z' transform='translate(448 544)'></path>
                                                                                <path d='M9.557 11.659c.038-.018.09-.04.15-.064.207-.077.408-.112.562-.092.08.01.143.034.198.077l.041.036a.75.75 0 0 0 1.06-1.06 1.881 1.881 0 0 0-1.103-.54c-.435-.058-.867.018-1.284.175-.189.07-.336.143-.433.2a.75.75 0 0 0 .624 1.356l.066-.027.12-.061z' transform='translate(448 544)'></path>
                                                                                <path d='m13.463 15.142-.04-.044-3.574-4.192c-.599-.703.355-1.656 1.058-1.057l4.191 3.574.044.04c.058.059.122.137.182.24.249.425.249.96-.154 1.41l-.057.057c-.45.403-.986.403-1.411.154a1.182 1.182 0 0 1-.24-.182zm.617-.616.444-.444a.31.31 0 0 0-.063-.052c-.093-.055-.263-.055-.35.024l.208.232.207-.206.006.007-.22.257-.026-.024.033-.034.025.027-.257.22-.007-.007zm-.027-.415c-.078.088-.078.257-.023.35a.31.31 0 0 0 .051.063l.205-.204-.233-.209z' transform='translate(448 544)'></path>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class='friend__name'>{$arr_search['user_name']}</div>
                                                        </div>
                                                        <div class='friend__img d-flex justify-content-end'>
                                                            $profile_img_text
                                                        </div>
                                                    </a>";
    
                    }
                }
                else {
                    $info['search_result'] = "<div class='d-flex align-items-center justify-content-center'>No Search Friend Found.</div>";
                }
            }
            else {
                $info['search_result'] = "<div class='d-flex align-items-center justify-content-center'>No Search Friend Found.</div>";
            }

            mysqli_close($conn);
        }
        else {
            $info['error'] = 0;
        }
        echo json_encode($info);
    }
?>