
$(document).ready(function () {
    setTimeout(init, 200);
    $("#add-semestre").click(function () {
        var newSem = $("#sem-template").clone();
        semestres[semestres.last] = []
        newSem.attr('id', 'sem' + semestres.last)
        //Buttons update delete
        newSem.find("#add-semestre").remove()
        var editButton = newSem.find("#edit-semestre")
        editButton.attr('hidden', false);
        editButton.attr('target', newSem.attr('id'))
        var editButton = newSem.find("#delete-semestre")
        editButton.attr('hidden', false);
        editButton.attr('target', newSem.attr('id'))
        //title
        newSem.find("#title").text("Semestre" + semestres.last)
        //sync semestres variable
        newSem.find("input:checkbox ").each(function (index, item) {
            var oldId = $(item).attr('id')
            $(item).attr('id', oldId + "-" + newSem.attr('id'))
            newSem.find('label[for="' + oldId + '"]').attr('for', $(item).attr('id'))
            if ($(item).prop('checked')) {
                semestres[semestres.last].push($(item).val())
            }
        })
        semestres.last = semestres.last + 1
        $("#semestres").append(newSem);

        //Clear Checked from template
        $("#sem-template").find("input:checkbox").each(function (index, item) {
            if ($(item).prop('checked')) {
                $(item).prop('checked', false)
            }
        })
    })
})
function updateSemestre(element) {
    var sem = $("#" + $(element).attr('target'))
    semestres[($(element).attr('target')).substring(3)] = []
    sem.find("input:checkbox ").each(function (index, item) {
        if ($(item).prop('checked')) {
            semestres[($(element).attr('target')).substring(3)].push($(item).val())
        }
    })
    syncsemestres()
}
function deleteSemestre(element) {
    var index = ($(element).attr('target')).substring(3)
    if(semestres.last - 1 == index){
        delete semestres[index]
        $("#"+($(element).attr('target'))).slideUp(100,function(){
            $("#"+($(element).attr('target'))).remove();
        })
        semestres.last--
        syncsemestres()
    }
}
function syncsemestres(){
    var keys = Object.keys(semestres)
    var results = {}
    keys.forEach(function(key){
        if(key !== 'last'){
            results[key] = semestres[key]
        }
    })
    $("#semestres-data").val(JSON.stringify(results))
}
function init(){
    var keys = Object.keys(semestres)
    keys.forEach(function(key){
        if(key !== 'last'){
            var sem = $("#sem-template")
            sem.find('input:checkbox').each(function(index,item){
                if(semestres[key].includes($(item).val())){
                    $(item).prop('checked',true)
                }
            })
            $("#add-semestre").click()
        }
    })
}
