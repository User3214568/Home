import popup from "./popup.js";
var devoirs = {
    toDelete : [],
    length: 0,
    sum: function () {
        var keys = Object.keys(this);
        var s = {
            ord: 0,
            rat: 0,
        };
        keys.forEach(e => {

            if (/^[0-9]+$/.test(e)) {

                if (this[e].session == 1) {
                    s.ord += Number(this[e].ratio)
                    console.log(s.ord)
                } else {
                    s.rat += Number(this[e].ratio)
                }
            }
        });

        return s;
    }

};
function syncDevoirs() {
    $("#data").val(JSON.stringify(devoirs))
}
function showDevoirs() {

    if (typeof devs == "undefined") {

    }
    else {
        for (var i = 0; i < devs.length; i++) {
            var tar = '';
            if(devs[i].session == 2){
                tar = '1';
            }
            var name = $("#devoirDiv"+tar).find("#name");
            name.val(devs[i].name);
            name.attr('name', devs[i].id);
            name.focus();
            var ratio = $("#devoirDiv" +tar).find("#ratio");
            ratio.val(devs[i].ratio);
            ratio.focus();

            $("#devoirDiv" + tar).find("#addModule" +tar).click();
        }
    }



}
$(document).ready(function () {
    //Add module btn event

    $("#addModule").click({ param1: '' }, handle);
    $("#addModule1").click({ param1: 1 }, handle);
    showDevoirs();
})
function handle(event) {

    var dv = $("#devoirDiv" + event.data.param1).clone();
    var input_name = dv.find("#name")
    var name = input_name.val();
    var ratio = dv.find("#ratio").val();

    if (!(name === "" || ratio === '')) {
        if (/^[0-9]+(\.[0-9]+)?$/.test(ratio)) {

            if ((Number(event.data.param1=='1'?devoirs.sum().rat:devoirs.sum().ord) + Number(ratio)) > 100) {
                popup('Données Invalides', 'La somme des proucentage des devoires a dépassé 100%', 'bg-danger');
            }
            else {
                devoirs.length++;
                dv.attr('id', '#' + devoirs.length)
                devoirs[devoirs.length] = {
                    name: name,
                    ratio: ratio,
                    session: event.data.param1 == 1 ? 2 : 1
                }
                if (input_name.attr('name') !== "") {
                    devoirs[devoirs.length].id = input_name.attr('name');
                }
                var btn = dv.find("#addModule" + event.data.param1);
                btn.removeClass("btn-primary");
                var edit = dv.find("#check" + event.data.param1)
                edit.click(saveEdit);
                edit.attr('name',Number(event.data.param1)+1);

                edit.attr('id', devoirs.length);
                edit.attr('hidden', false);
                btn.addClass('btn-danger')
                btn.attr('id',devoirs.length);
                btn.find('i').removeClass();
                btn.find('i').addClass('fas fa-times');
                btn.click(removeModule);
                $("#devoirs" + event.data.param1).prepend(dv);
                $("#devoirDiv" + event.data.param1).find("#name").val('');
                $("#devoirDiv" + event.data.param1).find("#name").attr("name", '');
                $("#devoirDiv" + event.data.param1).find("#ratio").val('');
            }
        }
        else {
            popup('Données Invalides',
                "Le Pourcentage doit étre une une valeur numérique",
                "bg-danger",

            )
        }
    }
    else {
        popup('Opération Interdite',
            "Le nom du devoir ou sa portion (pourcentage) dans la note du module est Vide!",
            "bg-danger",

        )
    }
    syncDevoirs();
}
function saveEdit(e) {
    var calculated = 0;
    if ($(this).attr('name') == '1') {
        calculated = devoirs.sum().ord;
    }
    else {
        calculated = devoirs.sum().rat;
    }

    if (calculated - Number(devoirs[$(this).attr('id')].ratio) + Number($(this).parent().parent().find('#ratio').val()) > 100) {
        popup('Données Invalides', 'La somme des proucentage des devoires a dépassé 100%', 'bg-danger');
        $(this).parent().parent().find('#ratio').val(devoirs[$(this).attr('id')].ratio)
    } else {
        devoirs[$(this).attr('id')].name = $(this).parent().parent().find('#name').val();
        devoirs[$(this).attr('id')].ratio = $(this).parent().parent().find('#ratio').val();
    }
    syncDevoirs();
}

function removeModule(event) {
    if(devoirs[$(this).attr('id')].id){
        devoirs.toDelete.push(devoirs[$(this).attr('id')].id)
    }
    delete devoirs[$(this).attr('id')];
    devoirs.length--;
    $(this).parent().parent().remove();
    syncDevoirs();
}

