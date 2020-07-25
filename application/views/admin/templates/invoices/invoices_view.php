<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Privilegios
        <small>Panel de administración de las facturas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Todas las facturas</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de facturas</h3>
                    <!-- <a href="#!/invoices/add/" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Agregar privilegio</a> -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table datatable=""
                           dt-options="dtOptionsInvoices"
                           dt-instance="dtInstanceInvoices"
                           dt-columns="dtColumnsInvoices"
                           class="table table-hover"></table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
