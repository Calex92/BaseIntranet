/**
 * Created by acastelain on 05/09/2016.
 */

/* Listener on the button to add the agency in the user list*/
$("#add_agency").on("click", function() {
    var user_admin_edit_agencies = $("#user_admin_edit_agencies").val();
    if (user_admin_edit_agencies != null)
    {
        updateAgency("add", user_admin_edit_agencies, $("#id_user").val());
    }
    else {
        writeMessage("Aucune agence sélectionnée", "warning");
    }
});

/* Listener on the button to delete an agency in the user list */
$(".remove_agency").on("click", function() {
   updateAgency("remove", $(this).attr("data-value"))
});

function updateAgency(type, idAgency, idUser) {

    switch (type) {
        case "add":
            //Disable the "Add Agency" button whe it's an add type
            $("#add_agency").addClass("disabled");
            break;
    }
    //The cursor is now "waiting" the Ajax callbacks
    $('html, body').css("cursor", "wait");

    $.ajax({
        url: Routing.generate("admin_user_agency_update"),
        type: "POST",
        data: {
            'idUser' : idUser,
            'idAgency' : idAgency,
            'type' : type
        },
        dataType: "json",
        success: function (result, status, xhr) {
            switch (xhr.status) {
                case 201:
                    //When the element is successfully added in db, add the line in JS (in the result) and add a message
                    //to inform the user and finally, remove the agency in the list (only in JS, the server side is not
                    //managed here.
                    addLineInTable($.parseJSON(result));
                    writeMessage("L'ajout a bien été effectué", "info");
                    $("#user_admin_edit_agencies").find("option:selected").remove();
                    break;
            }
        },
        error: function(result) {
            switch (result.status) {
                case 515:
                    //When there's an error during the add of the agency, show the error message.
                    writeMessageJson(result.responseText, "danger");
                    break;
                default:
                    writeMessage("Une erreur s'est produite lors de l'ajout", "danger");
            }
        },
        complete: function(xhr) {
            switch (xhr.status) {
                case 201:
                case 515:
                    //By default, whe have disabled the button in the adding case, we have to remove this class.
                    $("#add_agency").removeClass("disabled");
                    $(".ajax-loader").addClass("hidden");
                    break;
            }
            //The cursor is no longuer waiting
            $('body').css("cursor", "auto");

        }
    })
}

/**
 * This method is used to delete the messages that are showed to the user before showing a new one.
 */
function deleteDivDeletable() {
    $(".to-delete").each(function() {
        $(this).remove();
    });
}

/**
 * The JSON message need to be managed before showed.
 * @param message
 * @param type
 */
function writeMessageJson(message, type) {
    writeMessage(JSON.parse(message), type);
}

/**
 * This method is used to show a message to the users in any case, with the type they want
 * @param message
 * @param type "danger", "warning", "success", "info"
 */
function writeMessage(message, type) {
    deleteDivDeletable();
    $(".main-content").prepend("<div class='alert alert-"+type+" to-delete'>"+message+"</div>");
}

/**
 * This method use the template in the HTML page "templateAgency" to add the latest agency in the table.
 * @param object
 */
function addLineInTable(object) {
    var template = $("#templateAgency").html();
    template = "<tr id='__id__'>"+template+"</tr>";

    $(object).each(function(i,val){
        $.each(val,function(k,v){
            /* This part of the code transform the "true" of "principale" into a glyphicon */
            if (k == "principale" && v == true) {
                var iconToAdd= '<span class="glyphicon glyphicon-ok"></span>';
                template = template.replace("__" + k + "__", iconToAdd);
            }
            /* In the other cases, we have to replace the key sourrounded by "__" by the value. The keys can be
            * the code, the id, principale, ... The values of the Agency in fact */
            else {
                template = template.replace("__" + k + "__", v);
            }
        });
    });

    $("#userAgencyTable").find("tbody").append(template);
}