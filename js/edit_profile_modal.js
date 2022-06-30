$(document).ready(function(){
    var current_date ="",current_month="",current_year="",active_date="",active_month,active_year="",input_date_picker_ele="",min_year="",max_year="";

    $(".date_picker").attr("data-next_btn_state","1");
    $(".date_picker").attr("data-prev_btn_state","1");

    function set_date_picker_ele(f_translate_value,l_translate_value,active_s) {
        $("#change_m_y span:first-child").css({"transform":"translateX("+f_translate_value+")","position":"absolute"});
        $("#change_m_y").append("<span>"+get_month_name(current_month,"l")+" "+current_year+"</span>");
        $("#change_m_y span:last-child").css("transform","translateX("+l_translate_value+")");
        setTimeout(function(){
            $("#change_m_y span:last-child").css("transform","translateX(0%)");
            $("#change_m_y span:first-child").remove();
        },90);

        $(".data_picker .data_picker_span:first-child").css({"transform":"translateX("+f_translate_value+")","position":"absolute"});
        var all_innerhtml = days_show(current_date,current_month,current_year,active_s);
        $(".data_picker").append(`<span class="data_picker_span">${all_innerhtml}</span>`);
        $(".data_picker .data_picker_span:last-child").css("transform","translateX("+l_translate_value+")");
        setTimeout(function(){
            $(".data_picker .data_picker_span:last-child").css("transform","translateX(0%)");
            $(".data_picker .data_picker_span:first-child").remove();
        },90);
    }

    function days_show(date,month,year,active_s) {
        var date_in_month = getDaysInMonth(month,year);
        var f_date_week_based_no  = get_week_based_no(1,month,year);
        var loop_no = "";
        if((date_in_month ==28 && f_date_week_based_no == 0)) {
            loop_no = 4*7;
        }
        else if(((date_in_month == 29 || date_in_month == 30 || date_in_month == 31) && f_date_week_based_no == 0)){
            loop_no = 5*7;
        }
        else if(((date_in_month == 28 || date_in_month == 29 || date_in_month == 30 || date_in_month == 31) && (f_date_week_based_no == 1 ||f_date_week_based_no == 2 || f_date_week_based_no == 3 || f_date_week_based_no == 4))) {
                loop_no = 5*7;
        }
        // else if(((date_in_month == 28 || date_in_month == 29 || date_in_month == 30 || date_in_month == 31) && f_date_week_based_no == 2)) {
        //     loop_no = 5*7;
        // }
        // else if(((date_in_month == 28 || date_in_month == 29 || date_in_month == 30 || date_in_month == 31) && f_date_week_based_no == 3)) {
        //     loop_no = 5*7;
        // }
        // else if(((date_in_month == 28 || date_in_month == 29 || date_in_month == 30 || date_in_month == 31) && f_date_week_based_no == 4)) {
        //     loop_no = 5*7;
        // }
        else if(((date_in_month == 28 || date_in_month == 29 || date_in_month == 30) && f_date_week_based_no == 5)) {
            loop_no = 5*7;
        }
        else if((date_in_month == 31 && f_date_week_based_no == 5)) {
            loop_no = 6*7;
        }
        else if(((date_in_month == 28 || date_in_month == 29) && f_date_week_based_no == 6)) {
            loop_no = 5*7;
        }
        else if(((date_in_month == 30 || date_in_month == 31) && f_date_week_based_no == 6)) {
            loop_no = 6*7;
        }
        var all_inner_html = "";
        for(var i=0;i<f_date_week_based_no;i++) {
            all_inner_html += `<div class="day_no in_active"></div>`;
        }
        for(var i=1;i<=date_in_month;i++) {
            if(active_s == 1) {
                if(date == i) {
                    all_inner_html += `<div class="day_no data_picker_active_date">${i}</div>`;
                }
                else {
                    all_inner_html += `<div class="day_no">${i}</div>`;
                }
            }
            else {
                all_inner_html += `<div class="day_no">${i}</div>`;
            }

        }
        for(var i=0;i<((loop_no - date_in_month)-f_date_week_based_no);i++) {
            all_inner_html += `<div class="day_no in_active"></div>`;
        }
        return all_inner_html;
    }

    function get_month_name(month_base_no,month_type) {
        var month_name = "";
        if(month_base_no == 1) {
            if(month_type == "s") {
                month_name = "Jan";
            }
            else {
                month_name = "January";
            }
        }
        else if(month_base_no == 2) {
            if(month_type == "s") {
                month_name = "Feb";
            }
            else {
                month_name = "February";
            }
        }
        else if(month_base_no == 3) {
            if(month_type == "s") {
                month_name = "Mar";
            }
            else {
                month_name = "March";
            }
        }
        else if(month_base_no == 4) {
            if(month_type == "s") {
                month_name = "Apr";
            }
            else {
                month_name = "April";
            }
        }
        else if(month_base_no == 5) {
            if(month_type == "s") {
                month_name = "May";
            }
            else {
                month_name = "May";
            }
        }
        else if(month_base_no == 6) {
            if(month_type == "s") {
                month_name = "Jun";
            }
            else {
                month_name = "June";
            }
        }
        else if(month_base_no == 7) {
            if(month_type == "s") {
                month_name = "Jul";
            }
            else {
                month_name = "July";
            }
        }
        else if(month_base_no == 8) {
            if(month_type == "s") {
                month_name = "Aug";
            }
            else {
                month_name = "August";
            }
        }
        else if(month_base_no == 9) {
            if(month_type == "s") {
                month_name = "Sep";
            }
            else {
                month_name = "September";
            }
        }
        else if(month_base_no == 10) {
            if(month_type == "s") {
                month_name = "Oct";
            }
            else {
                month_name = "October";
            }
        }
        else if(month_base_no == 11) {
            if(month_type == "s") {
                month_name = "Nov";
            }
            else {
                month_name = "November";
            }
        }
        else if(month_base_no == 12) {
            if(month_type == "s") {
                month_name = "Dec";
            }
            else {
                month_name = "December";
            }
        }
        return month_name;
    }

    function getDaysInMonth(month,year) {
        return new Date(year, month, 0).getDate();
    }
    function get_week_based_no(date,month,year) {
        return new Date(year, (month-1), date).getDay();
    }
    function get_week_name_in_specific_date(date,month,year) {
        var week_no_based =  get_week_based_no(date,month,year);
        var week_name_in_specific_date = "";
        if(week_no_based == 0) {
            week_name_in_specific_date = "Sun";
        }
        else if(week_no_based == 1) {
            week_name_in_specific_date = "Mon";
        }
        else if(week_no_based == 2) {
            week_name_in_specific_date = "Tue";
        }
        else if(week_no_based == 3) {
            week_name_in_specific_date = "Wed";
        }
        else if(week_no_based == 4) {
            week_name_in_specific_date = "Thu";
        }
        else if(week_no_based == 5) {
            week_name_in_specific_date = "Fri";
        }
        else if(week_no_based == 6) {
            week_name_in_specific_date = "Sat";
        }
        return week_name_in_specific_date;
    }

    function date_picker_loading(input_d_p_ele,min_year_diff,max_year_diff) {
        input_date_picker_ele = input_d_p_ele;
        var input_date_picker_v = input_date_picker_ele.value;

        var date = new Date();
        if(input_date_picker_v.trim() == "") {
            current_date = date.getDate();
            current_month = date.getMonth()+1;
            current_year = date.getFullYear();
        }
        else {
            current_date = Number(input_date_picker_v.split("/")[0]);
            current_month = Number(input_date_picker_v.split("/")[1]);
            current_year = Number(input_date_picker_v.split("/")[2]);
        }

        active_date = current_date;
        active_month = current_month;
        active_year = current_year;
        min_year = (date.getFullYear()) - min_year_diff;
        max_year = (date.getFullYear()) + max_year_diff;

        var all_innerhtml = days_show(active_date,active_month,active_year,1);
        $(".data_picker .data_picker_span").html(all_innerhtml);
        // days_show(this.active_date,9,this.active_year);
        $("#year").text(active_year);
        $("#day_name").text(get_week_name_in_specific_date(active_date,active_month,active_year));
        $("#date_name").text(active_date);
        $("#month_name").text(get_month_name(active_month,"l"));
        $("#change_m_y").html("<span>"+get_month_name(active_month,"l")+" "+active_year+"</span>");

        var year_list_e = `<div id="year_list_container" class="container position-absolute">`;
        for(var i = min_year;i<=max_year;i++) {
            if(i == active_year) {
                year_list_e +=  `<div class="row">
                                    <div class="col year_list_items year_list_item_active">${i}</div>
                                </div>`;
            }
            else {
                year_list_e +=  `<div class="row">
                                    <div class="col year_list_items">${i}</div>
                                </div>`;
            }
        }
        year_list_e += `</div>`;
        $("#year_list").html(year_list_e);

        var scroll_top_bottom_value1 = (($(".year_list_item_active").parent().prevAll().length)-2)*34;
        // console.log(scroll_top_bottom_value1);
        setTimeout(function(){
            $("#year_list_container").scrollTop(scroll_top_bottom_value1);
        },160);


        var month_list_e = `<div id="month_list_container" class="container position-absolute">`;
        for(var i = 1;i<=12;i++) {
            if(active_month == i) {
                month_list_e += `<div class="row">
                                <div class="col month_list_items month_list_item_active" data-month_base_no="${i}">${get_month_name(i,"l")}</div>
                            </div>`;
            }
            else {
                month_list_e += `<div class="row">
                                <div class="col month_list_items" data-month_base_no="${i}">${get_month_name(i,"l")}</div>
                            </div>`;
            }
        }
        month_list_e += `</div>`;
        $("#month_list").html(month_list_e);

        var scroll_top_bottom_value2 = (($(".month_list_item_active").parent().prevAll().length)-2)*34;
        // console.log(scroll_top_bottom_value2);
        setTimeout(function(){
            $("#month_list_container").scrollTop(scroll_top_bottom_value2);
        },160);
        $("#year_list").css("display","block");
        $("#month_list").css("display","block");

        if((current_year == max_year) && (current_month == 12)) {
            document.getElementById("next_date").disabled = true;
            $("#next_date").addClass("cursor_not_allowed");
            document.getElementById("next_date").firstElementChild.classList.remove("active_css_icon");
            $(input_date_picker_ele).attr("data-next_btn_state","0");
        }
        else {
            // if($(input_date_picker_ele).attr("data-next_btn_state") == "0") {
                document.getElementById("next_date").disabled = false;
                $("#next_date").removeClass("cursor_not_allowed");
                document.getElementById("next_date").firstElementChild.classList.add("active_css_icon");
                $(input_date_picker_ele).attr("data-next_btn_state","1");
            // }
        }

        if((current_year == min_year) && (current_month == 1)) {
            document.getElementById("prev_date").disabled = true;
            $("#prev_date").addClass("cursor_not_allowed");
            document.getElementById("prev_date").firstElementChild.classList.remove("active_css_icon");
            $(input_date_picker_ele).attr("data-prev_btn_state","0");
        }
        else {
            // if($(input_date_picker_ele).attr("data-prev_btn_state") == "0") {
                document.getElementById("prev_date").disabled = false;
                $("#prev_date").removeClass("cursor_not_allowed");
                document.getElementById("prev_date").firstElementChild.classList.add("active_css_icon");
                $(input_date_picker_ele).attr("data-prev_btn_state","1");
            // }
        }
    }

    $(document).on("click",".day_no",function() {
        $(".data_picker_active_date").removeClass("data_picker_active_date");
        $(this).addClass("data_picker_active_date");

        active_date = $(this).text();
        current_date = $(this).text();

        active_month = current_month;
        active_year = current_year;

        $("#day_name").text(get_week_name_in_specific_date(active_date,active_month,active_year));
        $("#date_name").text(active_date);
        $("#month_name").text(get_month_name(active_month,"l"));
        $("#year").text(active_year);
        $(".year_list_item_active").removeClass("year_list_item_active");

        for(var year_list_item_ele of document.querySelectorAll(".year_list_items")) {
            if($(year_list_item_ele).text().trim() == active_year) {
                $(year_list_item_ele).addClass("year_list_item_active");
            }
        }
    });

    $("#next_date").click(function(){
        if(current_year <= max_year) {
            if(current_month < 12) {
                current_month = current_month+1;
                if((current_year == max_year) && (current_month == 12)) {
                    document.getElementById("next_date").disabled = true;
                    $("#next_date").addClass("cursor_not_allowed");
                    document.getElementById("next_date").firstElementChild.classList.remove("active_css_icon");
                    $(input_date_picker_ele).attr("data-next_btn_state","0");
                }
            }
            else {
                current_month = 1;
                current_year = current_year + 1;
            }
                    

            if((active_month == current_month) && (active_year == current_year)) {
                set_date_picker_ele("-100%","100%",1);
            }
            else {
                set_date_picker_ele("-100%","100%",0);
            }


            if($(input_date_picker_ele).attr("data-prev_btn_state") == "0") {
                document.getElementById("prev_date").disabled = false;
                $("#prev_date").removeClass("cursor_not_allowed");
                document.getElementById("prev_date").firstElementChild.classList.add("active_css_icon");
                $(input_date_picker_ele).attr("data-prev_btn_state","1");
            }

            // console.log("Current d :"+current_date+" "+current_month+" "+current_year);
            // console.log("Active d :"+active_date+" "+active_month+" "+active_year);
        }
    });

    $("#prev_date").click(function(){
        if(current_year >= min_year) {
            if(current_month > 1) {
                current_month = current_month-1;
                if((current_year == min_year) && (current_month == 1)) {
                    document.getElementById("prev_date").disabled = true;
                    $("#prev_date").addClass("cursor_not_allowed");
                    document.getElementById("prev_date").firstElementChild.classList.remove("active_css_icon");
                    $(input_date_picker_ele).attr("data-prev_btn_state","0");
                }
            }
            else {
                current_month = 12;
                current_year = current_year - 1;
            }
                    

            if((active_month == current_month) && (active_year == current_year)) {
                set_date_picker_ele("100%","-100%",1);
            }
            else {
                set_date_picker_ele("100%","-100%",0);
            }

            if($(input_date_picker_ele).attr("data-next_btn_state") == "0") {
                document.getElementById("next_date").disabled = false;
                $("#next_date").removeClass("cursor_not_allowed");
                document.getElementById("next_date").firstElementChild.classList.add("active_css_icon");
                $(input_date_picker_ele).attr("data-next_btn_state","1")
            }

            // console.log("Current d :"+current_date+" "+current_month+" "+current_year);
            // console.log("Active d :"+active_date+" "+active_month+" "+active_year);
        }
    });

    $("#clear_date_picker").click(function(){
        var date = new Date();
        current_date = date.getDate();
        current_month = date.getMonth()+1;
        current_year = date.getFullYear();
        active_date = current_date;
        active_month = current_month;
        active_year = current_year;

        set_date_picker_ele("-100%","100%",1);
        $("#year").text(active_year);
        $("#day_name").text(get_week_name_in_specific_date(active_date,active_month,active_year));
        $("#date_name").text(active_date);
        $("#month_name").text(get_month_name(active_month,"l"));

        $("#year_list").fadeIn("fast",function(){
        $(".year_list_item_active").removeClass("year_list_item_active");

            for(var year_list_item_ele of document.querySelectorAll(".year_list_items")) {
                if($(year_list_item_ele).text().trim() == active_year) {
                    $(year_list_item_ele).addClass("year_list_item_active");
                    var scroll_top_bottom_value = (($(".year_list_item_active").parent().prevAll().length)-2)*34;
                    // console.log(scroll_top_bottom_value);
                    $("#year_list_container").scrollTop(scroll_top_bottom_value);
                }
            }
            input_date_picker_ele.value = "";
        });
    });

    $("#set_date").click(function() {
        var a_date = (active_date<10)?("0"+active_date):(active_date);
        var a_month = (active_month<10)?("0"+active_month):(active_month);
        var date_pick_value = a_date+"/"+a_month+"/"+active_year;
        // console.log(date_pick_value);
        $(input_date_picker_ele).val(date_pick_value);
        $("#date_picker_modal").modal("hide"); 
        // console.log(input_date_picker_ele);
        // b_set(input_date_picker_ele);
        // $(input_date_picker_ele.nextElementSibling).css("color","rgba(0, 0, 0, 0.6)");
        // $("#data_picker_span").empty();
    });
    $("#close_date_picker_modal").click(function(){
        // b_set(input_date_picker_ele);
        // $(input_date_picker_ele.nextElementSibling).css("color","rgba(0, 0, 0, 0.6)");
        // $("#data_picker_span").empty();
    });

    $(document).on("click",".year_list_items",function(){
        $(".year_list_item_active").removeClass("year_list_item_active");
        $(this).addClass("year_list_item_active");

        var scroll_top_bottom_value = (($(".year_list_item_active").parent().prevAll().length)-2)*34;
                // console.log(scroll_top_bottom_value);
        $("#year_list_container").scrollTop(scroll_top_bottom_value);

        active_year = Number($(this).text());

        // current_month = active_month;
        current_year = active_year;
        $("#year_list").fadeOut("fast",function(){
            // set_date_picker_ele("-100%","100%",1);

            // $("#month_list").css("display","block");
            // $("#month_list").fadeIn("fast",function(){
                $(".month_list_item_active").removeClass("month_list_item_active");
                for(var month_list_item_ele of document.querySelectorAll(".month_list_items")) {
                    if(($(month_list_item_ele).attr("data-month_base_no")).trim() == current_month) {
                        $(month_list_item_ele).addClass("month_list_item_active");

                        var scroll_top_bottom_value3 = (($(".month_list_item_active").parent().prevAll().length)-2)*34;
                        // console.log(scroll_top_bottom_value3);
                        $("#month_list_container").scrollTop(scroll_top_bottom_value3);
                    }
                }
            // });

                    

            $("#day_name").text(get_week_name_in_specific_date(active_date,active_month,active_year));
            $("#date_name").text(active_date);
            $("#month_name").text(get_month_name(active_month,"l"));
            $("#year").text(active_year);

            // console.log("Current d :"+current_date+" "+current_month+" "+current_year);
            // console.log("Active d :"+active_date+" "+active_month+" "+active_year);
        });
    });

    $(document).on("click",".month_list_items",function(){
        $(".month_list_item_active").removeClass("month_list_item_active");
        $(this).addClass("month_list_item_active");

        current_month = Number($(this).attr("data-month_base_no"));
        $("#month_list").fadeOut("fast",function(){
            if((active_month == current_month) && (active_year == current_year)) {
                // set_date_picker_ele("100%","-100%",1);
            }
            else {
                set_date_picker_ele("100%","-100%",0);
            }

            if((current_year == max_year) && (current_month == 12)) {
                document.getElementById("next_date").disabled = true;
                $("#next_date").addClass("cursor_not_allowed");
                document.getElementById("next_date").firstElementChild.classList.remove("active_css_icon");
                $(input_date_picker_ele).attr("data-next_btn_state","0");
            }
            else {
                if($(input_date_picker_ele).attr("data-next_btn_state") == "0") {
                    document.getElementById("next_date").disabled = false;
                    $("#next_date").removeClass("cursor_not_allowed");
                    document.getElementById("next_date").firstElementChild.classList.add("active_css_icon");
                    $(input_date_picker_ele).attr("data-next_btn_state","1");
                }
            }

            if((current_year == min_year) && (current_month == 1)) {
                document.getElementById("prev_date").disabled = true;
                $("#prev_date").addClass("cursor_not_allowed");
                document.getElementById("prev_date").firstElementChild.classList.remove("active_css_icon");
                $(input_date_picker_ele).attr("data-prev_btn_state","0");
            }
            else {
                if($(input_date_picker_ele).attr("data-prev_btn_state") == "0") {
                    document.getElementById("prev_date").disabled = false;
                    $("#prev_date").removeClass("cursor_not_allowed");
                    document.getElementById("prev_date").firstElementChild.classList.add("active_css_icon");
                    $(input_date_picker_ele).attr("data-prev_btn_state","1");
                }
            }

            // console.log("Current d :"+current_date+" "+current_month+" "+current_year);
            // console.log("Active d :"+active_date+" "+active_month+" "+active_year);
        });
    });

    $("#year").click(function(){
        var display_status = $("#year_list").css("display");
        if(display_status == "block") {
            $("#month_list").css("display","none");
            $("#year_list").fadeOut(400);
        }
        else {
            $("#year_list").fadeIn("fast",function(){
                $("#month_list").css("display","block");
            });
            var scroll_top_bottom_value = (($(".year_list_item_active").parent().prevAll().length)-2)*34;
            $("#year_list_container").scrollTop(scroll_top_bottom_value);
        }
    });


    $(".date_picker").focus(function(){
        $("#date_picker_modal").modal("show");   
        date_picker_loading(this,100,0);//input_ele,min_year_diff,max_year_diff
    });
    $(".date_picker_icon").click(function(){
        $("#date_picker_modal").modal("show");   
        date_picker_loading(this.nextElementSibling,100,1);//input_ele,min_year_diff,max_year_diff
        // f_set(this.nextElementSibling);
        // $(this.nextElementSibling.nextElementSibling).css("color","var(--floating_b_active_-color)");
    });    
});






