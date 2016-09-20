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
    updateAgency("remove", null, $("#id_user").val(), $(this).attr("data-value"));
    e.preventDefault();
});

/* Listener on the button to update the agency and set it as the principal in the user list */
$(document).on("click", ".set_principal_agency", function(e) {
    updateAgency("setPrincipal", null, $("#id_user").val(), $(this).attr("data-value"));
    e.preventDefault();
});


function updateAgency(type, idAgency, idUser, idUserAgency) {
    //Disable the buttons button to prevent multiple action during the AJAX call.
    $(".canBeDisabled").addClass("disabled");

    //The cursor is now "waiting" the Ajax callbacks
    $('body').addClass("wait");
    $(".ajax-loader").removeClass("hidden");

    //Remove the previous messages
    deleteDivDeletable();

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
        success: function (result) {
            //We have to empty the list of Agencies + refresh the table with the good values.

            //Parse the string into JSON
            var contentObjects = JSON.parse(result);
            emptyDropDownAndTableThenFillThemWithDatas(contentObjects);

            writeMessage("La modification a bien été effectuée", "info");

        },
        error: function(result) {
            switch (result.status) {
                case 515:
                case 516:
                    //When there's an error during the add/update/deletion of the agency, show the error message.
                    writeMessageJson(result.responseText, "danger");
                    break;
                default:
                    //If another error occurs
                    writeMessage("Une erreur s'est produite lors de l'opération", "danger");
            }
        },
        complete: function() {
            //The cursor is no longuer waiting
            $('body').removeClass("wait");
            $(".ajax-loader").addClass("hidden");

            //By default, whe have disabled the button in the adding case, we have to remove this class.
            $(".canBeDisabled").removeClass("disabled");
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
 * The JSON message need to be managed before shown.
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
 * This method use the template in the HTML page "templateAgency" to add an agency in the table.
 * @param object
 */
function addLineInTable(object) {
    var template = $("#templateAgency").html();
    template = "<tr>" + template + "</tr>";

    $(object).each(function (i, val) {
        $.each(val, function (key, value) {
            /* This part of the code transform the "true" of "principale" into a glyphicon */
            if (key == "principale") {
                var templatePrincipale = '<span class="glyphicon glyphicon-ok ';
                if (!value) {
                    templatePrincipale += "hidden";
                    template = template.replace(new RegExp("__isPrincipalHidden__", 'g'), "");
                }
                else {
                    template = template.replace(new RegExp("__isPrincipalHidden__", 'g'), "hidden");
                }
                templatePrincipale += '"></span>';
                template = template.replace("__" + key + "__", templatePrincipale);
            }
            /* In the other cases, we have to replace the key sourrounded by "__" by the value. The keys can be
             * the code, the id, principale, ... The values of the Agency in fact */
            else {
                //The regex is used because there's several occurence of certains key so they need to be all replaced.
                template = template.replace(new RegExp("__" + key + "__", 'g'), value);
            }
        });
    });

    $("#userAgencyTable").find("tbody").append(template);
}

function emptyDropDownAndTableThenFillThemWithDatas(datas) {
    //Empty the select/Option
    var selectOption = $("#user_admin_edit_agencies");
    selectOption.empty();

    //For each agency in the list, add it in the select/option
    for(var i = 0; i < datas.agencies.length; i++) {
        var agency = datas.agencies[i];

        var option = document.createElement('option');
        option.value = agency.idAgency;
        option.textContent = agency.codeAgency+" - "+agency.nameAgency;

        selectOption.append(option)
    }

    //Empty the table
    $("#userAgencyTable").find("tbody").find("tr[id!=templateAgency]").remove();

    //For each user_agency in the list, add it in the table
    for(i = 0; i < datas.user_agency.length; i++) {
        var user_agency = datas.user_agency[i];
        addLineInTable(user_agency);
    }
}