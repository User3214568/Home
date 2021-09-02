$(document).ready(function(){
    $("#input_formation").on('change',function(){
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : '/admin/formation/modules/'+$(this).val(),
            method : 'GET',
            data : {
                _token : token
            },
            success : function(response){
                var selec = $("#input_module");
                options = JSON.parse(response);
                selec.empty();
                options.forEach(element => {
                    selec.append("<option value='"+element.id+"' >"+element.name+"</option>");
                });
            },
            error : function(err){
                console.log(err)
            }
        });
    });
});
