<?php
// date_default_timezone_set("Asia/Kolkata");
// echo facebook_time_ago('2016-03-11 04:58:00') . "<br>";
// echo facebook_time_ago('2022-05-21 04:58:00 PM') . "<br>";
// echo facebook_time_ago('2022-05-10 06:46:12 PM') . "<br>";
// echo facebook_time_ago('2022-05-10 06:46:12 PM') . "<br>";

// function facebook_time_ago($timestamp)
// {
//     $time_ago = strtotime($timestamp);
//     $current_time = time();
//     $time_difference = $current_time - $time_ago;
//     $seconds = $time_difference;
//     $minutes      = round($seconds / 60);           // value 60 is seconds  
//     $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
//     $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
//     $weeks          = round($seconds / 604800);          // 7*24*60*60;  
//     $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
//     $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
//     if ($seconds <= 60) {
//         return "Just Now";
//     } else if ($minutes <= 60) {
//         if ($minutes == 1) {
//             return "one minute ago";
//         } else {
//             return "$minutes minutes ago";
//         }
//     } else if ($hours <= 24) {
//         if ($hours == 1) {
//             return "an hour ago";
//         } 
//         else if($hours > 24){
            
//         }
//         else {
//             return "$hours hrs ago";
//         }
//     } else if ($days <= 7) {
//         if ($days == 1) {
//             return "yesterday";
//         } else {
//             return "$days days ago";
//         }
//     } else if ($weeks <= 4.3) //4.3 == 52/12  
//     {
//         if ($weeks == 1) {
//             return "a week ago";
//         } else {
//             return "$weeks weeks ago";
//         }
//     } else if ($months <= 12) {
//         if ($months == 1) {
//             return "a month ago";
//         } else {
//             return "$months months ago";
//         }
//     } else {
//         if ($years == 1) {
//             return "one year ago";
//         } else {
//             return "$years years ago";
//         }
//     }
// }

date_default_timezone_set("Asia/Kolkata");
echo time_ago("1650802206")."<hr>";
echo time_ago("1653145655")."<hr>";
echo time_ago("1653196180")."<hr>";
echo time_ago(strtotime(date("2021-03-22 9:24:04")))."<hr>";
// date("l, d F Y",$timestamp)." at ".date("h:i:s A",$timestamp);

function time_ago($timestamp) {
    $date1 = date_create(date("Y-m-d h:i:s A",$timestamp));
    $date2 = date_create(date("Y-m-d h:i:s A"));

    // $w1 = date("W",$timestamp);
    // $w2 = date("W");
    // $week_diff = $w2 - $w1;

    // echo "w1 : $w1 , w2 : $w2 , week_diff : $week_diff<br>";

    $date_different = date_diff($date1,$date2);

    echo "<pre>";
    print_r($date_different);
    echo "</pre>";

    $year = $date_different->y;
    $month = $date_different->m;
    $day = $date_different->d;
    $hour = $date_different->h;
    $minute = $date_different->i;
    $second = $date_different->s;

    $time_ago_str = "";
    if($year > 0) {
        if($year == 1) {
            $time_ago_str = $year." year ago";
        }
        else {
            $time_ago_str = $year." years ago";
        }
    }
    else if($month > 0) {
        if($month == 1) {
            $time_ago_str = $month." month ago";
        }
        else {
            $time_ago_str = $month." months ago";
        }
    }
    // else if($week_diff > 0) {
    //     if($week_diff == 1) {
    //         $time_ago_str = $week_diff." week ago";
    //     }
    //     else {
    //         $time_ago_str = $week_diff." weeks ago";
    //     }
    // }
    else if($day > 0) {
        if($day == 1) {
            $time_ago_str = $day." day ago";
        }
        else {
            $time_ago_str = $day." days ago";
        }
    }
    else if($hour > 0) {
        if($hour == 1) {
            $time_ago_str = $hour." hour ago";
        }
        else {
            $time_ago_str = $hour." hours ago";
        }
    }
    else if($minute > 0){
        if($minute == 1) {
            $time_ago_str = $minute." minute ago";
        }
        else {
            $time_ago_str = $minute." minutes ago";
        }
    }
    else if($second > 0) {
        if($second == 1) {
            $time_ago_str = $second." second ago";
        }
        else {
            $time_ago_str = $second." seconds ago";
        }
    }
    else if($second == 0){
        $time_ago_str = "Just Now";
    }
    else {
        $time_ago_str = "invalid date";
    }
    return $time_ago_str;
}

?>