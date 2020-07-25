<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Roles
    <small>Panel de administración de usuarios</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/roles/">Todos los roles</a></li>
    <li class="active">Añadir role</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar rol</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmRole" ng-submit="add(role)" novalidate="novalidate">
          <div class="box-body">
            <div uib-alert ng-repeat="alert in alerts" class="alert" ng-class="'alert-' + (alert.status)" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
            <div class="row">
              <div class="form-group col-md-4">
                  <label>Nombre</label>
                  <input class="form-control" placeholder="Ingresar nombre" type="text" ng-model="role.name" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Menú</th>
                      <th>Leer</th>
                      <th>Insertar</th>
                      <th>Actualizar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="menu in role.menus">
                      <td>{{ menu.name }}</td>
                      <td><input type="checkbox" ng-model="menu.read" ng-init="menu.read = true" checked></td>
                      <td><input type="checkbox" ng-model="menu.insert" ng-init="menu.insert = true" checked></td>
                      <td><input type="checkbox" ng-model="menu.update" ng-init="menu.update = true" checked></td>
                      <td><input type="checkbox" ng-model="menu.delete" ng-init="menu.delete = true" checked></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" ng-show="isDisabled" ng-disabled="frmRole.$invalid == isDisabled">Agregar</button>
            <button type="button" class="btn btn-primary" ng-hide="isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
            <a href="#!/roles/" class="btn btn-danger">Regresar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
