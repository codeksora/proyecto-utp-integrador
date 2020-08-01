<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Productos
    <small>Panel de administración de productos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/products/">Todos los productos</a></li>
    <li class="active">Editar producto</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar producto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmProduct" ng-submit="save(product)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Proveedor *</label>
                    <oi-select 
                    oi-options="provider.id as provider.name for provider in providers" 
                    ng-model="product.provider_id" 
                    required
                    placeholder="Seleccionar">
                    </oi-select>
                </div>

                <div class="form-group col-md-4">
                    <label>Tipo de producto *</label>
                    <oi-select 
                    oi-options="product_type.id as product_type.name for product_type in product_types" 
                    ng-model="product.product_type_id" 
                    required
                    placeholder="Seleccionar">
                    </oi-select>
                </div>
                
                <div class="form-group col-md-4 required">
  	                <label>Categoría</label>
                    <oi-select 
                  oi-options="product_category.id as product_category.name for product_category in product_categories" 
                  ng-model="product.product_category_id" 
                  required
                  placeholder="Seleccionar">
                  </oi-select>
  	            </div>

                <div class="form-group col-md-12 required">
  	                <label>Nombre</label>
  	                <input class="form-control" type="text" ng-model="product.name" required>
  	            </div>

          	</div>
            
            <div class="row">
	            <div class="form-group col-md-12 required">
	                <label>Descripción</label>
                  <textarea class="form-control" ng-model="product.description" cols="30" rows="10" required></textarea>
	            </div>
          	</div>

            <div class="row">
              <div class="form-group col-md-12">
                <a ng-if="product.information_document" href="<?php echo site_url('product_docs'); ?>{{ product.information_document }}" target="_blank" class="btn bg-purple"><i class="fa fa-download"></i> VER FICHA TÉCNICA</a>
                <button type="button" class="btn bg-purple" ng-if="!product.information_document" disabled>No tiene ficha técnica</button>
              </div>
            </div>
  
             <!-- Certificado SSL -->
             <div class="row">
                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 1">
                    <label>Precio dólares</label>
                    <input class="form-control" type="number" ng-model="product.details[0].price" min="1" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 2 || product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio dólares (1 año)</label>
                    <input class="form-control" type="number" ng-model="product.details[0].price" min="1" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio dólares (2 años)</label>
                    <input class="form-control" type="number" ng-model="product.details[1].price" min="1" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 4">
                    <label>Precio dólares (3 años)</label>
                    <input class="form-control" type="number" ng-model="product.details[2].price" min="1" max="99999" step=".01" required>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 1">
                    <label>Precio soles</label>
                    <input class="form-control" type="number" ng-model="product.details[0].price_pen" min="1" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 2 || product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio soles (1 año)</label>
                    <input class="form-control" type="number" ng-model="product.details[0].price_pen" min="1" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio soles (2 años)</label>
                    <input class="form-control" type="number" ng-model="product.details[1].price_pen" min="1" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 4">
                    <label>Precio soles (3 años)</label>
                    <input class="form-control" type="number" ng-model="product.details[2].price_pen" min="1" max="99999" step=".01" required>
                </div>
            </div>

             <!-- Certificado SAN -->
             <div class="row" ng-if="product.is_san == 1">
               <div class="col-md-12">
                 <div class="row">
                  <div class="form-group col-md-3">
                      <label>Cant. SAN base</label>
                      <input class="form-control" type="number" ng-model="product.san_base"  min="1" max="99999" step=".01"  required>
                  </div>

                  <div class="form-group col-md-3">
                      <label>Cant. SAN máx.</label>
                      <input class="form-control" type="number" ng-model="product.san_max" min="1" max="99999" step=".01"  required>
                  </div>
                 </div>
               </div>
               
               <div class="col-md-12">
                <div class="row">
                  <div class="form-group col-md-6">
                      <label>Precio dólares SAN (1 año)</label>
                      <input class="form-control" type="number" ng-model="product.san_details[0].price" min="1" max="99999" step=".01"  required>
                  </div>

                  <div class="form-group col-md-6">
                      <label>Precio dólares SAN (2 años)</label>
                      <input class="form-control" type="number" ng-model="product.san_details[1].price" min="1" max="99999" step=".01"  required>
                  </div>
                 
                 </div>
                 
                 <div class="row">
                   <div class="form-group col-md-6">
                        <label>Precio soles SAN (1 año)</label>
                        <input class="form-control" type="number" ng-model="product.san_details[0].price_pen" min="1" max="99999" step=".01"  required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Precio soles SAN (2 años)</label>
                        <input class="form-control" type="number" ng-model="product.san_details[1].price_pen" min="1" max="99999" step=".01"  required>
                    </div>
                 </div>
               </div>               
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat" ng-if="isDisabled" ng-disabled="frmProduct.$invalid == isDisabled">ACTUALIZAR</button>
            <button type="button" class="btn btn-primary btn-flat" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <a href="#!/products/" class="btn btn-danger btn-flat">REGRESAR</a>

            <!-- <button type="button" class="btn btn-success pull-right" ng-click="getProductDetail(product.id_producto)">Detalle del producto</button> -->
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Ficha Técnica</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmInfDoc" ng-submit="saveInfoDocument(product)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Subir Ficha Técnica (sólo PDF) *</label>
                    <input type="file" class="form-control" ngf-select ng-model="product.new_information" ngf-accept="'application/pdf'" required>
                </div>

            </div>         
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" ng-if="isDisabled" ng-disabled="frmInfDoc.$invalid == isDisabled">ACTUALIZAR</button>
            <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>

            <!-- <button type="button" class="btn btn-success pull-right" ng-click="getProductDetail(product.id_producto)">Detalle del producto</button> -->
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
