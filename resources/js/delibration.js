$(document).ready(function(){
    $("#formation").on('change',function(){
        var token = $('meta[name="csrf-token"]').attr('content');
        $("#delib-info").html('<div class="p-5 row justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>')
        $.ajax({
            method: "get",
            url: "/admin/formation/delibration/"+$(this).val(),
            data: {
                _token : token
            },
            success: function (response) {

                $("#delib-info").html((response))
                synResult();
            },
            error : function(ee){
                console.log(ee)
            }
        });
    });


});
function synResult(){
    synInput();
    $("#syn-submit").click(function(){
        synInput();
        $("#submit-result").click();
    })
}
function synInput(){
    var results = {};
    $("select[name='select-decision']").each((key,select)=>{
        if(!results[$(select).attr('id')]){
            results[$(select).attr('id')] = [];
        }
        results[$(select).attr('id')].push({
            e  : $(select).attr("e"),
            r  : $(select).val()
        })

    })
    $("#results-obj").val(JSON.stringify(results))
}
/*

*/
