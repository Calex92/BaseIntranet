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

$(document).ready(function() {
    //If I don't check if the element exist, some error appear in the pages where the datatable is not setted.
    var myDatatable = $('#table-document-downloadable');
    if(myDatatable.length)
        myDatatable.DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "searchPlaceholder": "Recherche",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
        }
    });
} );
