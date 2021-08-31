// Material Select Initialization
var semestres = {};
var target = 0 ;
var edit = false;
function syncHiddenInput(){
    $("#semestres-data").val(JSON.stringify(semestres));
}

function editSemestre(e){
    target = e.name;
    $('#search-result input:checkbox').each(function() {
        console.log(semestres[e.name])
        semestres[e.name] = semestres[e.name].map(function(item){
            return Number(item)
        })
        if(semestres[e.name].includes(Number($(this).attr('id')))) {
            $(this).prop("checked",true)
        }
    });
    edit = true;
}
function deleteSemestre(e){
    var s_number = Object.keys(semestres).length;
    if(e.name == s_number){
        $('#sem'+e.name).remove();
        delete semestres[e.name];
        if(s_number-1 ==0) {
            $("#semestre-empty").attr('hidden',false);
        }
        syncHiddenInput();
    }
}

$(document).ready(function(){
    syncHiddenInput();
    $("#popup").on('hide.bs.modal', function(){
        edit  = false;
        $('#search-result input:checked').each(function() {
            $(this).prop('checked',false);
        })
      });
    $("#test-login").click(function(){
        $("#email").val('hamza@gmail.com');
        $("#email").focus();
        $("#pass").val('hashed');
        $("#pass").focus();
    })
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
    $("#saveModules").click(function(e){
        var selected = [];
        if(!edit){
            var innerHTML = "<div class='row card mt-2 semestre' id='sem"+($(".semestre").length + 1 )+"'><div class='card-body'> <h5 class='card-title'>Semestre "+($(".semestre").length + 1)+"</h5><hr class='dropdown-divider'><div class='card-text'>"
            innerHTML+="<div id='spans'>"
            spans = "";
            $('#search-result input:checked').each(function() {
                selected.push($(this).attr('id'));
                spans += "<span class='p-2'>"+$(this).attr('value')+"<span>";
                $(this).prop("checked",false)
            });
            innerHTML +=spans;

            if(selected.length>0){
                {
                    $("#semestre-empty").attr('hidden',true);
                    $("#modules").addClass("flex-column")
                    innerHTML +='</div><hr class="dropdown-divider"></div><button type="button" class="btn btn-success btn-floating ms-1 mt-2 " data-toggle="modal" data-target="#popup" onclick="editSemestre(this)" name='+($(".semestre").length + 1)+'><i class="fas fa-marker"></i></button><button type="button" class="btn btn-danger btn-floating ms-1 mt-2 " onclick="deleteSemestre(this)" name='+($(".semestre").length + 1)+'><i class="fas fa-trash-alt"></i></button></div></div>'
                    $("#selected").append(innerHTML)
                    semestres[($(".semestre").length )] = selected;
                }
            }
            else{
                $("#modules").addClass("flex-row")
            }
        }
        else{

            var s = $("#sem"+target)
            var spans = "";
            var selected = [];
            $('#search-result input:checked').each(function() {

                selected.push($(this).attr('id'));
                spans += "<span class='p-2'>"+$(this).attr('value')+"<span>";
                $(this).prop("checked",false)
            });
            semestres[target] = selected;
            s.find("#spans").html(spans)
        }
            syncHiddenInput();
            edit  = false;
        });
    })

function cancel(){
    console.log('canceled');
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
