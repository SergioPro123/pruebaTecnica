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
    <script src="assets/js/kardex.js"></script>
</head>

<body>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>Kardex</b></h2>
                        </div>
                        <div class="col-xs-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i> <span>Añadir Operación</span></a>
                            <div class="row">
                                <div class="col-xs-6">
                                    <a id="generarKardex" href="{{ route('producto.getViewProduct') }}"
                                        class="btn btn-primary"><i class="material-icons">&#xe00d;</i> <span>Administrar
                                            Productos</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th># Factura</th>
                            <th>Nompre Producto</th>
                            <th>Tipo Operación</th>
                            <th>Cantidad</th>
                            <th>Valor Unitario</th>
                            <th>Valor Total</th>

                        </tr>
                    </thead>
                    <tbody id="tabla">
                        @php($cantidad_prod = 0)
                            @foreach ($data as $dato)
                                <tr id='inventarioInicial'>
                                    <td>{{ $dato->fecha }}</td>
                                    <td>{{ $dato->num_factura }}</td>
                                    <td>{{ $dato->nombreProductos }}</td>
                                    <td>{{ $dato->tipo_operacion }}</td>
                                    <td>{{ $dato->cantidad }}</td>
                                    <td>{{ $dato->valor_unitario }}</td>
                                    <td>{{ $dato->valor_total }}</td>
                                </tr>
                                @php($cantidad_prod++)
                                    @if ($loop->last)
                                        @php($ultimaFecha = $dato->fecha)
                                        @endif
                                    @endforeach

                                    <!-- Aqui va el contenido de registros!-->

                                </tbody>
                            </table>
                            <div class="clearfix">
                                <div class="hint-text col-xs-6">Mostrando <strong
                                        id="cantidadOperaciones">{{ $cantidad_prod }}</strong> Operaciones.
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a id="generarKardex" href="{{ route('producto.getViewProduct') }}"
                                            class="btn btn-primary"><i class="material-icons">&#xe00d;</i> <span>Administrar
                                                Productos</span></a>
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
                            <form id="formAgregar" method="POST" action="kardex">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Añadir Operación</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <?php if (!isset($ultimaFecha)) {
                                        $ultimaFecha = false;
                                        } ?>
                                        <input type="date" class="form-control" name="fecha" min="{{ $ultimaFecha }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Número Factura</label>
                                        <input type="number" class="form-control" min="1" name="num_factura" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Producto</label>
                                        <select name="id_productos" class="form-control" id="producto">
                                            @foreach ($productos as $dato)
                                                <option value="{{ $dato->id_productos }}">{{ $dato->nombreProducto }} -
                                                    {{ $dato->nombre_empresa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo de Operación</label>
                                        <select name="tipoOperacion" class="form-control" id="selectAgregar">
                                            <option value="compra">Compra</option>
                                            <option value="venta">Venta</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" class="form-control" min="1" name="cantidad" required>
                                    </div>
                                    <div class="form-group" id="valorUnitarioAgregar">
                                        <label>Valor Unitario</label>
                                        <input type="number" tep="0.01" class="form-control" min="1" name="valorUnitario" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                    <input type="submit" class="btn btn-success" value="Añadir">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </body>

            </html>
