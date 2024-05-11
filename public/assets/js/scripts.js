$(document).ready(function () {
    function openDeleteModal() {
        $("#confirmModalDelete").css("display", "block");
    }

    function closeDeleteModal() {
        $("#confirmModalDelete").css("display", "none");
    }

    $("#valor").mask("000.000.000.000.000,00", { reverse: true });
});
