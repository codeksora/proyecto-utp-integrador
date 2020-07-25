<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> 
    Roles 
    <small>Panel de administración de roles</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los roles</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de roles</h3>
          <?php if($privileges->insert == 1): ?>
            <a href="#!/roles/add/" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Agregar rol</a>
          <?php endif; ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div uib-alert ng-repeat="alert in alerts" class="alert" ng-class="'alert-' + (alert.status)" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
          <table datatable="ng" dt-options="dtOptions" dt-instance="dtInstance" class="table table-hover">
            <thead>
              <tr class="bg-primary">
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="role in roles">
                  <td>{{ role.name }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <?php if($privileges->read == 1): ?>
                      <a href ng-click="getRole(role.id)" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                      <?php endif; ?>
                      <?php if($privileges->update == 1): ?>
                      <a href="#!/roles/{{ role.id }}/edit/" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                      <?php endif; ?>
                      <?php if($privileges->delete == 1): ?>
                      <a href ng-click="deleteRole($index, role.id)" class="btn btn-xs btn-default"><i class="fa fa-close"></i></a>
                      <?php endif; ?>
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

<div class="modal fade" id="modal-role">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Datos de {{ role.name }}</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <dl class="col-md-6">
            <dt>Nombre</dt>
            <dd>{{ role.name }}</dd>
          </dl>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

