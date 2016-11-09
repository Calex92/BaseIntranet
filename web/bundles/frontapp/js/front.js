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