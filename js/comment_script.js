$(document).ready(function(){
    $(document).on("click",".comment_div",function(){
        $(this).tooltip('hide');
        var comment_show_hide_staus = $(this).attr("data-comment_show_hide_staus");
        var p_next_sibling_ele = $(this).parent().next();
        // $(p_next_sibling_ele).find(".comment__column__ele .emojionearea").remove();
        // $(show_post_modal_2).css("display","block");
            
        // console.log(p_next_sibling_ele);
        var emojionearea_editor_ele = "";
        // console.log(emojionearea_editor_ele);
        var current_ele_div = this;
            
        if(comment_show_hide_staus == '0') {
            var show_post_modal_2 = $(p_next_sibling_ele).find(".show_post_modal_2");

            $(show_post_modal_2).emojioneArea({
                tonesStyle: "radio",
                // searchPosition: "bottom",
                pickerPosition: 'top',
                // filtersPosition: "bottom",
                placeholder: "Write a comment",
                // useInternalCDN: true,
            });
            setTimeout(function() {
                $(".emojionearea-button").css("order", "-100");
                $(".emojionearea-button").css("margin-right", "16px");
            }, 100);

            $(this).attr("data-comment_show_hide_staus","1");
            $(p_next_sibling_ele).fadeIn("400");
            // $(p_next_sibling_ele).css("display","block");

            emojionearea_editor_ele = $(p_next_sibling_ele).find(".emojionearea-editor");
            $(emojionearea_editor_ele).focus();
        }
        else {
            emojionearea_editor_ele = $(p_next_sibling_ele).find(".emojionearea-editor");
            $(emojionearea_editor_ele).focus();
        }
        var p_prev_sibling_ele = this.parentElement.previousElementSibling;
            var post_id = $(p_prev_sibling_ele).attr("data-p");
            var current_ele = this;
            var all__comment__ele = $(p_next_sibling_ele).find(".all__comment__ele");

        $.ajax({
            url: "ajax_request/get_comment",
            type: "POST",
            beforeSend:function() {
                $("#loading_animation_page").fadeIn("fast");
            },
            data: {
                post_id: post_id
            },
            dataType: "json",
            success: function(data) {
                if (data.error == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong | Reload The Page'
                    });
                } 
                else {
                    $(all__comment__ele).html(data.post_comment);
                    $(current_ele_div).attr("data-bs-original-title",data.comment_title);
                }
                $("#loading_animation_page").fadeOut("fast");
            }
        });
    });
    $(document).on("keydown",".comment__column__ele .emojionearea-editor",function(event){
        if(event.key == "Enter") {
            var form_ele = $(this).parents(".comment__column__ele");
            $(form_ele).submit();
        }
    });
    $(document).on("submit",".comment__column__ele",function(event) {
        event.preventDefault();

        var prev_prev_parent_ele = $(this).parents(".comment_show_hide_element").prev().prev();
        var post_id = $(prev_prev_parent_ele).attr("data-p");

        var comment_data = $(this).find(".emojionearea-editor").html();

        var current_ele = this;

        var next_sibling_ele = $(this).next();

        var comment_div_ele = $(this).parents(".comment_show_hide_element").prev().find(".comment_div");

            
        $.ajax({
            url:"ajax_request/set_comment",
            type:"POST",
            beforeSend:function() {
                $("#loading_animation_page").fadeIn("fast");
            },
            data:{
                comment_data:comment_data,
                post_id:post_id
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
                    if(data.comment_data == true) {
                        if(data.total_comment > 0) {
                            $(next_sibling_ele).prepend(data.comment_description);
                        }
                        else {
                            $(next_sibling_ele).html(data.comment_description);
                        }
                        $(comment_div_ele).attr("data-bs-original-title",data.comment_title);
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: data.comment_data
                        });
                    }
                }
                $("#loading_animation_page").fadeOut("fast");
                $(current_ele).find(".emojionearea-editor").html("");
            }
        });
    });
    $(document).on("click",".delete_comment_btn",function(){
        var comment_id = $(this).attr("data-cid");
        var m_parent_ele = $(this).parent().parent().parent();
        var post_id = $(this).parents(".comment_show_hide_element").prev().prev().attr("data-p");
        // console.log(post_id);
        var all__comment__ele_ = $(this).parents(".all__comment__ele");

        var comment_div_ele = $(this).parents(".comment_show_hide_element").prev().find(".comment_div");
        $.ajax({
            url:"ajax_request/comment_remove",
            type:"POST",
            beforeSend:function() {
                $("#loading_animation_page").fadeIn("fast");
            },
            data:{
                comment_id:comment_id,
                post_id:post_id
            },
            dataType:"json",
            success:function(data) {
                $("#loading_animation_page").fadeOut("fast");
                if (data.error == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong | Reload The Page'
                    });
                } 
                else {
                    $(m_parent_ele).fadeOut("fast",function(){
                        $(m_parent_ele).remove();
                    });
                    if(data.total_comment_in_post == 0) {
                        $(all__comment__ele_).html(data.comment_des);
                    }
                    $(comment_div_ele).attr("data-bs-original-title",data.comment_title);
                    Swal.fire({
                        icon: 'success',
                        title: 'Comment Deleted Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    })
    $(document).on("mouseenter", ".comment_date_time_ele,.rection___text", function() {
        $(this).tooltip('show');
    });
    $(document).on("mouseenter",".comment_div",function(){
        $(this).tooltip('show');
    });
});