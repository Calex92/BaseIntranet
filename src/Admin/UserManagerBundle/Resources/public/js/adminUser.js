/**
 * Created by acastelain on 05/09/2016.
 */

/* Listener on the button to add the agency in the user list*/
$(document).on("click", "#add_agency", function (e) {
    var user_admin_edit_agencies = $("#user_admin_edit_agencies").val();
    if (user_admin_edit_agencies != null) {
        updateAgency("add", user_admin_edit_agencies, $("#id_user").val(), null);
    }
    else {
        writeMessage("Aucune agence sélectionnée", "warning");
    }
    e.preventDefault();
});

/* Listener on the button to delete an agency in the user list */
$(document).on("click", ".remove_agency", function (e) {
    updateAgency("remove", null, null, $(this).attr("data-value"));
    e.preventDefault();
});


function updateAgency(type, idAgency, idUser, idUserAgency) {

    switch (type) {
        case "add":
            //Disable the "Add Agency" button whe it's an add type
            $("#add_agency").addClass("disabled");
            break;
    }
    //The cursor is now "waiting" the Ajax callbacks
    $('body').addClass("wait");

    $.ajax({
        url: Routing.generate("admin_user_agency_update"),
        type: "POST",
        data: {
            'idUser': idUser,
            'idAgency': idAgency,
            'idUserAgency': idUserAgency,
            'type': type
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
                case 202:
                    removeLineInTable($.parseJSON(result));
                    writeMessage("L'agence a bien été supprimée", "info");
            }
        },
        error: function(result) {
            switch (result.status) {
                case 515:
                    //When there's an error during the add of the agency, show the error message.
                    writeMessageJson(result.responseText, "danger");
                    break;
                case 516:
                    writeMessageJson(result.responseText, "danger");
                    break;
                default:
                    writeMessage("Une erreur s'est produite lors de l'opération", "danger");
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
            $('body').removeClass("wait");

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
    $(".main-content").prepend("<div class='alert alert-" + type + " to-delete'>" + message + "</div>");
}

/**
 * This method use the template in the HTML page "templateAgency" to add the latest agency in the table.
 * @param object
 */
function addLineInTable(object) {
    var template = $("#templateAgency").html();
    template = "<tr id='__id__'>" + template + "</tr>";

    $(object).each(function (i, val) {
        $.each(val, function (key, value) {
            /* This part of the code transform the "true" of "principale" into a glyphicon */
            if (key == "principale" && value == true) {
                var iconToAdd = '<span class="glyphicon glyphicon-ok"></span>';
                template = template.replace("__" + key + "__", iconToAdd);
            }
            /* In the other cases, we have to replace the key sourrounded by "__" by the value. The keys can be
             * the code, the id, principale, ... The values of the Agency in fact */
            else {
                template = template.replace("__" + key + "__", value);
            }
        });
    });

    $("#userAgencyTable").find("tbody").append(template);
}

function removeLineInTable(object) {
    var template = $("#templateAgencyInfo").val();
    $(object).each(function (i, val) {
        $.each(val, function (key, value) {
            //First, remove the line in the table
            if (key == "idAgency") {
                $("#agency" + value).closest("tr").remove();
            }
            //Then replace the values in the template
            template = template.replace("__" + key + "__", value)
        });
    });

    //Then add the template in the select/option
    $("#user_admin_edit_agencies").append(template);
}