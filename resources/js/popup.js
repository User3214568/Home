export default function popup(title, content, bg, icon = 'far fa-times-circle') {

    $("#modal-title-id").empty();
    $("#modal-header").removeClass("bg-danger bg-success")
    $("#modal-header").addClass(bg)
    $("#modal-header").empty()
    $("#modal-header").append("<div class='d-flex justify-content-center align-items-center " + bg + "'><p><i class='" + icon + " fa-6x'></i></p></div>")
    $("#modal-footer").addClass('border-white');
    $("#modal-id").empty()
    $("#modal-id").html(
        "<div class='mt-2 d-flex justify-content-center align-items-center'><p class='h4'>" + title + "</p></div>" +
        "<div class='d-flex justify-content-center align-items-center'><p>" + content + "</p></div>"
    );

    $("#close-popup").removeClass("bg-danger bg-success")
    $("#close-popup").addClass(bg)
    $("#modal-trigger").click();
}
