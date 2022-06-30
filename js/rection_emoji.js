$(document).ready(function(){
    $(".like_div").hover(
        function () {
            $(this).children(".reaction-box").children().each(function (i, e) {
                setTimeout(function () {
                    $(e).addClass("show");
                }, i * 100);
            });
        },
        function () {
            $(this).children(".reaction-box").children().removeClass("show");
        }
    );
});