
var devoirs = {
    length : 0,
    sum : function(){
        var keys = Object.keys(this);
        var s = 0;
        keys.forEach(e=>{
            if(/^[0-9]+$/.test(e)){
                s += Number(this[e].ratio)
            }
        });
        return s;
    }
};
function syncDevoirs(){
    $("#data").val(JSON.stringify(devoirs))
}
function showDevoirs(){
    for(var i = 0 ; i  <devs.length ;i++){

        var name = $("#devoirDiv").find("#name");
        name.val(devs[i].name);
        name.attr('name',devs[i].id);
        name.focus();
        var ratio = $("#devoirDiv").find("#ratio");
        ratio.val(devs[i].ratio);
        ratio.focus();

        $("#devoirDiv").find("#addModule").click();
    }


}
$(document).ready(function(){
    //Add module btn event
    $("#addModule").click(function(){
        var dv = $("#devoirDiv").clone();
        var input_name =dv.find("#name")
        var name = input_name.val();
        var ratio = dv.find("#ratio").val();
        if(!(name==="" || ratio==='')){
            if(/^[0-9]+(\.[0-9]+)?$/.test(ratio)){

                if((devoirs.sum()+Number(ratio) )>100){
                    popup('Données Invalides','La somme des proucentage des devoires a dépassé 100%','bg-danger','text-light');
                }
                else{

                    devoirs.length++;
                    dv.attr('id','#'+devoirs.length)
                    devoirs[devoirs.length] = {
                        name  : name,
                        ratio : ratio
                    }
                    if(input_name.attr('name') !== ""){
                        devoirs[devoirs.length].id = input_name.attr('name');
                    }
                    var btn = dv.find("#addModule");
                    btn.removeClass("btn-primary");
                    var edit= dv.find("#check")
                    edit.click(saveEdit);
                    edit.attr('id',devoirs.length);
                    edit.attr('hidden',false);
                    console.log(btn.attr('id'))
                    btn.addClass('btn-danger')
                    btn.find('i').removeClass();
                    btn.find('i').addClass('fas fa-times');
                    btn.click(removeModule);
                    $("#devoirs").prepend(dv);
                    $("#devoirDiv").find("#name").val('');
                    $("#devoirDiv").find("#name").attr("name",'');
                    $("#devoirDiv").find("#ratio").val('');
                }
            }
            else{
                popup('Données Invalides',
                "Le Pourcentage doit étre une une valeur numérique",
                "bg-danger",
                'text-light'
                )
            }
        }
        else{
            popup('Opération Interdite',
                "Le nom du devoir ou sa portion (pourcentage) dans la note du module est Vide!",
                "bg-danger",
                'text-light'
                )
        }
        syncDevoirs();
    });
    showDevoirs();
})
function saveEdit(e){
    if(devoirs.sum() - Number(devoirs[$(this).attr('id')].ratio) +Number($(this).parent().parent().find('#ratio').val())>100){
        popup('Données Invalides','La somme des proucentage des devoires a dépassé 100%','bg-danger','text-light');
    }else{
        devoirs[$(this).attr('id')].name = $(this).parent().parent().find('#name').val();
        devoirs[$(this).attr('id')].ratio = $(this).parent().parent().find('#ratio').val()
    }
    syncDevoirs();
}

function removeModule(event){
    delete devoirs[$(this).attr('id')];
    devoirs.length--;
    $(this).parent().parent().remove();
    syncDevoirs();
}
function popup(title,content,bg,color,icon='far fa-times-circle'){

    $("#modal-title-id").empty();
    $("#modal-header").addClass('border-white');
    $("#modal-header").addClass(bg+' d-flex flex-column text-white ');
    $("#modal-header").empty()
    $("#modal-header").append("<div class='d-flex justify-content-center align-items-center "+bg+"'><p><i class='"+icon+" fa-6x'></i></p></div>")
    $("#modal-footer").addClass('border-white');
    $("#modal-id").html(
        "<div class='mt-2 d-flex justify-content-center align-items-center'><p class='h4'>"+title+"</p=></div>"+
        "<div class='d-flex justify-content-center align-items-center'><p>"+content+"</p></div>"
    );
    $("#saveModules").remove();
    $("#close-popup").addClass(bg)
    $("#modal-trigger").click();
}
