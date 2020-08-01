<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Productos
    <small>Panel de administración de productos</small>
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
          <h3 class="box-title">Agregar producto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmProduct" ng-submit="add(product)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
	                <label>Proveedor *</label>
                  <oi-select
                          ng-model="product.provider_id"
                          oi-options="provider.id as provider.name for provider in providers"
                          placeholder="Seleccionar"
                          required>
                  </oi-select>
	            </div>

              <div class="form-group col-md-4">
	                <label>Tipo de producto *</label>
                  <oi-select
                          ng-model="product.product_type_id"
                          oi-options="product_type.id as product_type.name for product_type in product_types"
                          placeholder="Seleccionar"
                            required>
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
              <div class="form-group col-md-4">
                <label for="">¿Contiene SAN? (opcional)</label>
                <select class="form-control" ng-model="product.is_san" ng-disabled="product.quantity_year_id == 1 || !product.quantity_year_id">
                  <option value="">Seleccionar</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="">¿Contiene años? *</label>
                <select class="form-control" ng-options="quantity_year.id as quantity_year.name for quantity_year in quantity_years" ng-model="product.quantity_year_id" required>
                  <option value="">Seleccionar</option>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="">Ficha técnica</label>
                <input type="file" class="form-control" ngf-select ng-model="product.information" ngf-accept="'application/pdf'">
              </div>
            </div>

             <!-- Certificado SSL -->
             <div class="row">
                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 1">
                    <label>Precio dólares</label>
                    <input class="form-control" type="number" ng-model="product.price_1" min="1" max="99999" step=".01" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 2 || product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio dólares (1 año)</label>
                    <input class="form-control" type="number" ng-model="product.price_1_year" min="1" max="99999" step=".01" required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio dólares (2 años)</label>
                    <input class="form-control" type="number" ng-model="product.price_2_year"  min="1" max="99999" step=".01"required>
                </div>

                <div class="form-group col-md-4" ng-if="product.quantity_year_id == 4">
                    <label>Precio dólares (3 años)</label>
                    <input class="form-control" type="number" ng-model="product.price_3_year" min="1" max="99999" step=".01" required>
                </div>
               </div>
            <div class="row">
               <!-- PRECIO EN SOLES -->
               <div class="form-group col-md-4" ng-if="product.quantity_year_id == 1">
                    <label>Precio soles</label>
                    <input class="form-control" type="number" ng-model="product.price_pen_1" min="1" max="99999" step=".01" required>
                </div>
               
               <div class="form-group col-md-4" ng-if="product.quantity_year_id == 2 || product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio soles (1 año)</label>
                    <input class="form-control" type="number" ng-model="product.price_pen_1_year" min="1" max="99999" step=".01" required>
                </div>
               
               <div class="form-group col-md-4" ng-if="product.quantity_year_id == 3 || product.quantity_year_id == 4">
                    <label>Precio soles (2 años)</label>
                    <input class="form-control" type="number" ng-model="product.price_pen_2_year" min="1" max="99999" step=".01" required>
                </div>
               
               <div class="form-group col-md-4" ng-if="product.quantity_year_id == 4">
                    <label>Precio soles (3 años)</label>
                    <input class="form-control" type="number" ng-model="product.price_pen_3_year" min="1" max="99999" step=".01" required>
                </div>
            </div>

             <!-- Certificado SAN -->
             <div class="row" ng-if="product.is_san == 1">
                  <div class="col-md-12"><hr></div>
                  <div class="form-group col-md-3">
                      <label>Cant. SAN base</label>
                      <input class="form-control" type="number" ng-model="product.san_base" required>
                  </div>

                  <div class="form-group col-md-3">
                      <label>Cant. SAN máx.</label>
                      <input class="form-control" type="number" ng-model="product.san_max" required>
                  </div>
               
               <div class="col-md-12">
                <div class="row">
                  <div class="form-group col-md-3">
                      <label>Precio dólares SAN (1 año)</label>
                      <input class="form-control" type="number" ng-model="product.price_1_san" required>
                  </div>

                  <div class="form-group col-md-3" ng-if="product.quantity_year_id == 3 || product.quantity_year_id == 4">
                      <label>Precio dólares SAN (2 años)</label>
                      <input class="form-control" type="number" ng-model="product.price_2_san" required>
                  </div>
                 
                 </div>
                 
                 <div class="row">
                   <div class="form-group col-md-3">
                        <label>Precio soles SAN (1 año)</label>
                        <input class="form-control" type="number" ng-model="product.price_pen_1_san" required>
                    </div>

                    <div class="form-group col-md-3" ng-if="product.quantity_year_id == 3 || product.quantity_year_id == 4">
                        <label>Precio soles SAN (2 años)</label>
                        <input class="form-control" type="number" ng-model="product.price_pen_2_san" required>
                    </div>
                 </div>
               </div>

               
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat" ng-if="isDisabled" ng-disabled="frmProduct.$invalid == isDisabled">AGREGAR</button>
            <button type="button" class="btn btn-primary btn-flat" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <a href="#!/products/" class="btn btn-danger btn-flat">REGRESAR</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
