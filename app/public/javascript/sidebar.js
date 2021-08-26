var sideSlim = {
    width : -1,
    isToggled : false
}
$(document).ready(function(){
    sideSlim.width =  $("#mysidebar").width();

    $("#sidebartoggler").click(function(){
        $("span").each(function(){
            if($(this).attr('name') == 'side-item-label'){
                $(this).attr('hidden',sideSlim.isToggled);
            }
        })
        $("#mysidebar").animate({
            width : sideSlim.isToggled?60:sideSlim.width
        });
        sideSlim.isToggled = !sideSlim.isToggled;
    })
    $("#sidebartoggler").click();

});
