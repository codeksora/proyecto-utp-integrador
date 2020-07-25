<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Productos
        <small>Panel de administración de licencias</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#!/products/">Todos los productos</a></li>
        <li class="active">Agregar producto</li>
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
                            <div class="form-group col-md-4">
                                <label>Fecha de emisión</label>
                                <input class="form-control" type="text" ng-value="now | date: 'dd/MM/yyyy'" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Fecha de vencimiento</label>
                                <input date-range-picker 
                                class="form-control" 
                                type="text" 
                                ng-model="invoice.expiration_date.date"
                                options="invoice.expiration_date.options" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Tipo de moneda</label>
                                <select class="form-control" name="" id="">
                                    <option value="">Soles</option>
                                    <option value="">Dólares</option>
                                    <option value="">Euros</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Tipo de documento</label>
                                <select class="form-control" name="" id="">
                                    <option value="">RUC</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Número de documento</label>
                                <form>
                                <div class="input-group input-group-md">
                                    <input type="text" class="form-control" ng-model="document_number">
                                    <span class="input-group-btn">
                                      <button type="submit" class="btn btn-info btn-flat" ng-if="isDisabledSearch" ng-click="searchOnSunat(document_number)"><i class="fa fa-search"></i></button>
                                        <button type="button" class="btn btn-info btn-flat" ng-if="!isDisabledSearch" disabled><i class="fa fa-pulse fa-spinner"></i></button>
                                    </span>
                                </div>
                                </form>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nombre del cliente</label>
                                <input class="form-control" type="text" ng-value="customer.name" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Dirección</label>
                                <input class="form-control" type="text" ng-value="customer.address" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success pull-right" ng-click="addProductModal()">Agregar producto</button>
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
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Und / Medida</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Sub. Total</th>
                                            <th>I.G.V.</th>
                                            <th>Importe</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="product in invoice.data_products">
                                            <td>{{ product.code }}</td>
                                            <td>{{ product.description }}</td>
                                            <td>{{ product.unit }}</td>
                                            <td>{{ product.price }}</td>
                                            <td>{{ product.quantity }}</td>
                                            <td>{{ product.price * product.quantity | number: 2 }}</td>
                                            <td>{{ (product.price * product.quantity) * 0.18 | number: 2 }}</td>
                                            <td>{{ (product.price * product.quantity) + ((product.price * product.quantity) * 0.18) | number: 2 }}</td>
                                            <td>
                                                <button ng-click="deleteProduct($index)" class="btn btn-xs btn-default"><i class="fa fa-close"></i></button>
                                            </td>
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
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>{{ invoice.subtotal | number: 2 }}</td>
                                            </tr>
                                            <tr>
                                                <th>Impuesto (18%)</th>
                                                <td>{{ invoice.tax | number: 2 }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>{{ invoice.total | number: 2 }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-credit-card"></i> Emitir Factura</button>
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
