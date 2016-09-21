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
            var message = "";
            var title = "";
            switch (type) {
                case "add":
                    title = "L'ajout a bien été effectué.";
                    message = "L'agence a bien été affectée à cet utilisateur.";
                    break;
                case "remove":
                    title = "La suppression a bien été effectuée.";
                    message = "L'agence a bien été retirée de la liste de cet utilisateur.";
                    break;
                case "setPrincipal":
                    title = "Modification effectuée";
                    message = "L'agence est bien définie comme étant l'agence principale de l'utilisateur.";
                    break;
                default:
                    title = "La modification a été effectuée.";
                    message = "Le cas n'est pas correctement géré en Javascript, veuillez contacter le Help avec ce message.";
            }
            writeMessage(title, message, "success", "glyphicon glyphicon-ok");

        },
        error: function(result) {
            var message = "";
            var title = "";
            switch (result.status) {
                case 515:
                case 516:
                    //When there's an error during the add/update/deletion of the agency, show the error message.
                    title = "Mise à jour impossible.";
                    message = JSON.parse(result.responseText);
                    break;
                default:
                    //If another error occurs
                    title = "Erreur.";
                    message = "Une erreur s'est produite lors de l'opération";
            }
            writeMessage(title, message, "danger", "glyphicon glyphicon-remove");
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
 * This method is used to show a message to the users in any case, with the type they want
 * @param title Le titre de la notification
 * @param message Le corps de la notification
 * @param type "danger", "warning", "success", "info"
 * @param icon You can add icon if you not, but it's not necessary, you can let "undefined"
 */
function writeMessage(title, message, type, icon) {
    notify(title, message, type , icon);
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