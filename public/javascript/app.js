


$(document).ready(function(){


    $("#test-login").click(function(){
        $("#email").val('hamza@gmail.com');
        $("#email").focus();
        $("#pass").val('hashed');
        $("#pass").focus();
    })
    $("#etudiants-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        setTimeout(function(){
            $("#etudiants-table tr[name='filter']").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        },50);
    });
    $("#etudiant-formation").on("change",function(){
        var value = $(this).val();
        $("#etudiants-table ").filter(function() {
            $(this).toggle($(this).text().indexOf(value) > -1)
        });
    });
    $("#au-formation").on('change',function(){
        var value = $(this).val();
        $("#etudiants-table ").filter(function() {
            $(this).toggle($(this).text().indexOf(value) > -1)
        });
    })
    $("#search-module").focus(function(){
        $("#search-result").slideDown('slow');
    });


    })



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



$(window).scroll(function(){
    if($(window).scrollTop() == 0){
        $("#navbar").removeClass('bg-light shadow-5')
        $("#navbar").addClass('transparent')
    }else{
        $("#navbar").removeClass('transparent')
        $("#navbar").addClass('bg-light shadow-5')
    }
})

