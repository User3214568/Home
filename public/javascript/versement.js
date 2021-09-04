export default class ListGesionnaire {
    constructor(routeExport,up=0){
        $(document).ready(function(){
            $("#importVersement").click(function(){
                $("#fileInput").click();
            })
            $("#fileInput").on('change',function(){
                $("#submit-import").click();
            });
            $("#formation-select").on('change',function(){
                if(up == 1){
                    $("#importForm").attr('action','/admin/professeur/import/'+$(this).val());
                }
                $("#exportEmpty").attr('href',routeExport+$(this).val()+'-true');
                $("#export").attr('href',routeExport+$(this).val()+'-false');
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
            $("#exportEmpty").attr('href',routeExport+$("#formation-select").val()+'-true');
            $("#export").attr('href',routeExport+$("#formation-select").val()+'-false');
        });
        function filterTable(value){
            $("#conten-table tr[name='versement']").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        }

    }
}

