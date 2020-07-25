<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Usuarios
    <small>Panel de administración de usuarios</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los usuarios</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
      <div class="col-xs-12">
          <div class="box box-primary">
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="row">
                      <div class="col-md-12">
                      <a ng-if="privileges.insert == 1" href="#!/users/add/" class="btn btn-flat bg-purple"><i class="fa fa-plus"></i> <strong>AGREGAR USUARIO</strong></a>
                      </div>
                  </div>
              </div>
              <!-- /.box-body -->
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de usuarios</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <form ng-submit="searchUser(search)">
              <div class="row">
                  <div class="col-md-12">
                      <div class="row">
                          <div class="form-group col-md-4">
                              <label>Buscar</label>
                              <input type="text" class="form-control"
                                      ng-model="search.q">
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-success">Filtrar búsqueda</button>
                        </div>
                      </div>
                  </div>
            </div>
          </form>

          <div class="row">
            <div class="col-xs-12">
              <table datatable=""
                  dt-options="dtOptionsUsers"
                  dt-instance="dtInstanceUsers"
                  dt-columns="dtColumnsUsers"
                  class="table table-hover table-bordered"></table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
