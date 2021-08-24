// Material Select Initialization
var semestres = {};
var edit = false;
function syncHiddenInput(){
    $("#semestres-data").val(JSON.stringify(semestres));
}


function editSemestre(e){
    $('#search-result input:checkbox').each(function() {
        semestres[e.name] = semestres[e.name].map(function(item){
            return Number(item)
        })
        if(semestres[e.name].includes(Number($(this).attr('id')))) {
            console.log($(this))
            $(this).prop("checked",true)
            console.log($(this).prop("checked"))
        }
        console.log(semestres[e.name] ,'****',Number($(this).attr('id')), semestres[e.name].includes(Number($(this).attr('id'))))
    });
    edit = true;
}
function deleteSemestre(e){
    var s_number = Object.keys(semestres).length;
    if(e.name == s_number){
        console.log(true)
        $('#sem'+e.name).remove();
        delete semestres[e.name];
        if(s_number-1 ==0) $("#semestre-empty").text('Aucune semestre n\'est selectionnée pour le moment')
        syncHiddenInput();
    }
}

$(document).ready(function(){

    $("#etudiants-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        setTimeout(function(){
            $("#etudiants-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        },50);
    });
    $("#etudiant-formation").on("change",function(){
        var value = $(this).val();
        $("#etudiants-table tr").filter(function() {
            $(this).toggle($(this).text().indexOf(value) > -1)
        });
    });

    $("#search-module").focus(function(){
        $("#search-result").slideDown('slow');
    });
    $("#add-formation-btn").click(function(){
        $("#modal-title-id").text("Modification de La Semestre")
    })
    $("#saveModules").click(function(){
        var selected = [];
        var clonedSem = $(".semestre").clone();
        console.log(clonedSem)
        $("#semestre-empty").empty();
        if(edit) $("#sem"+($(".semestre").length)).remove();
        var sem = $("<div>");
        $("#selected").append(sem)
        var innerHTML = "<div class='card w-100 mt-2 semestre' id='sem"+($(".semestre").length + 1 )+"'><div class='card-body'> <h5 class='card-title'>Semestre "+($(".semestre").length + 1)+"</h5><hr class='dropdown-divider'><div class='card-text'> Liste des Modules selecionnées"
        innerHTML+="<div>"
        $('#search-result input:checked').each(function() {
            selected.push($(this).attr('id'));
            innerHTML += "<span class='p-2'>"+$(this).attr('value')+"<span>";
           $(this).prop("checked",false)
        });
        if(selected.length>0){

            $("#modules").addClass("flex-column")
            innerHTML +='</div><hr class="dropdown-divider"></div><button type="button" class="btn btn-success btn-floating ms-1 mt-2 " data-toggle="modal" data-target="#popup" onclick="editSemestre(this)" name='+($(".semestre").length + 1)+'><i class="fas fa-marker"></i></button><button type="button" class="btn btn-danger btn-floating ms-1 mt-2 " onclick="deleteSemestre(this)" name='+($(".semestre").length + 1)+'><i class="fas fa-trash-alt"></i></button></div></div>'
            $("#selected").append(innerHTML)
            semestres[($(".semestre").length )] = selected;
            $("#semestre-numero").val('')
        }
        else{
            $("#modules").addClass("flex-row")
        }
        syncHiddenInput();
        console.log('checked : ',selected)
        edit  = false;
    });
})

function cancel(){
    $('#search-result input:checkbox').each(function() {
        console.log('here')
        $(this).attr('checked', false);
    });
}

window.onload = function (){

    document.querySelectorAll('.form-outline').forEach((formOutline) => {
        new mdb.Input(formOutline).init();
    });
    // Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach((form) => {
      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();
}

var selection  = [];
function addSelection(){
    document.getElementById('select-module');
}
