<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Certificados SSL asignados
        <small>Panel de administración de certificados SSL asignados</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Todos los certificados SSL asignados</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de certificados SSL asignados</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <form ng-submit="searchSslCertificateAssigned(search)">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Estado</label>
                                <select class="form-control" 
                                        ng-options="ssl_cert_st.id as ssl_cert_st.name for ssl_cert_st in ssl_cert_status"
                                        ng-model="search.ssl_certificate_status_id">
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>

                            <!-- <div class="form-group col-md-4">
                                <label>Tipo de producto</label>
                                <select class="form-control" 
                                        ng-options="product_type.name as product_type.name for product_type in product_types"
                                        ng-model="search.product_type_name">
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Rango de fecha de creación</label>
                                <input type="text" class="form-control" 
                                        date-range-picker 
                                        options="search.productDate.options"
                                        ng-model="search.productDate.date">
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Filtrar</button>
                            </div>
                        </div>
                    </form>
                    <table datatable=""
                            dt-options="dtOptionsSslCertsAssigned"
                            dt-columns="dtColumnsSslCertsAssigned"
                            dt-instance="dtInstanceSslCertsAssigned"
                            class="table table-hover"></table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
