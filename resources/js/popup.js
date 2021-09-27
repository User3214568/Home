export default function popup(title, content, bg, icon = 'far fa-times-circle') {

    $("#modal-title-id").empty();
    $("#modal-header").addClass('border-white');
    $("#modal-header").addClass(bg + ' d-flex flex-column text-white ');
    $("#modal-header").empty()
    $("#modal-header").append("<div class='d-flex justify-content-center align-items-center " + bg + "'><p><i class='" + icon + " fa-6x'></i></p></div>")
    $("#modal-footer").addClass('border-white');
    $("#modal-id").html(
        "<div class='mt-2 d-flex justify-content-center align-items-center'><p class='h4'>" + title + "</p=></div>" +
        "<div class='d-flex justify-content-center align-items-center'><p>" + content + "</p></div>"
    );
    $("#saveModules").remove();
    $("#close-popup").addClass(bg)
    $("#modal-trigger").click();
}
