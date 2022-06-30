$(document).ready(function () {
    $(window).click(function () {
        $("#popup_ele_modal").fadeOut("fast");
        // $("#message_icon_ele").attr("data-popup_modal_status", "0");
        $("#notafication_icon_ele").attr("data-popup_modal_status", "0");
        $("#account_icon_ele").attr("data-popup_modal_status", "0");

        $("#search_friend_modal").fadeOut("fast");
    });
    $("#popup_ele_modal").click(function (event) {
        event.stopPropagation();
    });
    $("#message_icon_ele").click(function (event) {
        // event.stopPropagation();
        // var modal_status = $("#message_icon_ele").attr("data-popup_modal_status");
        // if (modal_status == "0") {
        //     $("#popup_ele_modal").fadeIn("fast");

        //     // $("#message_icon_ele").attr("data-popup_modal_status", "1");
        //     $("#notafication_icon_ele").attr("data-popup_modal_status", "0");
        //     $("#account_icon_ele").attr("data-popup_modal_status", "0");
        // } else {
        //     $("#popup_ele_modal").fadeOut("fast");
        //     // $("#message_icon_ele").attr("data-popup_modal_status", "0");
        // }
        // $("#all_notafication").css("display", "none");
        // $("#account_settings").css("display", "none");
        // $("#all_messages").css("display", "block");

        $("#message_modal").modal("show");
        get_all_friend_in_message_modal();

        // $("#search_friend_modal").fadeOut("fast");

        $(this).tooltip('hide');
    });
    $("#notafication_icon_ele").click(function (event) {
        var current_notafication_ele = this;
        event.stopPropagation();
        var modal_status = $("#notafication_icon_ele").attr("data-popup_modal_status");

        
        if (modal_status == "0") {
            $("#popup_ele_modal").fadeIn("fast");

            // $("#message_icon_ele").attr("data-popup_modal_status", "0");
            $("#notafication_icon_ele").attr("data-popup_modal_status", "1");
            $("#account_icon_ele").attr("data-popup_modal_status", "0");
        } else {
            $("#popup_ele_modal").fadeOut("fast");
            $("#notafication_icon_ele").attr("data-popup_modal_status", "0");
        }
        // $("#all_messages").css("display", "none");
        $("#account_settings").css("display", "none");
        $("#all_notafication").css("display", "block");

        if($("#all_notafication").css("display") == "block") {
            $.ajax({
                url:"ajax_request/get_all_notafication_in_user",
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
                        $("#all_notafication").html(data.notification_data_ele);
    
                    }
                }
            });
        }

        $("#search_friend_modal").fadeOut("fast");

        $(current_notafication_ele).tooltip('hide');

    });
    $("#account_icon_ele").click(function (event) {
        event.stopPropagation();
        var modal_status = $("#account_icon_ele").attr("data-popup_modal_status");
        if (modal_status == "0") {
            $("#popup_ele_modal").fadeIn("fast");

            // $("#message_icon_ele").attr("data-popup_modal_status", "0");
            $("#notafication_icon_ele").attr("data-popup_modal_status", "0");
            $("#account_icon_ele").attr("data-popup_modal_status", "1");
        } else {
            $("#popup_ele_modal").fadeOut("fast");
            $("#account_icon_ele").attr("data-popup_modal_status", "0");
        }
        // $("#all_messages").css("display", "none");
        $("#all_notafication").css("display", "none");
        $("#account_settings").css("display", "block");

        $("#search_friend_modal").fadeOut("fast");

        $(this).tooltip('hide');
    });
    $("#search_ele").click(function (event) {
        event.stopPropagation();
        $("#search_friend_modal").fadeIn("fast");
        $("#search_result_ele").html("");
        $("#search__friend").val("");
        $("#search__friend").focus();

        $("#popup_ele_modal").fadeOut("fast");
        // $("#message_icon_ele").attr("data-popup_modal_status", "0");
        $("#notafication_icon_ele").attr("data-popup_modal_status", "0");
        $("#account_icon_ele").attr("data-popup_modal_status", "0");

        $("#search_ele").tooltip('hide');
    });
    $("#search_friend_modal").click(function (event) {
        event.stopPropagation();
    });
    $("#back_arrow_search").click(function () {
        $("#search_friend_modal").fadeOut("fast");
    });

    // $("#show_post_modal_demo").click();

    // $("#no_of_notafication").click(function (event) {
    //     event.stopPropagation();
    // });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});