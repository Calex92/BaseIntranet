/**
 * Created by acastelain on 18/07/2016.
 */
$(".nav a").on("click", function(){
    $(".nav").find(".active").removeClass("active");
    $(this).parent().addClass("active");
});

$(".list-group.small li").on("click", function() {
    $(".list-group.small").find(".active").removeClass("active");
    $(this).addClass("active");
});