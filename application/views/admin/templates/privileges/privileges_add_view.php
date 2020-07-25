<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Privilegios
    <small>Panel de administración de privilegios</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/privileges/">Todos los privilegios</a></li>
    <li class="active">Añadir privilegio</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar privilegio</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmPrivilege" ng-submit="add(privilege)" novalidate="novalidate">
          <div class="box-body"> 
          <div class="box-body"> 
          <div uib-alert ng-repeat="alert in alerts" class="alert" ng-class="'alert-' + (alert.status)" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
            <div class="row">
              <div class="form-group col-md-6">
                  <label>Menú</label>
                  <select class="form-control" ng-options="menu.id as menu.name for menu in menus" ng-model="privilege.menu_id" required>
                    <option value="">Seleccionar</option>
                  </select>
              </div>

              <div class="form-group col-md-6">
                  <label>Rol</label>
                  <select class="form-control" ng-options="role.id as role.name for role in roles" ng-model="privilege.role_id" required>
                    <option value="">Seleccionar</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                  <label>Leer</label>
                  <div class="radio">
                    <label>
                      <input type="radio" ng-model="privilege.read" value="1" required>
                      Si
                    </label>
                    <label>
                      <input type="radio" ng-model="privilege.read" value="0" required>
                      No
                    </label>
                  </div>
              </div>

              <div class="form-group col-md-6">
                  <label>Insertar</label>
                  <div class="radio">
                    <label>
                      <input type="radio" ng-model="privilege.insert" value="1" required>
                      Si
                    </label>
                    <label>
                      <input type="radio" ng-model="privilege.insert" value="0" required>
                      No
                    </label>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                  <label>Actualizar</label>
                  <div class="radio">
                    <label>
                      <input type="radio" ng-model="privilege.update" value="1" required>
                      Si
                    </label>
                    <label>
                      <input type="radio" ng-model="privilege.update" value="0" required>
                      No
                    </label>
                  </div>
              </div>

              <div class="form-group col-md-6">
                  <label>Eliminar</label>
                  <div class="radio">
                    <label>
                      <input type="radio" ng-model="privilege.delete" value="1" required>
                      Si
                    </label>
                    <label>
                      <input type="radio" ng-model="privilege.delete" value="0" required>
                      No
                    </label>
                  </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
          <button type="submit" class="btn btn-primary" ng-show="isDisabled" ng-disabled="frmPrivilege.$invalid == isDisabled">Agregar</button>
            <button type="button" class="btn btn-primary" ng-hide="isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
            <a href="#!/privileges/" class="btn btn-danger">Regresar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
