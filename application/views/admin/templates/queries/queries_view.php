<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Consultas
    <small>Panel de administración de productos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todas las connsultas</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Mostrando consultas</h3>
          <a ng-if="privileges.insert == 1" href="#!/products/add/" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Agregar producto</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
                <uib-tabset active="activeJustified" justified="true">
                    <uib-tab index="0" heading="Justified">Justified content</uib-tab>
                    <uib-tab index="1" heading="SJ">Short Labeled Justified content</uib-tab>
                    <uib-tab index="2" heading="Long Justified">Long Labeled Justified content</uib-tab>
                </uib-tabset>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>