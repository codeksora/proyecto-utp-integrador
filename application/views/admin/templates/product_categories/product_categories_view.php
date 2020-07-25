<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Categorías de producto
    <small>Panel de administración de categorías de producto</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todas las categorías</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-body">
        <a ng-if="privileges.insert == 1" href="#!/product-categories/add/" class="btn btn-flat bg-purple"><i class="fa fa-plus"></i> <strong>AGREGAR CATEGORÍA</strong></a>
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
          <table datatable=""
                 dt-options="dtOptionsProductCategories"
                 dt-instance="dtInstanceProductCategories"
                 dt-columns="dtColumnsProductCategories"
                 class="table table-hover"></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>