<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Proveedores
    <small>Panel de administración de proveedores</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/users/">Todos los proveedores</a></li>
    <li class="active">Editar proveedor</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar usuario</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmProvider" ng-submit="save(provider)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
                  <label>Nombre *</label>
                  <input class="form-control" type="text" ng-model="provider.name" required>
              </div>

              <div class="form-group col-md-4">
                  <label>Teléfono (opcional)</label>
                  <input class="form-control" type="text" ng-model="provider.phone">
              </div>

              <div class="form-group col-md-4">
                  <label>Correo electrónico (opcional)</label>
                  <input class="form-control" type="email" ng-model="provider.email">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-4">
                  <label>Sitio web *</label>
                  <input class="form-control" type="text" ng-model="provider.website" required>
              </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat" ng-if="isDisabledProviders" ng-disabled="frmProvider.$invalid == isDisabledProviders">ACTUALIZAR</button>
            <button type="button" class="btn btn-primary btn-flat" ng-if="!isDisabledProviders" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <a href="#!/providers/" class="btn btn-danger btn-flat">REGRESAR</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
