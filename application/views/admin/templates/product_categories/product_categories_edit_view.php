<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
    Categorías de producto
    <small>Panel de administración de categorías de producto</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/product-categories/">Todas las categorías</a></li>
    <li class="active">Editar categoría</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar categoría</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmProductCategory" ng-submit="save(product_category)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12 required">
  	                <label>Nombre</label>
  	                <input class="form-control" type="text" ng-model="product_category.name" required>
  	            </div>

          	</div>
            
            <div class="row">
	            <div class="form-group col-md-12">
              <label>Especificaciones técnicas</label>
                  <trix-editor angular-trix ng-model="product_category.technical_specifications"></trix-editor>
	            </div>
          	</div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat" ng-if="isDisabled" ng-disabled="frmProductCategory.$invalid == isDisabled">ACTUALIZAR</button>
            <button type="button" class="btn btn-primary btn-flat" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <a href="#!/product-categories/" class="btn btn-danger btn-flat">REGRESAR</a>

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
