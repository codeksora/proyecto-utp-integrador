<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Certificados SSL
        <small>Panel de administración de certificados SSL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Todos los certificados SSL</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de certificados SSL</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button ng-if="privileges.insert == 1" ng-click="assignDomainToCustomer()" class="btn btn-sm bg-navy"><strong><i class="fa fa-plus"></i> ASIGNAR DOMINIO A CLIENTE</strong></button>
                            <button ng-if="privileges.insert == 1" ng-click="addDomain()" class="btn btn-sm bg-maroon"><strong><i class="fa fa-plus"></i> AGREGAR DOMINIO</strong></button>
                        </div>
                        <hr>
                    </div>
                    <table datatable=""
                            dt-options="dtOptionsSslCerts"
                            dt-columns="dtColumnsSslCerts"
                            dt-instance="dtInstanceSslCerts"
                            class="table table-hover"></table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
