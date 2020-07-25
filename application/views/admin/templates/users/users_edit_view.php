<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Usuarios
    <small>Panel de administración de usuarios</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/users/">Todos los usuarios</a></li>
    <li class="active">Editar usuario</li>
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
        <form name="frmUser" ng-submit="save(user)" novalidate="novalidate">
          <div class="box-body">

          	<div class="row">
          		<div class="form-group col-md-4">
	                <label>Nombre</label>
	                <input class="form-control" type="text" ng-model="user.full_name" required>
	            </div>

	            <div class="form-group col-md-4">
	                <label>Nombre de usuario</label>
	                <input class="form-control" type="text" ng-model="user.username" required>
	            </div>

              <div class="form-group col-md-4">
	                <label>Email</label>
	                <input class="form-control" type="email" ng-model="user.email" required>
	            </div>
          	</div>

            <div class="row">
              <div class="form-group col-md-4">
                  <label>Cargo en la empresa</label>
                  <input class="form-control" type="text" ng-model="user.job_title" required>
              </div>

              <div class="form-group col-md-4">
                  <label>Anexo</label>
                  <input class="form-control" type="text" ng-model="user.extension" required>
              </div>

              <div class="form-group col-md-4">
                <label>Tipo de rol</label>
                <select class="form-control" ng-options="role.id as role.name for role in roles" ng-model="user.role_id" required>
                  <option value="">Seleccionar</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-4">
                  <label>Nueva Contraseña</label>
                  <input class="form-control" type="password" ng-model="user.password">
                  <p class="help-block">Dejar en blanco si no se desea cambiar la contraseña</p>
              </div>
          	</div>
            
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" ng-if="isDisabled" ng-disabled="frmUser.$invalid == isDisabled">Actualizar</button>
            <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
            <a href="#!/users/" class="btn btn-danger">Regresar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
