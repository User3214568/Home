

$(document).ready(function(){
    $("#formation-select").on('change',function(){
        id = $(this).val()
        token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : '/admin/formation/notes',
            method : "POST",
            data : {
                id : id,
                _token : token
            },
            success : function(response){
                $("#etudiants-notes").empty();
                $("#etudiants-notes").append(response);
                $("#empty-notes").remove();
                setupsave();
            },
            error : function(error){
                console.log(error)
            }
        }
        );
    });
});
function setupsave(){
    evaluation = {};
    $("#savenote").click(function(){
        var fails = [];
        $("td[name='note']").each(function(e){

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
    });
}
function editNote(evaluation){
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
