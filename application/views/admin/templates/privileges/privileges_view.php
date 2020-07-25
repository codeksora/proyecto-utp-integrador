<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Privilegios
    <small>Panel de administración de privilegios</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los privilegios</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de privilegios</h3>
          <a href="#!/privileges/add/" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Agregar privilegio</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div uib-alert ng-repeat="alert in alerts" class="alert" ng-class="'alert-' + (alert.status)" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
          <table datatable="ng" dt-options="dtOptions" dt-instance="dtInstance" class="table table-hover">
            <thead>
              <tr class="bg-primary">
                <th class="text-center">Rol</th>
                <th class="text-center">Menú</th>
                <th class="text-center">Leer</th>
                <th class="text-center">Insertar</th>
                <th class="text-center">Actualizar</th>
                <th class="text-center">Eliminar</th>
                <th class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="privilege in privileges">
                  <td>{{ privilege.role_name }}</td>
                  <td>{{ privilege.menu_name }}</td>
                  <td class="text-center">
                  <i ng-if="privilege.read == 1" class="fa fa-check text-primary"></i> 
                  <i ng-if="privilege.read == 0" class="fa fa-close text-danger"></i>
                </td>
                <td class="text-center">
                  <i ng-if="privilege.insert == 1" class="fa fa-check text-primary"></i> 
                  <i ng-if="privilege.insert == 0" class="fa fa-close text-danger"></i>
                </td>
                <td class="text-center">
                  <i ng-if="privilege.update == 1" class="fa fa-check text-primary"></i> 
                  <i ng-if="privilege.update == 0" class="fa fa-close text-danger"></i>
                </td>
                <td class="text-center">
                  <i ng-if="privilege.delete == 1" class="fa fa-check text-primary"></i> 
                  <i ng-if="privilege.delete == 0" class="fa fa-close text-danger"></i>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <button ng-click="getPrivilege(privilege.privilege_id)" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></button>
                    <a href="#!/privileges/{{ privilege.privilege_id }}/edit/" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                    <button ng-click="deletePrivilege($index, privilege.privilege_id)" class="btn btn-xs btn-default"><i class="fa fa-close"></i></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
