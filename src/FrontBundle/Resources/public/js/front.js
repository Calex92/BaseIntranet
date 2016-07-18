/**
 * Created by acastelain on 18/07/2016.
 */
$(".nav a").on("click", function(){
    $(".nav").find(".active").removeClass("active");
    $(this).parent().addClass("active");
});