$("#show_p_password_v").click(function() {
    var password = document.getElementById("v_user_p_password");
    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
});
$("#show_p_password").click(function() {
    var password = document.getElementById("user_p_password");
    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
});


$("#settings_privacy").click(function(event){
    event.preventDefault();
    $.ajax({
        url:"ajax_request/get_login_user_profile__details",
        type:"POST",
        dataType:"json",
        success:function(data){
            $("#user_p_img_l").html(data.profile_img_t);
            $("#user_p_name").val(data.user_name);
            $("#user_p_email").val(data.user_email);
            $("#user_p_dob").val(data.dob);
            $("#user_p_gender").val(data.gender);
        }
    });
    $("#user_profile_modal_edit").modal("show");
});

$(document).on("submit","#user_details_update_form",function(event){
    event.preventDefault();
    $("#user_details_update_form .error-r").fadeOut();
    var formData = new FormData(this);
    $.ajax({
        url:"ajax_request/update_login_user_profile__details",
        type:"POST",
        beforeSend:function(){
            $("#loading_animation_page").fadeIn("fast");
        },
        data: formData,
        contentType: false,
        processData: false,
        dataType:"json",
        success:function(data){
            if (data.error == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Something Went Wrong'
                });
            }
            else {
                if (data.user_p_name != true) {
                    $("#error1").fadeIn();
                    $("#error1").html(data.user_p_name);
                }
                if (data.user_p_dob != true) {
                    $("#error2").fadeIn();
                    $("#error2").html(data.user_p_dob);
                }
                if (data.user_p_gender != true) {
                    $("#error3").fadeIn();
                    $("#error3").html(data.user_p_gender);
                }
                if (data.success == 1) {
                    $("#user_details_update_form .error-r").fadeOut();
                    Swal.fire({
                        icon: 'success',
                        title: 'Your Profile Update Successfully | Reload The Page for Reflect Your Profile Details',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
            $("#loading_animation_page").fadeOut("fast");
        }
    });
});

$("#change_user_password_btn_").click(function(){
    $("#user_profile_modal_edit").modal("hide");
    $("#p_verify_you_modal_d").modal("show");
    $("#v_user_p_password").focus();
});

$(document).on("submit","#p_v_form",function(event){
    event.preventDefault();
    $("#p_v_form .error-r").fadeOut();
    var formData = new FormData(this);
    $.ajax({
        url:"ajax_request/verify_password_in_user",
        type:"POST",
        beforeSend:function(){
            $("#loading_animation_page").fadeIn("fast");
        },
        data: formData,
        contentType: false,
        processData: false,
        dataType:"json",
        success:function(data){
            if (data.error == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Something Went Wrong'
                });
            }
            else {
                if (data.v_user_p_password != true) {
                    $("#error_p_v").fadeIn();
                    $("#error_p_v").html(data.v_user_p_password);
                    $("#v_user_p_password").focus();
                }
                if (data.success == 1) {
                    $("#v_user_p_password").val("");
                    $("#p_v_form .error-r").fadeOut();
                    $("#p_verify_you_modal_d").modal("hide");
                    $("#change_password_modal_d").modal("show");
                    $("#user_p_password").focus();
                }
                else if(data.success == 0) {
                    $("#error_p_v").fadeIn();
                    $("#error_p_v").html("Enter The Valid Password");
                    $("#v_user_p_password").focus();
                }
            }
            $("#loading_animation_page").fadeOut("fast");
        }
    });
});

$("#change_password_modal_d_close").click(function(){
    $.ajax({
        url:"ajax_request/remove_v_s",
        type:"POST",
        success:function(data){
        }
    });
});

$(document).on("submit","#change_password_m_form",function(event){
    event.preventDefault();
    $("#change_password_m_form .error-r").fadeOut();
    var formData = new FormData(this);
    $.ajax({
        url:"ajax_request/change_u_p",
        type:"POST",
        beforeSend:function(){
            $("#loading_animation_page").fadeIn("fast");
        },
        data: formData,
        contentType: false,
        processData: false,
        dataType:"json",
        success:function(data){
            if (data.error == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Something Went Wrong'
                });
            }
            else {
                if(data.u_v_s == true) {
                    if (data.v_user_p_password != true) {
                        $("#error_n_2").fadeIn();
                        $("#error_n_2").html(data.user_p_password);
                        $("#user_p_password").focus();
                    }
                    if (data.success == 1) {
                        $("#user_p_password").val("");
                        $("#change_password_m_form .error-r").fadeOut();
                        $("#change_password_modal_d").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: 'Password Change Successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: data.u_v_s
                    });
                }
            }
            $("#loading_animation_page").fadeOut("fast");
        }
    });
});