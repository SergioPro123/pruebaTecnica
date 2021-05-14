$(document).ready(function () {});
//Esta funcion es para abrir el modal de editar, con la informació seleccionada
$(document).on(
    "click",
    'tr td a[href = "#editEmployeeModal"]',
    function (event) {
        let elementos = $(this).parent().parent().find("td");
        let idProductoEditar = $(this).parent().parent().attr("id");

        $("#proveedorEdit").val(elementos.eq(1).attr("id")).change();
        $("#nombreEdit").val(elementos.eq(2).text());
        $("#categoriaEdit").val(elementos.eq(3).attr("id")).change();
        $("#idProductoEditar").val(idProductoEditar);
    }
);
//Esta funcion es para capturar el ID del registro que se quiere eliminar
$(document).on(
    "click",
    'tr td a[href = "#deleteEmployeeModal"]',
    function (event) {
        let idUltimaEliminacion = $(this).parent().parent().attr("id");
        $("#idProductoEliminar").val(idUltimaEliminacion);
    }
);
