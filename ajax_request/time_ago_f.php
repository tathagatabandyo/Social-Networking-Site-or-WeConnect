<?php
    date_default_timezone_set("Asia/Kolkata");
    function time_ago($timestamp) {
        $date1 = date_create(date("Y-m-d h:i:s A",$timestamp));
        $date2 = date_create(date("Y-m-d h:i:s A"));
    
        // $w1 = date("W",$timestamp);
        // $w2 = date("W");
        // $week_diff = $w2 - $w1;
    
        $date_different = date_diff($date1,$date2);
    
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