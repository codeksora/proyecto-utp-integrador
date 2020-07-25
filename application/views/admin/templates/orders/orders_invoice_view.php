<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Factura
        <small>Panel de administración de ordenes</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#!/orders/">Todas las ordenes</a></li>
        <li class="active">Emitir Factura</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Emitir factura</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="frmInvoice" ng-submit="validateInvoice(invoice)" novalidate>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Número de orden</label>
                                        <input type="text" class="form-control" ng-value="(order.order_type_id == 1 ? order.order_number : order.customer_order_number)" readonly>
                                    </div>

                                    <div class="form-group col-md-4 required">
                                        <label>Fecha de emisión</label>
                                        <input date-range-picker
                                               class="form-control"
                                               type="text"
                                               ng-model="invoice.issue_date"
                                               options="issue_date_options.options"
                                               max="issue_date_options.maxDate"
                                               min="issue_date_options.minDate" required>
                                    </div>

                                    <div class="form-group col-md-4 required">
                                        <label for="">Crédito</label>
                                        <select class="form-control" 
                                            ng-options="credit_time.id as credit_time.name for credit_time in credit_times"
                                            ng-model="invoice.credit_time_id" required>
                                            <option value="">Seleccionar</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Tipo de moneda</label>
                                <input type="text" class="form-control" ng-value="order.currency_type_name" readonly>
                            </div>

                            <div class="form-group col-md-2 required">
                                <label>Nº de factura</label>
                                <input type="text" class="form-control" ng-model="invoice.external_invoice_number" required>
                            </div>

                            <div class="form-group col-md-2 required">
                                <label>Guía de remisión</label>
                                <input type="text" class="form-control" ng-model="invoice.referral_guide" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Número de documento del emisor</label>
                                <input type="text" class="form-control" ng-value="order.customer_document_number" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nombre del emisor</label>
                                <input class="form-control" type="text" ng-value="order.customer_name" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Dirección del emisor</label>
                                <input class="form-control" type="text" ng-value="order.customer_address_line_1" readonly>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Número de documento del cliente</label>
                                <input type="text" class="form-control" ng-value="config.ruc_ps" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nombre del cliente</label>
                                <input class="form-control" type="text" ng-value="config.name_ps" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Dirección del cliente</label>
                                <input class="form-control" type="text" ng-value="config.address_ps" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
<!--                                <table class="table table-striped"-->
<!--                                       datatable="ng"-->
<!--                                       dt-options="dtOptionsInvoices"-->
<!--                                       dt-instance="dtInstanceInvoices"-->
<!--                                       dt-column-defs="dtColumnDefsInvoices">-->
<!--                                    <thead>-->
<!--                                    <tr>-->
<!--                                        <th>#</th>-->
<!--                                        <th>Producto</th>-->
<!--                                        <th>Descripción</th>-->
<!--                                        <th>Precio</th>-->
<!--                                        <th>Cantidad</th>-->
<!--                                        <th>Subtotal</th>-->
<!--                                    </tr>-->
<!--                                    </thead>-->
<!--                                    <tbody>-->
<!--                                    <tr ng-repeat="product in order_products">-->
<!--                                        <td>{{ $index + 1 }}</td>-->
<!--                                        <td>{{ product.product_name }}</td>-->
<!--                                        <td>{{ product.descripcion }}</td>-->
<!--                                        <td>{{ product.preciounit_detord | currency : (order.monedaOrd == 'DOLARES') ? '$' : 'S/.' }}</td>-->
<!--                                        <td>{{ product.cant_detord }}</td>-->
<!--                                        <td>{{ product.subtotal_detord | currency : (order.monedaOrd == 'DOLARES') ? '$' : 'S/.' }}</td>-->
<!--                                    </tr>-->
<!--                                    </tbody>-->
<!--                                </table>-->
                                <table datatable="ng"
                                       dt-options="dtOptionsDetails"
                                       dt-instance="dtInstanceDetails"
                                       class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Descuento</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="(key, product) in products">
                                        <td>{{ product.concept_name }} de {{ product.product_name }}
                                            {{ product.quantity_year_id == 1 ? '' : ' por ' + product.quantity_year_name }}
                                            {{ product.qty_san == 0 ? '' : ' + ' + product.qty_san + ' SAN' }}
                                        </td>
                                        <td>{{ product.amount }}</td>
                                        <td>{{ product.subtotal | currency: product.currency_type_symbol + ' ' }}</td>
                                        <td>{{ product.discount | currency: product.currency_type_symbol + ' ' }}</td>
                                        <td>{{ product.total | currency: product.currency_type_symbol + ' ' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-7 optional">
                                <p class="lead">Observación</p>
                                <textarea class="form-control" ng-model="invoice.observation" cols="30" rows="5"></textarea>
                            </div>

                            <div class="col-md-5">
                                <p class="lead">Resumen</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ order.subtotal | currency : order.symbol + ' ' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Impuesto (18%):</th>
                                            <td>{{ order.tax | currency : order.symbol + ' ' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ order.total | currency : order.symbol + ' ' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" ng-if="isDisabledInvoice" ng-disabled="frmInvoice.$invalid == isDisabledInvoice" class="btn btn-primary"><i class="fa fa-credit-card"></i> Emitir Factura</button>
                                <button type="button" class="btn btn-primary" ng-if="!isDisabledInvoice" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
                                <a href="#!/orders/" class="btn btn-danger">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
</section>
<!-- /.content -->