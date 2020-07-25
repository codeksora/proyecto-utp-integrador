<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Firmas del formulario
    <small>Panel de administración de firmas del formulario</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todas firmas del formulario</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de firmas del formulario</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table datatable=""
                dt-options="dtOptionsSignaturesValidate"
                dt-instance="dtInstanceSignaturesValidate"
                dt-columns="dtColumnsSignaturesValidate"
                class="table table-hover table-bordered"></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
