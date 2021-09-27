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
                        var name = "";

                        options.forEach(element => {
                            if(element.name === undefined){
                                if(element.user.first_name === undefined ) return
                                name  = element.user.first_name +" "+ element.user.last_name
                            }
                            else{
                                name = element.name
                            }
                            selec.append("<option value='"+element.id+"' >"+name+"</option>");
                        });
                    },
                    error : function(err){
                        console.log(err)
                    }
                });
            });


        });

    }
}
