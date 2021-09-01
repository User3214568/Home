$(document).ready(function(){
    alert('ready')
    $("button[name='importModule']").each(function(e){
        $(this).click(function(e){
            $(this).parent().find('input[name="file"]').click();
        });
    })
    $("input[name='file'").on('change',function(){
            console.log('submited');
            $(this).parent().find("#submit").click();
    })

});


