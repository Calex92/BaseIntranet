/**
 * Created by acastelain on 18/07/2016.
 */

/*-------------------------------------------------
 *  PNotify permet d'afficher des notifications
 *-------------------------------------------------
*/
PNotify.prototype.options.styling = "bootstrap3";

//The fonction should be called like that
//notify("Titre", "Message", "success", undefined);
function notify(title, message, type, icon) {
    $(function(){
        new PNotify({
            title: typeof title !== 'undefined' ? title : "",
            text: typeof message !== 'undefined' ? message : "Aucun message défini",
            type: typeof type !== 'undefined' ? type : "info",
            icon: typeof icon !== 'undefined' ? icon : ""
        });
    });
}

$(function() {
    $(".chosen-select").chosen({no_results_text: "Aucun résultat pour"});

    $('.dropdown-submenu>a').unbind('click').click(function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });

    $(".dropdown-submenu").hover(function () {
        $(this).children(".dropdown-menu").toggle();
    });
});