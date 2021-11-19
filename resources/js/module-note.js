$(document).ready(function(){

    $("button[name='importModule']").each(function(e){
        $(this).click(function(e){
            $(this).parent().find('input[name="file"]').click();
        });
    })
    $("input[name='file'").on('change',function(){

            $(this).parent().find("#submit").click();
    })

});


