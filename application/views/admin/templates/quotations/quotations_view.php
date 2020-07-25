<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Cotizaciones
    <small>Panel de administración de cotizaciones</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todas las cotizaciones</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <a ng-if="privileges.insert == 1" href="#!/quotations/add/" class="btn bg-purple btn-flat"><strong><i class="fa fa-plus"></i> AGREGAR COTIZACIÓN</strong></a>
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
          <h3 class="box-title">Lista de cotizaciones</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table datatable=""
                     dt-options="dtOptionsQuotations"
                     dt-columns="dtColumnsQuotations"
                     dt-instance="dtInstanceQuotations"
                     class="table table-hover"></table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
