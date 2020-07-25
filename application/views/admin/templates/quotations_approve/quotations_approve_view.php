<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Cotizaciones por aprobar
    <small>Panel de administración de cotizaciones por aprobar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todas las cotizaciones por aprobar</li>
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
              <button typ="button" class="btn btn-flat btn-danger" ng-click="approveAllQuotations()"><strong>APROBAR TODOS</strong></button>
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
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table datatable=""
                     dt-options="dtOptionsQuotationsApprove"
                     dt-columns="dtColumnsQuotationsApprove"
                     dt-instance="dtInstanceQuotationsApprove"
                     class="table table-hover"></table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
