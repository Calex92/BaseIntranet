/**
 * Created by acastelain on 05/09/2016.
 */
$("#add_agency").on("click", function() {
    var user_admin_edit_agencies = $("#user_admin_edit_agencies").val();
    if (user_admin_edit_agencies != null)
    {
        updateAgency("add", user_admin_edit_agencies, $("#user_admin_edit_id").val());
    }
    else {
        writeMessage("Aucune agence sélectionnée", "warning");
    }
});

function updateAgency(type, idAgency, idUser) {
    //Disable the "Add Agency" button
    //$("#add_agency").attr("disabled", "disabled");

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
                    addLineInTable($.parseJSON(result));
                    writeMessage("L'ajout a bien été effectué", "info");
                    break;
            }
        },
        error: function(result) {
            switch (result.status) {
                case 515:
                    writeMessageJson(result.responseText, "danger");
                    break;
                default:
                    writeMessage("Une erreur s'est produite lors de l'ajout", "danger");
            }
        },
        complete: function(response, error, error2) {
            //$("add_agency").removeAttr("disabled");
        }
    })
}

function deleteDivDeletable() {
    $(".to-delete").each(function() {
        $(this).remove();
    });
}

function writeMessageJson(message, type) {
    writeMessage(JSON.parse(message), type);
}

function writeMessage(message, type) {
    deleteDivDeletable();
    $(".main-content").prepend("<div class='alert alert-"+type+" to-delete'>"+message+"</div>");
}

function addLineInTable(object) {
    var template = $("#templateAgency").html();
    template = "<tr id='__id__'>"+template+"</tr>";

    $(object).each(function(i,val){
        $.each(val,function(k,v){
            template = template.replace("__"+k+"__", v);
        });
    });

    $("#userAgencyTable").find("tbody").append(template);
}