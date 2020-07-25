<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Clientes
    <small>Panel de administración de clientes</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/customers/">Todos los clientes</a></li>
    <li class="active">Añadir cliente</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar cliente</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmCustomer" ng-submit="add(customer)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2 required">
                    <label>Tipo de documento</label>
                    <select class="form-control" ng-model="customer.document_type_id" ng-options="document_type.id as document_type.name for document_type in document_types" required>
                        <option value="">Seleccionar</option>
                    </select>
                </div>

                <div class="form-group col-md-2 required">
                      <label>Número de documento</label>
                      <div class="input-group input-group-md">
                          <input type="text" class="form-control" ng-model="customer.document_number" required>
                          <span class="input-group-btn" ng-if="customer.document_type_id == 1">
                              <button type="button" class="btn btn-info btn-flat" ng-if="isDisabledSearch" ng-click="searchOnSunat(customer.document_number)"><i class="fa fa-search"></i></button>
                              <button type="button" class="btn btn-info btn-flat" ng-if="!isDisabledSearch" disabled><i class="fa fa-pulse fa-spinner"></i></button>
                          </span>
                      </div>
                </div>

                <div class="form-group col-md-5 optional">
                    <label>Nombre de la empresa</label>
                    <input class="form-control" type="text" ng-model="customer.name">
                </div>

                <div class="form-group col-md-3 optional">
                    <label>Sitio web</label>
                    <input class="form-control" type="text" ng-model="customer.website">
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col-md-6 required">
                    <label>Dirección 1</label>
                    <input class="form-control" type="text" ng-model="customer.address_line_1" required>
                </div>

                <div class="form-group col-md-6 optional">
                    <label>Dirección 2</label>
                    <input class="form-control" type="text" ng-model="customer.address_line_2">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3 required">
                    <label>Sector</label>
                    <oi-select
                          ng-model="customer.sector_id"
                          oi-options="sector.id as sector.name for sector in sectors"
                          placeholder="Seleccionar"
                          required>
                  </oi-select>
                </div>

                <div class="form-group col-md-9 optional">
                    <label>Dirección de envío</label>
                    <input class="form-control" type="text" ng-model="customer.shipping_address">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3 required">
                    <label>Código de país</label>
                    <oi-select
                    ng-model="customer.phone_code_id" 
                    oi-options="phone_code.id as (phone_code.country_name + '  +' + phone_code.code) for phone_code in phone_codes"
                    placeholder="Seleccionar"
                    required
                    ></oi-select>
                </div>

                <div class="form-group col-md-3 optional">
                    <label>Teléfono</label>
                    <input class="form-control" placeholder="Ej. 2659966" type="text" ng-model="customer.phone">
                </div>

                <div class="form-group col-md-3 optional">
                    <label>Celular</label>
                    <input class="form-control" placeholder="Ej. 999888777" type="text" ng-model="customer.mobile_phone">
                </div>

                <div class="form-group col-md-3 optional">
                    <label>Anexo</label>
                    <input class="form-control" placeholder="Ej. 265" type="text" ng-model="customer.extension">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4 required">
                    <label>País</label>

                    <oi-select
                          ng-model="customer.country_id"
                          oi-options="country.id as country.name for country in countries"
                          placeholder="Seleccionar"
                          required>
                  </oi-select>
                </div>

                <div class="form-group col-md-4 required">
                    <label>Estado</label>
                    <input class="form-control" type="text" ng-model="customer.state" required>
                </div>

                <div class="form-group col-md-4 required">
                    <label>Ciudad</label>
                    <input class="form-control" type="text" ng-model="customer.city" required>
                </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" ng-if="isDisabled" ng-disabled="frmCustomer.$invalid == isDisabled">Agregar</button>
            <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
            <a href="#!/customers/" class="btn btn-danger">Regresar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
