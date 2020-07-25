<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Cotizaciones
    <small>Panel de administración de cotizaciones</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/quotations/">Todas las cotizaciones</a></li>
    <li class="active">Validar cotización</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Validar cotización</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmQuotation" ng-submit="validate(quotation)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
                  <label>Nombre/Razón Social</label>
                  <input type="text" class="form-control" ng-value="quotation.customer_name" readonly>
              </div>

              <div class="form-group col-md-3">
                  <label>Tipo de orden</label>
                  <select class="form-control" ng-model="quotation.order_type_id" ng-options="order_type.id as order_type.name for order_type in order_types" required>
                    <option value="">Seleccionar</option>
                  </select>
              </div>

              <div class="form-group col-md-3">
                  <label>Nro. de orden</label>
                  <input type="text" class="form-control" ng-if="!quotation.order_type_id" disabled>
                  <input type="text" class="form-control" ng-if="quotation.order_type_id == 1" value="ORD-0000XXXX" disabled>
                  <input type="text" class="form-control" ng-model="quotation.customer_order_number" ng-if="quotation.order_type_id == 2">
                  <input type="text" class="form-control" ng-if="quotation.order_type_id == 3 || quotation.order_type_id == 4 || quotation.order_type_id == 6" value="PENDIENTE DE ENVÍO" disabled>
              </div>

              <div class="form-group col-md-2">
                  <label>Tipo de moneda</label>
                  <input type="text" class="form-control" ng-value="quotation.currency_type_name" readonly>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-3">
                  <label>Fecha de recepción</label>
                  <input date-range-picker options="single_date_options" class="form-control" type="text" ng-model="quotation.reception_date" ng-disabled="quotation.order_type_id == 4" required>
              </div>

              <div class="form-group col-md-3">
                  <label>Fecha de vencimiento</label>
                  <input date-range-picker options="single_date_options" class="form-control" type="text" ng-model="quotation.expiration_date" ng-disabled="quotation.order_type_id == 4" required>
              </div>

              <div class="form-group col-md-3">
                  <label>Fecha de orden</label>
                  <input date-range-picker options="single_date_options" class="form-control" type="text" ng-model="quotation.order_date" ng-disabled="quotation.order_type_id == 4" required>
              </div>

              <div class="form-group col-md-3">
                  <label>Documento cotización</label>
                  <a href="<?php echo base_url(); ?>{{ quotation.quotation_template_id == null ? 'assets/backend/pdfs/' + quotation.quotation_document : 'admin/quotations/' + quotation.id + '/document/' }}" target="_blank" class="btn bg-purple btn-block"><i class="fa fa-download"></i> documento de cotización</a>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                    <table class="table table-striped table-bordered"
                        datatable="ng"
                        dt-options="dtOptionsQuotations"
                        dt-instance="dtInstanceQuotations"
                        dt-column-defs="dtColumnDefsQuotations">
                        <thead>
                            <tr>
                                <th>Tipo de producto</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Cant. SAN</th>
                                <th>Precio SAN</th>
                                <th>Subtotal</th>
                                <th>Descuento</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="product in products">
                                <td>{{ product.product_type_name }}</td>
                                <td>{{ product.product_name + ' ' + product.quantity_year_name + (product.qty_san ? ' + ' + product.qty_san + ' SAN' : '') }}</td>
                                <td>{{ product.amount }}</td>
                                <td>{{ product.product_detail_price | number: 2 }}</td>
                                <td>{{ product.qty_san }}</td>
                                <td>{{ product.product_san_detail_price | number: 2 }}</td>
                                <td>{{ product.subtotal | number: 2 }}</td>
                                <td>{{ product.discount | number: 2 }}</td>
                                <td>{{ product.total | number: 2 }}</td>
                            </tr>
                        </tbody>
                    </table>
              </div>
            </div>

            <div class="row">
                    <div class="form-group col-md-7">
                        <p class="lead">Observación</p>
                        <textarea class="form-control" ng-model="quotation.observation" cols="30" rows="5"></textarea>
                    </div>

                    <div class="col-md-5">
                        <p class="lead">Resumen</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{ quotation.subtotal | number: 2 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Impuesto (18%)</th>
                                        <td>{{ quotation.tax | number: 2 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>{{ quotation.total | number: 2 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
              <button type="submit" ng-if="isDisabled" ng-disabled="frmQuotation.$invalid == isDisabled" class="btn btn-primary" ng-disabled="disable">Agregar orden</button>
              <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
              <a href="#!/quotations/" class="btn btn-danger">Regresar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
