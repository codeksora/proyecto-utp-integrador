<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Productos
    <small>Panel de administración de productos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Todos los productos</li>
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
                            <a ng-if="privileges.insert == 1" href="#!/products/add/" class="btn btn-flat bg-purple"><i class="fa fa-plus"></i> <strong>AGREGAR PRODUCTO</strong></a>
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
          <h3 class="box-title">Lista de productos</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Tipo de proveedor</label>
                            <oi-select
                                    ng-model="search.provider_name"
                                    ng-change="searchProduct(search)"
                                    oi-options="provider.name as provider.name for provider in providers"
                                    placeholder="Seleccionar">
                            </oi-select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Tipo de producto</label>
                            <oi-select
                                    ng-model="search.product_type_name"
                                    ng-change="searchProduct(search)"
                                    oi-options="product_type.name as product_type.name for product_type in product_types"
                                    placeholder="Seleccionar">
                            </oi-select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Rango de fecha de creación</label>
                            <input type="text" class="form-control"
                                   date-range-picker
                                   options="search.productDate.options"
                                   ng-model="search.productDate.date"
                                   ng-change="searchProduct(search)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table datatable=""
                           dt-options="dtOptionsProducts"
                           dt-columns="dtColumnsProducts"
                           dt-instance="dtInstanceProducts"
                           class="table table-hover"></table>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>