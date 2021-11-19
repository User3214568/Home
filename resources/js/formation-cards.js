$('document').ready(function(){
    $("button[name='card-formation']").on('click',function(){
        var formation = JSON.parse($(this).parent().find('textarea[name="sems"]').val())
        console.log(formation)
        $("#modal-dialog").addClass("modal-fullscreen")
        $("#modal-title-id").html("Informations sur la Formation "+formation.name+"<hr class='dropdown-divider'/>");
        $("#modal-title-id").addClass("text-primary")
        $("#modal-footer").addClass('border-white');
        $("#modal-id").empty()
        $("#modal-id").html(
            "<div class='container-fluid'>"+prepareContent(formation)+'</div>'
        );
        $("#close-popup").removeClass("bg-danger bg-success")
        $("#close-popup").addClass("bg-danger")
        $("#modal-trigger").click()
    })
    function prepareContent(formation){
        var content = '<div class="accordion  " id="accordionExample">';

        var sems = formation.semes

        sems.forEach(element => {
            content+='<div class="accordion-item mt-2 " ><h2 class="accordion-header " id="sem'+element.numero+'">'
            content+='<button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#exp'+element.numero+'" aria-expanded="false">Semestre '+element.numero+'</button></h2>'
            content+='<div id="exp'+element.numero+'" class="accordion-collapse collapse "  data-mdb-parent="#accordionExample"><div class="accordion-body">'
            if(element.modules.length > 0){
                content+="<div class='row text-center justify-content-center '>"
                element.modules.forEach(module=>{
                    content+="<table class='text-white border-light "+randomBackground()+" m-1 col-lg-3  rounded-0 shadow-5 table-bordered'>"
                    content+="<tr><th class='p-2'>Module</th><td  class='p-2'>"+module.name+"</td></tr>"
                    content+="<tr><th class='p-2'>Professeur</th><td class='p-2'>"+module.teacher+"</td></tr>"
                    content+="</table>"
                })
                content+="</div>"
            }else{
                content+="<div class='text-lead'>Cette semestre n'a aucun module.</div>"
            }
            content+=" </div></div></div>"
        });
        content+="</div>"
        return content
    }
    function randomBackground(){
        var i  = Math.random();
        if(i <=  0.2){
            return 'bg-danger'
        }
        if(i <= 0.4){
            return 'bg-warning'
        }
        if(i <= 0.55){
            return 'bg-primary'
        }
        if(i <= 0.7){
            return 'bg-secondary'
        }
        if(i <= 0.85){
            return 'bg-info'
        }
        return 'bg-dark'

    }
})
