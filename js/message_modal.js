var clear_set_interval_c = "";
var clear_set_interval_new_message_in_other_user = "";
var current_user_message_data_id = "";
var check_new_message_in_other_user_f_call_status = 0;
var clear_set_interval_get_all_friend_in_message_modal = "";
setInterval(function(){
    $.ajax({
        url:"ajax_request/time_update_user",
        type:"POST",
        success:function(data) {}
    });
    $.ajax({
        url:"ajax_request/no_of_notification_show",
        type:"POST",
        dataType:"json",
        success:function(data){
            if (data.error == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Something Went Wrong | Reload The Page'
                });
            }
            else {
                if(data.no_of_notafication > 0) {
                    $("#no_of_notafication").css("display","block");
                }
                else {
                    $("#no_of_notafication").css("display","none");
                }
                $("#no_of_notafication #inner_no_of_notafication").html(data.no_of_notafication);
            }
        }
    });
},1000);

function check_new_message_in_other_user() {
    var current_f_u_id = $(".user_details_in_message__top_friend_name").attr("data-current_fid");
    if(current_f_u_id != 0) {
        clear_set_interval_new_message_in_other_user = setInterval(function(){
            //console.log(current_user_message_data_id +" ---- : "+current_f_u_id);
            $.ajax({
                url:"ajax_request/get_new_message_in_other_user",
                type:"POST",
                data:{
                    friend_user_id:current_f_u_id,
                    current_user_message_data_id:current_user_message_data_id
                },
                dataType:"json",
                success:function(data) {
                    if (data.error == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong | Reload The Page'
                        });
                    }
                    else {
                        setTimeout(function(){
                            if(data.message__data != "") {
                                $(".message_user_details_middle").append(data.message__data);

                                var child_ele = $(".message_user_details_middle").children();
                                var child_ele_height = 0;
                                for (c_ele of child_ele) {
                                    child_ele_height += Number(($(c_ele).css("height")).split("p")[0]);
                                }
                                $(".message_user_details_middle").scrollTop(child_ele_height + 100000000000);
                            }
                            current_user_message_data_id = data.current_user_message_data_id;
                            // console.log(current_user_message_data_id);
    
                            $(".user_details_in_message__top_img_text_ele").html(data.friend_profile_image);
                            $(".user_details_in_message__top_friend_name").html(data.friend_user_name);
                            // $(".user_details_in_message__top_friend_name").attr("data-current_fid",data.friend_user_id);
                            $(".user_details_in_message__top_friend_online_status").html(data.last_login_status);
    
                            
                        },1000);
                    }
                }
            });
        },1500);
    }
    else {
        check_new_message_in_other_user_f_call_status = 0;
    }
}

