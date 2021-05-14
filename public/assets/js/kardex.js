var operaciones = 0;
var datosOperaciones = {};
var date = new Date();
let fechaActual = date.getFullYear() + "-";
if (date.getMonth() + 1 < 10) {
    fechaActual += "0" + (date.getMonth() + 1) + "-";
} else {
    fechaActual += date.getMonth() + 1 + "-";
}
if (date.getDate() < 10) {
    fechaActual += "0" + date.getDate();
} else {
    fechaActual += date.getDate();
}
datosOperaciones.inventarioInicial = {
    fecha: fechaActual,
    cantidad: "1",
    valorUnitario: "1",
    descripcion: "",
};
//Esta variable contrendra el ID de un registro cuando se selecciona editar.
var idUltimaEditacion;
//Esta variable contendra el ID de un registro cuando se selecciona eliminar
var idUltimaEliminacion;

$(document).ready(function () {
    // Select/Deselect checkboxes
    $("#selectAll").on("click", function () {
        let checkbox = $('table tbody input[type="checkbox"]');
        if (this.checked) {
            checkbox.each(function () {
                this.checked = true;
            });
        } else {
            checkbox.each(function () {
                this.checked = false;
            });
        }
    });
    $('table tbody input[type="checkbox"]').on("click", function () {
        if (!this.checked) {
            $("#selectAll").prop("checked", false);
        }
    });

    //Este evento captura los cambios de la entrada 'Select',
    //ya que si el motivo es de compra, se reflejara la opcion
    //de valor unitario, de lo contrario se ocultara.
    $("#selectAgregar").on("change", function () {
        let divValorUnitario = $("div#valorUnitarioAgregar");
        let input = $("div#valorUnitarioAgregar input");
        if ($(this).val() === "compra") {
            divValorUnitario.fadeIn(300);
            input.prop("required", true);
        } else {
            divValorUnitario.fadeOut(300);
            input.prop("required", false);
        }
    });
    //La misma funcion, pero va enfocada al modal Editar
    $("form#formEditar #tipoOperacionEdit").on("change", function () {
        let divValorUnitario = $("div#valorUnitarioEditDiv");
        let input = $("div#valorUnitarioEdit");
        if ($(this).val() === "compra") {
            divValorUnitario.fadeIn(300);
            input.prop("required", true);
        } else {
            divValorUnitario.fadeOut(300);
            input.prop("required", false);
        }
    });
});
//Esta funcion es para abrir el modal de editar, con la informació seleccionada
$(document).on(
    "click",
    'tr td a[href = "#editEmployeeModal"]',
    function (event) {
        idUltimaEditacion = $(this).parent().parent().attr("id");
        let select = datosOperaciones[idUltimaEditacion].tipoOperacion;

        $("form#formEditar #fechaEdit").val(
            datosOperaciones[idUltimaEditacion].fecha
        );
        if (select === "venta") {
            $("form#formEditar #tipoOperacionEdit option[value='venta']").attr(
                "selected",
                true
            );
            //Ocultamos el Valor Unitario
            $("form#formEditar #valorUnitarioEditDiv").hide();
            $("form#formEditar #valorUnitarioEdit").prop("required", false);
        } else {
            $(
                "form#formEditar #tipoOperacionEdit option[value='comprar']"
            ).attr("selected", true);
            //Se muestra el valor Unitario
            $("form#formEditar #valorUnitarioEditDiv").show();
            $("form#formEditar #valorUnitarioEdit").prop("required", true);
            $("form#formEditar #valorUnitarioEdit").val(
                datosOperaciones[idUltimaEditacion].valorUnitario
            );
        }
        $("form#formEditar #descripcionEdit").val(
            datosOperaciones[idUltimaEditacion].descripcion
        );
        $("form#formEditar #cantidadEdit").val(
            datosOperaciones[idUltimaEditacion].cantidad
        );
    }
);

