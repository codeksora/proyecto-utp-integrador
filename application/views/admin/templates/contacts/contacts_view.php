<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Contactos
    <small>Panel de administración de contactos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los contactos</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de contactos</h3>
          <a ng-if="privileges.insert == 1" href="#!/contacts/add/" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Agregar contacto</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table datatable=""
                 dt-options="dtOptionsContacts"
                 dt-instance="dtInstanceContacts"
                 dt-columns="dtColumnsContacts"
                 class="table table-hover"></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>