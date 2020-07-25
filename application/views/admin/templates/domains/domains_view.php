<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dominios
    <small>Panel de administración de dominios</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los dominios</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de dominios</h3>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                <button ng-if="privileges.insert == 1" ng-click="addDomain()" class="btn btn-sm bg-maroon"><strong><i class="fa fa-plus"></i> AGREGAR DOMINIO</strong></button>
                </div>
                <hr>
            </div>
          <table datatable=""
                 dt-options="dtOptionsDomains"
                 dt-instance="dtInstanceDomains"
                 dt-columns="dtColumnsDomains"
                 class="table table-bordered table-hover"></table>
          
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>