//Esta funcion es para abrir el modal de editar de unico registro llamado 'INVENTARIO INICIAL'
$(document).on(
    "click",
    'tr td a[href = "#editEmployeeModalInventario"]',
    function (event) {
        idUltimaEditacion = $(this).parent().parent().attr("id");

        $("form#formEditarInventario #valorUnitarioEditDivInventario").show();
        $("form#formEditarInventario #valorUnitarioEditInventario").prop(
            "required",
            true
        );
        $("form#formEditarInventario #valorUnitarioEditInventario").val(
            datosOperaciones[idUltimaEditacion].valorUnitario
        );

        $("form#formEditarInventario #fechaEditInventario").val(
            datosOperaciones[idUltimaEditacion].fecha
        );
        $("form#formEditarInventario #descripcionEditInventario").val(
            datosOperaciones[idUltimaEditacion].descripcion
        );
        $("form#formEditarInventario #cantidadEditInventario").val(
            datosOperaciones[idUltimaEditacion].cantidad
        );
    }
);

//Este evento se encarga de editar nuestros registros
$(document).on("submit", "form#formEditar", function (event) {
    event.preventDefault();
    let info = $(this).serializeArray();
    let datos = {};
    $.each(info, function (i, array) {
        datos[array.name] = array.value;
    });
    //comprobamos que no haya ningun valor unitario si selecciono la opcion "venta"
    if (datos.tipoOperacion === "venta") {
        datos.valorUnitario = "0";
    }
    //Actualizamos de la operacion en nuestro array, que contiene todas las operaciones.
    datosOperaciones[idUltimaEditacion] = datos;

    // Recontruimos el registro
    let registro =
        "<td> <span class='custom-checkbox'>" +
        "<input type='checkbox' id='checkboxOperacion" +
        idUltimaEditacion +
        "' name='options[]' value='" +
        idUltimaEditacion +
        "'>" +
        "<label for='checkbox" +
        idUltimaEditacion +
        "'></label>" +
        "</span>" +
        "</td>" +
        `<td>${datos.fecha}</td>` +
        `<td>${
            datos.tipoOperacion.charAt(0).toUpperCase() +
            datos.tipoOperacion.substring(1)
        }</td>` +
        `<td>${datos.descripcion}</td>` +
        `<td>${datos.cantidad}</td>` +
        `<td>${datos.valorUnitario || ""}</td>` +
        "<td>" +
        "<a href='#editEmployeeModal' class='edit' data-toggle='modal'><i class='material-icons' data-toggle='tooltip' title='Editar'>&#xE254;</i></a>" +
        "<a href='#deleteEmployeeModal' class='delete' data-toggle='modal'><i class='material-icons' data-toggle='tooltip' title='Eliminar'>&#xE872;</i></a>" +
        "</td>";
    //Añadimos un nuevo registro a la tabla
    $(`tbody#tabla tr#${idUltimaEditacion}`).html(registro);
    //Cerramos el modal de 'Editar Operación'
    $("#editEmployeeModal").modal("hide");
    //Limpiamos el formulario
    $(this)[0].reset();
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
});

//Esta funcion es para capturar el ID del registro que se quiere eliminar
$(document).on(
    "click",
    'tr td a[href = "#deleteEmployeeModal"]',
    function (event) {
        idUltimaEliminacion = $(this).parent().parent().attr("id");
    }
);

//Este evento se encarga de eliminar un registro seleccionado.
$(document).on("submit", "form#formEliminar", function (event) {
    event.preventDefault();
    delete datosOperaciones[idUltimaEliminacion];
    //Cerramos el modal de 'Eliminar Operación'
    $("#deleteEmployeeModal").modal("hide");
    //Ocultamos primero la tabla para dar un efecto de desvanecimiento
    $(`tbody#tabla tr#${idUltimaEliminacion}`).fadeOut(500, function () {
        //Eliminamos la operacion de la tabla
        $(`tbody#tabla tr#${idUltimaEliminacion}`).remove();
    });
    //Actualizamos la visualizacion de operaciones actuales
    $("#cantidadOperaciones").text(
        parseInt($("#cantidadOperaciones").text()) - 1
    );
});
