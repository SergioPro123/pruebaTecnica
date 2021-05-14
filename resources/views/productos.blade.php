<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generador de Kardex</title>
    <link rel="icon" href="assets/img/icono.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/lib/jszip.js"></script>
    <script src="assets/js/productos.js"></script>
</head>

<body>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>Productos</b> Existentes</h2>
                        </div>

                        <div class="col-xs-6">

                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i> <span>Nuevo producto</span></a>
                            <div class="row">
                                <div class="col-xs-6">
                                    <a id="generarKardex" href="{{ route('kardex.getViewKardex') }}"
                                        class="btn btn-primary"><i class="material-icons">&#xe00d;</i> <span>Registrar
                                            Kardex</span></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID Producto</th>
                            <th>Proveedor</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla">
                        @php($cantidad_prod = 0)
                            @foreach ($data as $dato)
                                <tr id="{{ $dato->id_productos }}">
                                    <td>{{ $dato->id_productos }}</td>
                                    <td id="{{ $dato->id_proveedores }}">{{ $dato->nombre_empresa }}</td>
                                    <td>{{ $dato->nombreProducto }}</td>
                                    <td id="{{ $dato->id_categoria }}">{{ $dato->categoria }}</td>
                                    <td>
                                        <a href='#editEmployeeModal' class='edit' data-toggle='modal'><i
                                                class='material-icons' data-toggle='tooltip' title='Editar'>&#xE254;</i></a>
                                        <a href='#deleteEmployeeModal' class='delete' data-toggle='modal'><i
                                                class='material-icons' data-toggle='tooltip'
                                                title='Eliminar'>&#xE872;</i></a>
                                    </td>
                                </tr>
                                @php($cantidad_prod++)
                                @endforeach

                                <!-- Aqui va el contenido de registros!-->

                            </tbody>
                        </table>
                        <div class="clearfix">
                            <div class="hint-text col-xs-6">Mostrando <strong
                                    id="cantidadOperaciones">{{ $cantidad_prod }}</strong> Productos.
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <a id="generarKardex" href="{{ route('kardex.getViewKardex') }}"
                                        class="btn btn-primary"><i class="material-icons">&#xe00d;</i> <span>Registrar
                                            Kardex</span></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Añadir Modal HTML -->
            <div id="addEmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formAgregar" method="POST" action="producto">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">Agregar nuevo Producto</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Proveedor</label>
                                    <select name="proveedor" class="form-control" id="proveedor">
                                        @foreach ($proveedores as $dato)
                                            <option value="{{ $dato->id_proveedores }}">{{ $dato->nombre_empresa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" required id="nombre" name="nombre">
                                </div>
                                <div class="form-group" id="valorUnitarioDiv">
                                    <label>Categoria</label>
                                    <select name="categoria" class="form-control" id="categoria">
                                        @foreach ($categorias as $dato)
                                            <option value="{{ $dato->id_categoria }}">{{ $dato->categoria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                <input type="submit" class="btn btn-info" value="Agregar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Editar Modal HTML -->
            <div id="editEmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formEditar" method="POST" action="producto">
                            @csrf
                            @method('put')
                            <div class="modal-header">
                                <h4 class="modal-title">Editar Producto</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Proveedor</label>
                                    <select name="proveedor" class="form-control" id="proveedorEdit">
                                        @foreach ($proveedores as $dato)
                                            <option value="{{ $dato->id_proveedores }}">{{ $dato->nombre_empresa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" required id="nombreEdit" name="nombre">
                                </div>
                                <div class="form-group" id="valorUnitarioEditDiv">
                                    <label>Categoria</label>
                                    <select name="categoria" class="form-control" id="categoriaEdit">
                                        @foreach ($categorias as $dato)
                                            <option value="{{ $dato->id_categoria }}">{{ $dato->categoria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="idProductoEditar" name="idProductoEditar">

                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                <input type="submit" class="btn btn-info" value="Editar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Eliminar Individual Modal HTML -->
            <div id="deleteEmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formEliminar" method="POST" action="producto">
                            @csrf
                            @method('DELETE')

                            <div class="modal-header">
                                <h4 class="modal-title">Eliminar Producto</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>¿Está seguro de que desea eliminar este producto?</p>
                                <p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                <input type="submit" class="btn btn-danger" value="Eliminar">
                            </div>
                            <input type="hidden" id="idProductoEliminar" name="idProductoEliminar">
                        </form>
                    </div>
                </div>
            </div>
        </body>

        </html>
