$(function() {
    $(".j_evaluation li .fa-star").on("click", function () {
        if($(this).hasClass("active")) {
            $(this).removeClass("fas");
            $(this).addClass("far");
            $(this).removeClass("active");
        } else  {
            $(this).removeClass("far");
            $(this).addClass("fas");
            $(this).addClass("active");
        }
    });
});