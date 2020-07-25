<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Ordenes
    <small>Panel de administración de ordenes</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todas las ordenes</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de ordenes</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table datatable=""
                 dt-options="dtOptionsOrders"
                 dt-columns="dtColumnsOrders"
                 dt-instance="dtInstanceOrders"
                 class="table table-hover"></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
