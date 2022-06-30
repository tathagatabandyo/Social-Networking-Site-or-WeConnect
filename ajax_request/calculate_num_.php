<?php
    function cal_num_($total_comment_in_post,$text_name) {

        $text_name = " ".$text_name;
        $n = 0;
        $n_l_ext = "";
        if($total_comment_in_post < 1000) {
            $n = $total_comment_in_post;
            if($total_comment_in_post == 0 || $total_comment_in_post == 1) {
                $n_l_ext = $text_name;
            }
            else {
                $n_l_ext = $text_name."s";
            }
        }
        else if($total_comment_in_post < 1000000){
            $n = $total_comment_in_post / 1000;
            $n_l_ext="k".$text_name."s";
        }
        else {
            $n = $total_comment_in_post / 1000000;
            $n_l_ext="M".$text_name."s";
        }

        $arr_n = explode(".",$n);
        $no_f = $arr_n[0];
        $dot_n = 0;
        if(count($arr_n) == 2) {
            $dot_n = $arr_n[1];
            $dot_n = substr($dot_n,0,1);
        }
        $return_no = 0;
        if($dot_n == 0) {
            $return_no = $no_f;
        }
        else {
            $return_no = $no_f.".".$dot_n;
        }
        return $return_no.$n_l_ext;
    }

    
?>