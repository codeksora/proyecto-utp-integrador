<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Notificaciones
        <small>Panel de administración de notificaciones</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Todas las notificaciones</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de notificaciones</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table datatable=""
                           dt-options="dtOptionsNotifications"
                           dt-columns="dtColumnsNotifications"
                           dt-instance="dtInstanceNotifications"
                           class="table table-hover"></table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>