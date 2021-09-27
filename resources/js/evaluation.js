$(document).ready(function(){
    //Session change
    $("li[name='triggers-session']").click(function(event){
        setTimeout(() => {
            var tab = ($(this).parent().parent().find("div.active[name='notes'] "))
            var container = (tab.find("div.table-responsive"))
            ajaxRequest(tab.attr('result'),tab.attr('promotion'),tab.attr('semestre'),"all",tab.attr('session'),container)
            container.html(spinner())
        }, 400);
     })
     $("li[name='triggers-session-module']").click(function(event){
        setTimeout(() => {
            var tab = ($(this).parent().parent().find("div.active[name='notes-module'] "))
            var container = (tab.find("div.table-responsive"))
            ajaxRequest(tab.attr('result'),tab.attr('promotion'),tab.attr('semestre'),tab.attr('module'),tab.attr('session'),container)
            container.html(spinner())
        }, 400);
     })
     //Module change
    $("li[name='triggers']").click(function(event){
        setTimeout(() => {
            var root = ($(this).parent().next().find("div"+$(this).find("a").attr('href')))
            var tab  = root.find("li[name='triggers-session-module']")
            $.each(tab,function(key,e){
                if($(e).find("a.active").length != 0){
                    $(e).click();
                    return 0;
                }
            })

            tab  = root.find("li[name='triggers-session']")
            $.each(tab,function(key,e){
                if($(e).find("a.active").length != 0){
                    $(e).click();
                    return 0;
                }
            })
        }, 400);
    })
    $("li[name='triggers-semestre']").click(function(){
        setTimeout(() => {
            var root = ($(this).parent().next().find("div"+$(this).find("a").attr('href')))
            var tab  = root.find("li[name='triggers']")
            $.each(tab,function(key,e){
                if($(e).find("a.active").length != 0){
                    $(e).click();
                    return 0;
                }
            })
        }, 200);
    })
    $("li[name='triggers-promo']").click(function(){
        setTimeout(() => {
            var root = ($(this).parent().next().find("div"+$(this).find("a").attr('href')))
            var tab  = root.find("li[name='triggers-semestre']")
            $.each(tab,function(key,e){
                if($(e).find("a.active").length != 0){
                    $(e).click();
                    return 0;
                }
            })
        }, 400);
    })

})

function ajaxRequest(result,promotion,semestre,module,session,element){
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url  : "/admin/etudiant/request-notes/"+result+"-"+promotion+"-"+semestre+"-"+module+"-"+session,
        method : 'GET',
        data : {
            _token : token
        },
        success : function(response){

            element.html(response)

        },
        error : function(error){
            element.html("Error Loading FAILED")
            console.log(error)
        }
    });
}
function spinner(){
    return '<div class="row justify-content-center align-items-center mt-5"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div></div>'
}
