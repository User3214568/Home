

$(document).ready(function(){
    $("#formation-select").on('change',function(){
        id = $(this).val()
        var target = $(this).attr('target');
        var empty = $("#etudiants-notes").text();
        $("#empty-notes").remove();
        $("#etudiants-notes").addClass('border mt-5');
        $("#etudiants-notes").html('<div class="d-flex justify-content-center align-items-center m-5 p-5 flex-column "><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div><div class="ms-4">Chargement du Contenue depuis le serveur ...</div></div>')
        token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : '/admin/formation/notes',
            method : "POST",
            data : {
                id : id,
                target : target,
                _token : token
            },
            success : function(response){
                $("#etudiants-notes").removeClass('border mt-5');
                $("#etudiants-notes").empty();
                $("#etudiants-notes").append(response);
                setupsave();

            },
            error : function(error){
                console.log(error)
                $("#etudiants-notes").empty();
                $("#etudiants-note").html('<div class="d-flex justify-content-center align-items-center m-5 p-5 flex-column "><div class="text-danger"><i class="fas fa-times-circle fa-6x"></i></div><div class="p-4">Une Erreur a été survenu : '+error.message+'</div></div>');
            }
        }
        );
    });
});
function setupsave(){
    evaluation = {};
    $("button").each(function(){
        $(this).click(function(){
            if($(this).attr('name')=="savenote"){
                var fails = [];
                $(this).parent().parent().parent().find(".table-responsive").find("td[name='note']").each(function(e){

                    var id = $(this).attr('id');
                    var value =  Number($(this).text().trim());
                    if(/^[0-9]+(\.[0-9]+)?$/.test(value) && (value<=20 && value >=0)){

                        evaluation[id] = {
                            note : value
                        }
                    }
                    else{
                        fails.push('Valeur Invalide : '+id);
                    }
                });

                if(fails.length == 0){
                    editNote(evaluation)
                }else alert('Donnée Invalides');
            }
        });
    });
}
function editNote(evaluation){
    alert('save')
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url : '/admin/etudiant/update-note',
        method : 'POST',
        data : {
            evaluations : JSON.stringify(evaluation),
            _token : token
        },
        success : function(response){
            console.log(response)
            if(!response.message){
                alert('Enregistrement Terminé');
            }
        },
        error : function(response){
            alert('Enregistrement Echoué');
        }
    });
}
