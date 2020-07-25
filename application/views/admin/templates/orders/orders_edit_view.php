<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Ordenes
    <small>Panel de administración de ordenes</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/orders/">Todas las ordenes</a></li>
    <li class="active">Editar orden</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar orden</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmOrder" ng-submit="save(order)" novalidate="novalidate">
          <div class="box-body">
          	<div class="row">
          		<div class="form-group col-md-4">
	                <label>Nº Orden externa</label>
	                <input class="form-control" type="text" ng-model="order.customer_order_number">
	            </div>
				
				<div class="form-group col-md-4">
	                <label>Nº Factura</label>
	                <input class="form-control" type="text" ng-model="order.invoice_number">
	            </div>
          	</div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" ng-disabled="disable">Actualizar</button>
            <a href="#!/orders/" class="btn btn-danger">Cancelar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