function get_c_f_login_status(friend_id) {
    clear_set_interval_c = setInterval(function(){
        $.ajax({
            url:"ajax_request/click_user_login_status",
            type:"POST",
            data:{
                friend_user_id:friend_id
            },
            dataType:"json",
            success:function(data){
                if (data.error == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong | Reload The Page'
                    });
                }
                else {
                    $(".user_details_in_message__top_friend_online_status").html(data.last_login_status)
                }
            }
        });   
    },1500);
}
function get_all_friend_in_message_modal_set_interval() {
    clear_set_interval_get_all_friend_in_message_modal = setInterval(function(){
        $.ajax({
            url:"ajax_request/get_all_friend_in_message_modal",
            type: "POST",
            success: function(data) {
                $(".message_user_ele1").html(data);
            }
        });
    },1500);
}
function get_all_friend_in_message_modal() {
    $.ajax({
        url:"ajax_request/get_all_friend_in_message_modal",
        type: "POST",
        beforeSend:function() {
            $("#loading_animation_page").fadeIn("fast");
        },
        success: function(data) {
            $(".message_user_ele1").html(data);
            $("#loading_animation_page").fadeOut("fast");
            
            $("#message_user_ele").css("transform","translateX(0%)");
            $("#message_details_ele").css("transform","translateX(0%)");

            get_all_friend_in_message_modal_set_interval();
        }
    });
}
function get_click_friend_details_in_messsage(friend_id) {
    $.ajax({
        url:"ajax_request/get_click_friend_details_in_messsage",
        type:"POST",
        data:{
            friend_user_id:friend_id
        },
        beforeSend:function() {
            $("#loading_animation_page").fadeIn("fast");
        },
        dataType:"json",
        success:function(data){
            if (data.error == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Something Went Wrong | Reload The Page'
                });
            }
            else {
                $("#message_user_ele").css("transform","translateX(-100%)");
                $("#message_details_ele").css("transform","translateX(-100%)");

                
                // get_c_f_login_status(friend_id);

                $(".message_user_details_middle").html(data.message__data);

                current_user_message_data_id = data.current_user_message_data_id;
                // console.log(current_user_message_data_id);

                $(".user_details_in_message__top_img_text_ele").html(data.friend_profile_image);
                $(".user_details_in_message__top_friend_name").html(data.friend_user_name);
                $(".user_details_in_message__top_friend_name").attr("data-current_fid",data.friend_user_id);
                $(".user_details_in_message__top_friend_online_status").html(data.last_login_status);
                
                check_new_message_in_other_user();

                var child_ele = $(".message_user_details_middle").children();
                var child_ele_height = 0;
                for (c_ele of child_ele) {
                    child_ele_height += Number(($(c_ele).css("height")).split("p")[0]);
                }
                $(".message_user_details_middle").scrollTop(child_ele_height + 100000000000);
            }
            $("#loading_animation_page").fadeOut("fast");
        }
    });
}
$(document).ready(function(){

    $(document).on("click",".message_user_div__ele",function(){
        // $("#message_user_ele").css("transform","translateX(-100%)");
        // $("#message_details_ele").css("transform","translateX(-100%)");

        var friend_id = $(this).attr("data-fid");
        
        if(clear_set_interval_get_all_friend_in_message_modal != "") {
            clearInterval(clear_set_interval_get_all_friend_in_message_modal);
        }
        get_click_friend_details_in_messsage(friend_id);
    });
    
    $(document).on("click","#arrow_back_btn",function(){
        // $("#message_user_ele").css("transform","translateX(0%)");
        // $("#message_details_ele").css("transform","translateX(0%)");
        get_all_friend_in_message_modal();
        // $("#search_user_in_message").focus();
        $("#message_send_by_input").val("");
        clearInterval(clear_set_interval_c);

        clearInterval(clear_set_interval_new_message_in_other_user)
    });
    $("#message_modal_close_icon").click(function(){
        if(clear_set_interval_c != "") {
            clearInterval(clear_set_interval_c);
        }

        if(clear_set_interval_new_message_in_other_user != "") {
            clearInterval(clear_set_interval_new_message_in_other_user);
        }

        if(clear_set_interval_get_all_friend_in_message_modal != "") {
            clearInterval(clear_set_interval_get_all_friend_in_message_modal);
        }
    })
    
    $(document).on("input","#search_user_in_message",function(){
        var search_values = $(this).val().trim();

        if(search_values == "") {
            $(".message_user_ele1").css("display","block");
            $(".message_user_ele2").css("display","none");
        }
        else {
            $(".message_user_ele1").css("display","none");
            $(".message_user_ele2").css("display","block");

            $.ajax({
                url: "ajax_request/search_friend_in_message_modal",
                type: "POST",
                data: {
                    search_value: search_values
                },
                dataType: "json",
                success: function(data) {
                    if (data.error == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong | Reload The Page'
                        });
                    } else {
                        $(".message_user_ele2").html(data.search_result);
                    }
                }
            });
        }
    });


    //message send
    $(document).on("submit","#u_send_message_from",function(event) {
        event.preventDefault();

        var user_set__message = $("#message_send_by_input").val().trim();

        var f_u_id = $(".user_details_in_message__top_friend_name").attr("data-current_fid");

        $.ajax({
            url: "ajax_request/message_send_in_friend",
            type: "POST",
            data: {
                message: user_set__message,
                friend_user_id: f_u_id,
                current_user_message_data_id:current_user_message_data_id
            },
            dataType:"json",
            success: function(data) {
                if (data.error == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong | Reload The Page'
                    });
                }
                else {
                    if(data.message_empty == true) {
                        $(".message_user_details_middle").append(data.message_send_data);
                        $("#message_send_by_input").val("");
                        current_user_message_data_id=data.current_user_message_data_id;
                    }
                    else if(data.message_empty !=true) {
                        Swal.fire({
                            icon: 'error',
                            title: data.message_empty
                        });
                    }
                }
                
                var child_ele = $(".message_user_details_middle").children();
                var child_ele_height = 0;
                for (c_ele of child_ele) {
                    child_ele_height += Number(($(c_ele).css("height")).split("p")[0]);
                }
                // console.log(child_ele_height);
                $(".message_user_details_middle").scrollTop(child_ele_height + 100000000000);
            }
        });
    });


    var message_all_doc_inner_ele_show_status = 0;
    var message_video_play_state_in_modal = 0;
    $("#message_all_doc_outer").click(function(event) {
        event.stopPropagation();
        if(message_all_doc_inner_ele_show_status == 0) {
            $("#message_all_doc_outer #all_doc_inner").fadeIn("fast");
            message_all_doc_inner_ele_show_status = 1;
        }
        else {
            $("#message_all_doc_outer #all_doc_inner").fadeOut("fast");
            message_all_doc_inner_ele_show_status = 0;
        }
    });
    $("#message_all_doc_outer #all_doc_inner").click(function(event) {
        event.stopPropagation();
    });
    $(window).click(function() {
        if(message_all_doc_inner_ele_show_status == 1) {
            $("#message_all_doc_outer #all_doc_inner").fadeOut("fast");
            message_all_doc_inner_ele_show_status = 0;
        }
    });
    
    $(document).on("click", ".user_message_description_img_video_style img", function(event) {
        var ele = $(this).clone();
        $("#image_zoom_modal").modal("show");
        $("#image_zoom_modal_col").html(ele);
    });
    $(document).on("click", ".user_message_description_img_video_style video", function(event) {
        event.preventDefault();
        // document.querySelectorAll(".img_style_post_set video").pause();
        for (var ele_video of document.querySelectorAll(".user_message_description_img_video_style video")) {
            ele_video.pause();
        }
        // $(this).pause();
        // this.currentTime = 0;
        var ele = $(this).clone();
        $("#image_zoom_modal").modal("show");
        $("#image_zoom_modal_col").html(ele);
        document.querySelector("#image_zoom_modal_col video").play();
        message_video_play_state_in_modal = 1;
    });
    $("#image_zoom_modal_close").click(function() {
        if (message_video_play_state_in_modal == 1) {
            document.querySelector("#image_zoom_modal_col video").pause();
            document.querySelector("#image_zoom_modal_col video").currentTime = 0;
            message_video_play_state_in_modal = 0;
        }
    });


    $("#message_all_doc_outer #image_send_c").change(function(event) {
        $("#message_all_doc_outer #all_doc_inner").submit();
    });
    $("#message_all_doc_outer #document_send_m").change(function(event) {
        $("#message_all_doc_outer #all_doc_inner").submit();
    });
    $("#message_all_doc_outer #all_doc_inner").submit(function(event) {
        event.preventDefault();

        $("#message_all_doc_outer #all_doc_inner").fadeOut("fast");
        message_all_doc_inner_ele_show_status = 0;

        var f_u_id = $(".user_details_in_message__top_friend_name").attr("data-current_fid");
        var formData = new FormData(this);
        formData.append("friend_user_id",f_u_id);
        formData.append("current_user_message_data_id",current_user_message_data_id);

        $.ajax({
            url: "ajax_request/send_img_video_doc_in_message",
            type: "POST",
            beforeSend: function() {
                $("#loading_animation_page").fadeIn("fast");
            },
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                var mess_send___status = 0;
                if (data.error == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong | Reload The Page'
                    });
                }
                else {
                    if ((data.img_video == 1)) {
                        if (data.file_check_status != true) {
                            Swal.fire({
                                icon: 'warning',
                                html: '<span style="color:red;font-size: 20px;font-weight: 600;">' + data.file_check_status + '<span>'
                            });
                        } 
                        else {
                            mess_send___status = 1;
                            setTimeout(function(){
                                $(".message_user_details_middle").append(data.file_data);
                                $("#loading_animation_page").fadeOut("fast");
                                current_user_message_data_id = data.current_user_message_data_id;
                                var child_ele = $(".message_user_details_middle").children();
                                var child_ele_height = 0;
                                for (c_ele of child_ele) {
                                    child_ele_height += Number(($(c_ele).css("height")).split("p")[0]);
                                }
                                $(".message_user_details_middle").scrollTop(child_ele_height + 100000000000);
                            },1000);
                        }
                    } 
                    else if (data.document == 1) {
                        if (data.file_check_status != true) {
                            Swal.fire({
                                icon: 'warning',
                                html: '<span style="color:red;font-size: 20px;font-weight: 600;">' + data.file_check_status + '<span>'
                            });
                        } 
                        else {
                            $(".message_user_details_middle").append(data.file_data);
                            current_user_message_data_id = data.current_user_message_data_id;
                        }
                    }
                }
                $("#message_all_doc_outer #image_send_c").val("");
                $("#message_all_doc_outer #document_send_m").val("");
                if(mess_send___status == 0) {
                    $("#loading_animation_page").fadeOut("fast");
                    var child_ele = $(".message_user_details_middle").children();
                    var child_ele_height = 0;
                    for (c_ele of child_ele) {
                        child_ele_height += Number(($(c_ele).css("height")).split("p")[0]);
                    }
                    $(".message_user_details_middle").scrollTop(child_ele_height + 100000000000);
                }
                
            }
        });
    });


    // download document
    function download(document_name_d, url) {
        var element_a_t = document.createElement('a');
        element_a_t.setAttribute('href',url);
        element_a_t.setAttribute('download', document_name_d);
        document.body.appendChild(element_a_t);
        element_a_t.click();
        document.body.removeChild(element_a_t);
    }
    $(document).on("click", ".download_icon", function(event) {
        $("#loading_animation_page").fadeIn("fast");
        var click_btn = this;
        var document_name = $(this).attr("data-document_src");
        var url = "message_i_v_d/" + document_name;
        var document_name_d = click_btn.previousElementSibling.lastElementChild.innerText;

        download(document_name_d, url);
        $("#loading_animation_page").fadeOut("fast");
    });
});