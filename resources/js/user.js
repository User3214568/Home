$(document).ready(function(){
    $("#image_button").click(function(){
        $("#image_input").click();
    });
});
function readImage(e){
    if(e.files[0]){
        var reader  = new FileReader();
        reader.onloadend = function(e){
            $("#image").attr('src',e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}
