export default class Fetch{
    constructor(route){
        $(document).ready(function(){
            $("#input_formation_id").on('change',function(){
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url : route +$(this).val(),
                    method : 'GET',
                    data : {
                        _token : token
                    },
                    success : function(response){
                        var selec = $("#input_module_id");
                        var options = JSON.parse(response);
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

            if($("#input_formation_id").val() != null){

                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url : '/admin/formation/modules/' +$("#input_formation_id").val(),
                    method : 'GET',
                    data : {
                        _token : token
                    },
                    success : function(response){
                        var selec = $("#input_module_id");
                        var options = JSON.parse(response);
                        selec.empty();
                        options.forEach(element => {
                            if(element.id != selec.val())
                            selec.append("<option value='"+element.id+"' >"+element.name+"</option>");
                        });
                    },
                    error : function(err){
                        console.log(err)
                    }
                });
            }
        });

    }
}
