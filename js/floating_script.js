for (var floating_ele of document.querySelectorAll(".floating_ele")) {
    $(floating_ele).append("<div class='floating_b_div'><div class='floating_b_div1 floating_b_inactive1'></div><div class='floating_b_div2 floating_b_inactive2'></div><div class='floating_b_div3 floating_b_inactive3'></div></div>");

    $(floating_ele).attr("data-remove_active_class_status", "0");
}

for (var ele of document.querySelectorAll(".floating_label")) {
    // var ele_width = (($(ele).css("width").split("p")[0]) / 1.2).toFixed(1);
    var ele_width = ((($(ele).css("width").split("p")[0]) * 0.8) + 7).toFixed(1);

    var s_ele_div = ele.nextElementSibling;

    var s_ele1 = s_ele_div.firstElementChild;
    var s_ele2 = s_ele1.nextElementSibling;

    $(s_ele2).css("width", ele_width + "px");
}

function f_set(ele_obj) {
    var parent_ele = ele_obj.parentElement;
    var remove_active_class_status = $(parent_ele).attr("data-remove_active_class_status");

    var s_ele_label = ele_obj.nextElementSibling;
    var s_ele_div = s_ele_label.nextElementSibling;


    var s_ele1 = s_ele_div.firstElementChild;
    var s_ele2 = s_ele1.nextElementSibling;
    var s_ele3 = s_ele2.nextElementSibling;


    $(s_ele_label).addClass("floating_item_active");

    if (remove_active_class_status == 1) {
        $(s_ele1).removeClass("floating_b_active_in");
        $(s_ele2).removeClass("floating_b_active_in");
        $(s_ele3).removeClass("floating_b_active_in");
        $(parent_ele).attr("data-remove_active_class_status", "0");
    }

    $(s_ele1).addClass("floating_b_active1");
    $(s_ele2).addClass("floating_b_active2");
    $(s_ele3).addClass("floating_b_active3");

    $(s_ele1).removeClass("floating_b_inactive1");
    $(s_ele2).removeClass("floating_b_inactive2");
    $(s_ele3).removeClass("floating_b_inactive3");
}

function b_set(ele_obj) {
    var parent_ele = ele_obj.parentElement;
    var remove_active_class_status = $(parent_ele).attr("data-remove_active_class_status");

    var input_v = ele_obj.value.trim();
    var s_ele_label = ele_obj.nextElementSibling;
    var s_ele_div = s_ele_label.nextElementSibling;

    var s_ele1 = s_ele_div.firstElementChild;
    var s_ele2 = s_ele1.nextElementSibling;
    var s_ele3 = s_ele2.nextElementSibling;

    if (input_v == "") {

        $(s_ele_label).removeClass("floating_item_active");

        if (remove_active_class_status == 1) {
            $(s_ele1).removeClass("floating_b_active_in");
            $(s_ele2).removeClass("floating_b_active_in");
            $(s_ele3).removeClass("floating_b_active_in");
            $(parent_ele).attr("data-remove_active_class_status", "0");
        }

        $(s_ele1).addClass("floating_b_inactive1");
        $(s_ele2).addClass("floating_b_inactive2");
        $(s_ele3).addClass("floating_b_inactive3");

        $(s_ele1).removeClass("floating_b_active1");
        $(s_ele2).removeClass("floating_b_active2");
        $(s_ele3).removeClass("floating_b_active3");
    }
    else {
        $(s_ele1).addClass("floating_b_active_in");
        $(s_ele2).addClass("floating_b_active_in");
        $(s_ele3).addClass("floating_b_active_in");
        $(parent_ele).attr("data-remove_active_class_status", "1");
    }
}

for (var ele of document.querySelectorAll(".floating_items")) {

    var input_v = ele.value.trim();
    if (input_v != "") {
        var s_ele_label = ele.nextElementSibling;
        var s_ele_div = s_ele_label.nextElementSibling;


        var s_ele1 = s_ele_div.firstElementChild;
        var s_ele2 = s_ele1.nextElementSibling;
        var s_ele3 = s_ele2.nextElementSibling;


        $(s_ele_label).addClass("floating_item_active");

        var parent_ele = ele.parentElement;

        $(s_ele1).addClass("floating_b_active_in");
        $(s_ele2).addClass("floating_b_active_in");
        $(s_ele3).addClass("floating_b_active_in");
        $(parent_ele).attr("data-remove_active_class_status", "1");

        $(s_ele1).addClass("floating_b_active1");
        $(s_ele2).addClass("floating_b_active2");
        $(s_ele3).addClass("floating_b_active3");

        $(s_ele1).removeClass("floating_b_inactive1");
        $(s_ele2).removeClass("floating_b_inactive2");
        $(s_ele3).removeClass("floating_b_inactive3");
    }
    $(ele).focus(function () {
        f_set(this);
        var class_a = $(this).attr("class").split(" ");
        if((class_a.length > 1) && class_a[1] == "date_picker") {
            $(this.nextElementSibling).css("color","var(--floating_b_active_-color)");
        }
    });
    $(ele).blur(function () {
        var class_a = $(this).attr("class").split(" ");
        if((class_a.length > 1) && class_a[1] == "date_picker") {
            
        }
        else {
            b_set(this);
        }
        
    });
}