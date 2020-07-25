<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Ordenes
    <small>Panel de administración de ordenes</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/orders/">Todas las ordenes</a></li>
    <li class="active">Añadir orden</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar orden</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmOrder" ng-submit="add(order)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
                  <label>Nombre/Razón Social</label>
                  <select class="form-control"
                          ui-select2 ng-model="order.customer_id"
                          data-placeholder="Seleccionar" ng-required="true"
                          ng-options="customer.id as customer.name for customer in customers">
                    <option value="">Seleccionar</option>
                  </select>
              </div>

              <div class="form-group col-md-3">
                  <label>Tipo de orden</label>
                  <select class="form-control" ng-model="order.order_type_id" ng-options="order_type.id as order_type.name for order_type in order_types" required>
                    <option value="">Seleccionar</option>
                  </select>
              </div>

              <div class="form-group col-md-3">
                  <label>Nro. de orden</label>
                  <input type="text" class="form-control" ng-if="!order.order_type_id" disabled>
                  <input type="text" class="form-control" ng-if="order.order_type_id == 1" value="ORD-0000XXXX" disabled>
                  <input type="text" class="form-control" ng-model="order.customer_order_number" ng-if="order.order_type_id == 2">
                  <input type="text" class="form-control" ng-if="order.order_type_id == 3 || order.order_type_id == 4" value="PENDIENTE DE ENVÍO" disabled>
              </div>

              <div class="form-group col-md-2">
                  <label>Tipo de moneda</label>
                  <select class="form-control" ng-model="order.currency_type_id" ng-options="currency_type.id as currency_type.name for currency_type in currency_types" ng-disabled="order.data_products.length >= 1" required>
                    <option value="">Seleccionar</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-3">
                  <label>Fecha de recepción</label>
                  <input date-range-picker options="single_date_options" class="form-control" type="text" ng-model="order.reception_date" ng-disabled="order.order_type_id == 4" required>
              </div>

              <div class="form-group col-md-3">
                  <label>Fecha de vencimiento</label>
                  <input date-range-picker options="single_date_options" class="form-control" type="text" ng-model="order.expiration_date" ng-disabled="order.order_type_id == 4" required>
              </div>

              <div class="form-group col-md-3">
                  <label>Fecha de orden</label>
                  <input date-range-picker options="single_date_options" class="form-control" type="text" ng-model="order.order_date" ng-disabled="order.order_type_id == 4" required>
              </div>

              <div class="form-group col-md-3">
                  <label>Documento cotización</label>
                  <input type="file" class="form-control">
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12 text-right">
                <button type="button" ng-click="addProductModal()" class="btn btn-primary btn-sm" ng-disabled="!order.currency_type_id">Agregar producto</button>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                    <table class="table table-striped table-bordered"
                        datatable="ng"
                        dt-options="dtOptionsOrders"
                        dt-instance="dtInstanceOrders"
                        dt-column-defs="dtColumnDefsOrders">
                        <thead>
                            <tr>
                                <th>Tipo de producto</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Cant. SAN</th>
                                <th>Precio SAN</th>
                                <th>Subtotal</th>
                                <th>Descuento %</th>
                                <th>Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="product in order.data_products">
                                <td>{{ product.product_type_name }}</td>
                                <td>{{ product.name + ' ' + product.quantity_year_name + (product.qty_san ? ' + ' + product.qty_san + ' SAN' : '') }}</td>
                                <td>{{ product.amount }}</td>
                                <td>{{ product.product_detail_price | number: 2 }}</td>
                                <td>{{ product.qty_san }}</td>
                                <td>{{ product.product_san_detail_price | number: 2 }}</td>
                                <td>{{ product.subtotal | number: 2 }}</td>
                                <td>{{ product.discount | number: 2 }}</td>
                                <td>{{ product.total | number: 2 }}</td>
                                <td>
                                    <button type="button" ng-click="deleteProduct($index)" class="btn btn-xs btn-default"><i class="fa fa-close"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
              </div>
            </div>

            <div class="row">
                    <div class="form-group col-md-7">
                        <p class="lead">Observación</p>
                        <textarea class="form-control" ng-model="order.observation" cols="30" rows="5"></textarea>
                    </div>

                    <div class="col-md-5">
                        <p class="lead">Resumen</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{ order.subtotal | number: 2 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Impuesto (18%)</th>
                                        <td>{{ order.tax | number: 2 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>{{ order.total | number: 2 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
              <button type="submit" ng-if="isDisabled" ng-disabled="frmOrder.$invalid == isDisabled" class="btn btn-primary" ng-disabled="disable">Agregar</button>
              <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
              <a href="#!/orders/" class="btn btn-danger">Regresar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
