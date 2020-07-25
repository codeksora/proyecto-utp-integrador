<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Proveedores
    <small>Panel de administración de proveedores</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los proveedores</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a ng-if="privileges.insert == 1" href="#!/providers/add/" class="btn btn-flat bg-purple"><i class="fa fa-plus"></i> <strong>AGREGAR PROVEEDOR</strong></a>

                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de proveedores</h3>
        </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <table datatable=""
                           dt-options="dtOptionsProviders"
                           dt-instance="dtInstanceProviders"
                           dt-columns="dtColumnsProviders"
                           class="table table-hover table-bordered"></table>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
