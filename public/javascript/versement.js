$(document).ready(function(){
    $("#importVersement").click(function(){
        $("#fileInput").click();
    })
    $("#fileInput").on('change',function(){
        $("#submit-import").click();
    });
    $("#formation-select").on('change',function(){
        $("#exportEmpty").attr('href','/admin/finance/export/'+$(this).val()+'-true');
        $("#export").attr('href','/admin/finance/export/'+$(this).val()+'-false');
        var value = $(this).find("option:selected").text().toLowerCase();
        if($(this).val() == 0) {
            value = "";
            $("#importVersement").attr('hidden',true);
            $("#exportEmpty").attr('hidden',true);
        }
        else{
            $("#importVersement").attr('hidden',false);
            $("#exportEmpty").attr('hidden',false);
        }
        filterTable(value);

    });
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        filterTable(value);
    });
    $("#exportEmpty").attr('href','/admin/finance/export/'+$("#formation-select").val()+'-true');
    $("#export").attr('href','/admin/finance/export/'+$("#formation-select").val()+'-false');
});

function filterTable(value){
    $("#conten-table tr[name='versement']").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
}
