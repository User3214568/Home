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
            },
            error : function(error){
                console.log(error)
            }
        }
        );
    })
});
