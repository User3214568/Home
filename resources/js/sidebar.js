
$(document).ready(function(){

    $("#sidebarHideToggler").click(function(){
        $("#side").attr('hidden',function(index,value){
            return !value;
        })
    })
    $("#sidebartoggler").click();
    $("#sidebartoggler").click(function(){
        $("#admin-content").toggleClass("col-md-11 col-md-9 ")
        $("span[name='side-item-label']").attr('hidden',function(index,attr){
            return !attr;
        })
        $("i[name='side-item-label']").attr('hidden',function(index,attr){
            return !attr;
        })
        $("img[name='side-item-label']").attr('hidden',function(index,attr){
            return !attr;
        })
        $("#sidebartoggler").toggleClass('align-items-center')
        $("#mysidebar a").toggleClass("text-center")
        $('i[name="icon-sidebar"]').toggleClass("fa-1x")
        $("#mysidebar").toggleClass("col-md-1 col-md-3 ")
    })


});

