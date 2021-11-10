$(document).ready(function(){
    $("#importVersement").click(function(){
        $("#fileInput").click();
    })
    $("#fileInput").on('change',function(){
        $("#submit-import").click();
    });
})
