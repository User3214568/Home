
$("document").ready(function(){
    $("#btn-upload").click(function(){
        $("#upload-id").click();
    })
    $("#upload-id").on("change",refrechFileList);

    $("#checkAll").on('change',function(){
        $(".etudiant-check").prop('checked',$(this).is(':checked'));
    });
    $("#import-valider").click(function(){
        $("#etudiants-table tr").each(function(){
            var data = null;
            $(this).children().each(function(){
                if($(this).attr('name') != undefined){
                    if($(this).attr('name') == 'selected'){
                        if($(this).children().find('input').prop('checked')){
                            data = {};
                        }
                    }
                    else{
                        if(data != null) {
                            if($(this).attr('name') == 'formation_name') {
                                data['formation_id'] = $(this).attr('formation');
                            }
                            else {
                                data[$(this).attr('name')] = $(this).text();
                            }
                        }
                    }
                }
            });
            if(data != null){
                data.ajax = true;
                let _token   = $('meta[name="csrf-token"]').attr('content');
                data._token = _token;
                $.ajax({
                    method : 'POST',
                    url : ('/admin/etudiant'),
                    data : data,
                    success : function (e){

                    },
                    error : function(e){
                        console.log(e);
                    }
                })
            }
        })
    });

});
function refrechFileList(){
        $("#selected-files").empty();
        var e = document.getElementById('upload-id')
        if((e.files).length > 0 ){
            $("#submit-files").attr('hidden',false);
            $("#empty-files").empty();
            for(var index = 0 ; index < (e.files).length ; index++){
                var element = (e.files)[index];
                $('#selected-files').append(makeCard(index,element.name,(element.size/1024).toFixed(2)));
            }

        }
        else{
            $("#submit-files").attr('hidden',true);
            $("#empty-files").append('Aucun fichier Excel n\'est selecionnée')
        }
}
function dropFile(e){
    var input = document.getElementById('upload-id').files
    var array = Array.from(input)

    array.splice(e.getAttribute('file-index'),1)
    document.getElementById('upload-id').files = new FileListItems(array);

    refrechFileList(input);

}
function FileListItems (files) {
    var b = new ClipboardEvent("").clipboardData || new DataTransfer()
    for (var i = 0, len = files.length; i<len; i++) b.items.add(files[i])
    return b.files
  }
function makeCard(index,name,size){
    var card = $('#card-file').clone();
    card.find('#filename').empty()
    card.find('#filename').append(name);
    card.find('#filesize').empty()
    card.find('#filesize').append(size+" KB");
    card.find("#file-delete").attr('file-index',index);

    card.attr('hidden',false);
    return card;
}


