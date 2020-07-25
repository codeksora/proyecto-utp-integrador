<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Certificados SSL del formulario
    <small>Panel de administración de certificados SSL del formulario</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los certificados SSL del formulario</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de certificados SSL</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table datatable=""
                dt-options="dtOptionsSslCertsValidate"
                dt-instance="dtInstanceSslCertsValidate"
                dt-columns="dtColumnsSslCertsValidate"
                class="table table-hover table-bordered"></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
