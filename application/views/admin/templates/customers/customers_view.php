<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Clientes
    <small>Panel de administración de licencias</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los clientes</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de clientes</h3>
          <a ng-if="privileges.insert == 1" href="#!/customers/add/" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Agregar cliente</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table datatable=""
                 dt-options="dtOptionsCustomers"
                 dt-instance="dtInstanceCustomers"
                 dt-columns="dtColumnsCustomers"
                 class="table table-bordered table-hover"></table>
          
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>

