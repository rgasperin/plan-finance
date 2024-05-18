$(document).ready(function () {
    ClassicEditor.create(document.querySelector("#editor")).catch((error) => {
        console.error(error);
    });

    $(".btn-danger").click(function () {
        $("#confirmDeleteModal").modal("show");
    });
});
