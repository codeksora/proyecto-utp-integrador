<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Cotizaciones
    <small>Panel de administración de cotizaciones</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/quotations/">Todas las cotizaciones</a></li>
    <li class="active">Añadir cotización</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar cotización</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmOrder" ng-submit="add(quotation)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
                  <label>Nombre/Razón Social</label>
                  <oi-select
                oi-options="customer.id as customer.name for customer in customers.data | limitTo: 10"
                ng-model="quotation.customer_id"
                placeholder="Seleccionar"
                required
                ></oi-select>
              </div>

              <div class="form-group col-md-2">
                  <label>Tipo de moneda</label>
                  <oi-select
                ng-model="quotation.currency_type_id" oi-options="currency_type.id as currency_type.name for currency_type in currency_types" ng-disabled="quotation.data_products.length >= 1"
                placeholder="Seleccionar"
                required
                ></oi-select>
              </div>
              
              <div class="form-group col-md-2">
                  <label>Cantidad de crédito</label>
                  <oi-select
                ng-model="quotation.credit_time_id" oi-options="credit_time.id as credit_time.name for credit_time in credit_times"
                placeholder="Seleccionar"
                required
                ></oi-select>
              </div>

              <div class="form-group col-md-4">
                  <label>Plantilla PDF</label>
                  <oi-select 
                  oi-options="quotation_template.id as quotation_template.name for quotation_template in quotation_templates | filter: {currency_type_id: quotation.currency_type_id}" 
                  ng-model="quotation.quotation_template_id" 
                  ng-disabled="!quotation.currency_type_id"
                  required
                  placeholder="Seleccionar">
                  </oi-select>
              </div>
            </div>

            <div class="row" ng-if="quotation.quotation_template_id == 1 || quotation.quotation_template_id == 2 || quotation.quotation_template_id == 3 || quotation.quotation_template_id == 4">
              <div class="form-group col-md-12">
                  <label>Contacto</label>
                  <oi-select 
                  oi-options="contact.id as (contact.first_name + ' ' + contact.last_name + ' - ' + contact.email) for contact in contacts | filter: {customer_id: quotation.customer_id}" 
                  ng-model="quotation.contact_id" 
                  placeholder="Seleccionar"
                  ng-disabled="!quotation.customer_id"
                  required>
                  </oi-select>
              </div>
            </div>
            
            <div class="row">
              <div class="form-group col-md-12 text-right">
                <button type="button" ng-click="addProductModal()" class="btn btn-primary btn-sm" ng-disabled="!quotation.currency_type_id">Agregar producto</button>
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
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="product in quotation.data_products">
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
                        <p class="lead">Comentarios</p>
                        <textarea class="form-control" ng-model="quotation.observation" cols="30" rows="5"></textarea>
                        <p class="text-red"><strong>Esto aparecerá en la cotización como comentario</strong></p>
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
              <button type="submit" ng-if="isDisabled" ng-disabled="frmOrder.$invalid == isDisabled" class="btn btn-primary" ng-disabled="disable">Agregar</button>
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
