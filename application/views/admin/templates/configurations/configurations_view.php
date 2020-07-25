<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Configuración
    <small>Panel de administración de configuración</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Configuración</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar la configuración del sistema</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmConfig" ng-submit="edit(config)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
                  <label>Nombre de la aplicación</label>
                  <input class="form-control" type="text" ng-model="config.application" required>
              </div>

              <div class="form-group col-md-4">
                  <label>Año</label>
                  <input class="form-control" type="text" ng-model="config.year" required>
              </div>

              <div class="form-group col-md-4">
                  <label>URL Web</label>
                  <input class="form-control" type="text" ng-model="config.web" required>
              </div>

              <div class="form-group col-md-4">
                  <label>Empresa</label>
                  <input class="form-control" type="text" ng-model="config.company" required>
              </div>

              <div class="form-group col-md-4">
                  <label>IGV</label>
                  <input class="form-control" type="text" ng-model="config.igv" required>
              </div>

             <div class="form-group col-md-4">
                 <label>Tipo cambio (compra)</label>
                 <input class="form-control" type="text" ng-value="config.buy" disabled>
             </div>

             <div class="form-group col-md-4">
                 <label>Tipo cambio (venta)</label>
                 <input class="form-control" type="text" ng-value="config.sell" disabled>
             </div>

                <div class="form-group col-md-4">
                    <label>RUC de la empresa (Sólo es referencial)</label>
                    <input class="form-control" type="text" ng-model="config.ruc_ps" required>
                </div>

                <div class="form-group col-md-4">
                    <label>Nombre de la empresa (Sólo es referencial)</label>
                    <input class="form-control" type="text" ng-model="config.name_ps" required>
                </div>

                <div class="form-group col-md-8">
                    <label>Dirección de la empresa (Sólo es referencial)</label>
                    <input class="form-control" type="text" ng-model="config.address_ps" required>
                </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" ng-if="isDisabled" ng-disabled="frmConfig.$invalid == isDisabled">Guardar cambios</button>
            <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
