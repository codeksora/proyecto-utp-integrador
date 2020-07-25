<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Boleta
        <small>Panel de administración de ordenes</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#!/orders-intranet/">Todas las ordenes</a></li>
        <li class="active">Emitir Boleta</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Agregar factura</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Número de orden</label>
                                    <input type="text" class="form-control" ng-value="order.nro_ordenOrd" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Fecha de emisión *</label>
                                    <input date-range-picker
                                           class="form-control"
                                           type="text"
                                           ng-model="invoice.issue_date.date"
                                           options="invoice.issue_date.options"
                                           max="invoice.issue_date.maxDate"
                                           min="invoice.issue_date.minDate">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Crédito *</label>
                                    <select class="form-control" ng-model="invoice.expiration_date">
                                        <option value="">Hoy</option>
                                        <option value="7">7 días</option>
                                        <option value="10">10 días</option>
                                        <option value="15">15 días</option>
                                        <option value="30">30 días</option>
                                        <option value="60">60 días</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Tipo de moneda</label>
                            <input type="text" class="form-control" ng-value="order.monedaOrd" readonly>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Guía de remisión *</label>
                            <input type="text" class="form-control" ng-model="invoice.referral_guide" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Número de documento del emisor</label>
                            <input type="text" class="form-control" ng-value="perusecurity.ruc" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nombre del emisor</label>
                            <input class="form-control" type="text" ng-value="perusecurity.razon_social" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Dirección del emisor</label>
                            <input class="form-control" type="text" ng-value="perusecurity.direccion" readonly>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Número de documento del cliente</label>
                            <input type="text" class="form-control" ng-value="customer.ruc" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nombre del cliente</label>
                            <input class="form-control" type="text" ng-value="customer.razon_social" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Dirección del cliente</label>
                            <input class="form-control" type="text" ng-value="customer.direccion" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped"
                                   datatable="ng"
                                   dt-options="dtOptionsInvoices"
                                   dt-instance="dtInstanceInvoices"
                                   dt-column-defs="dtColumnDefsInvoices">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="product in order_products">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ product.product_name }}</td>
                                    <td>{{ product.descripcion }}</td>
                                    <td>{{ product.preciounit_detord | currency : (order.monedaOrd == 'DOLARES') ? '$' : 'S/.' }}</td>
                                    <td>{{ product.cant_detord }}</td>
                                    <td>{{ product.subtotal_detord | currency : (order.monedaOrd == 'DOLARES') ? '$' : 'S/.' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-7">
                            <p class="lead">Observación</p>
                            <textarea class="form-control" ng-model="invoice.observation" cols="30" rows="5"></textarea>
                        </div>

                        <div class="col-md-5">
                            <p class="lead">Resumen</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{ order.subtotalOrd | currency : (order.monedaOrd == 'DOLARES') ? '$' : 'S/.' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Impuesto (18%):</th>
                                        <td>{{ order.igvOrd | currency : (order.monedaOrd == 'DOLARES') ? '$' : 'S/.' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>{{ order.totalOrd | currency : (order.monedaOrd == 'DOLARES') ? '$' : 'S/.' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-credit-card"></i> Emitir Factura</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
</section>
<!-- /.content -->