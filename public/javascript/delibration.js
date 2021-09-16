$(document).ready(function(){
    $("#formation").on('change',function(){
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            method: "get",
            url: "/admin/formation/delibration/"+$(this).val(),
            data: {
                _token : token
            },
            success: function (response) {

                $("#target").html((response))
            },
            error : function(ee){
                console.log(ee)
            }
        });
    });
});
