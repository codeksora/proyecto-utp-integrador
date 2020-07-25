<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Ordenes
    <small>Panel de administración de ordenes</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/orders/">Todas las ordenes</a></li>
    <li class="active">Asignar a la orden</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ order.name }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- <div uib-alert ng-repeat="alert in alerts" class="alert" ng-class="'alert-' + (alert.status)" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div> -->
          <div class="row">
            <div class="col-md-12">
              <p class="text-center"><strong>Lista de productos</strong></p>
              <table class="table table-bordered"
                     datatable=""
                     dt-options="dtOptionsOrderProducts"
                     dt-columns="dtColumnsOrderProducts"
                     dt-instance="dtInstanceOrderProducts"></table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de certificados SSL ya asignados a la orden</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered"
                     datatable=""
                     dt-options="dtOptionsSslCertsAssigned"
                     dt-columns="dtColumnsSslCertsAssigned"
                     dt-instance="dtInstanceSslCertsAssigned"></table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>

    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de firmas asignadas a la orden</h3>
        </div>


        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
            	<table class="table table-bordered"
                     datatable=""
                     dt-options="dtOptionsSignaturesAssigned"
                     dt-columns="dtColumnsSignaturesAssigned"
                     dt-instance="dtInstanceSignaturesAssigned"></table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
