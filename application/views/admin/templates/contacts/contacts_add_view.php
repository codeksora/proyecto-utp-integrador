<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Contactos
    <small>Panel de administración de contactos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/contacts/">Todos los contactos</a></li>
    <li class="active">Añadir contacto</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar contacto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form name="frmContact" ng-submit="add(contact)" novalidate="novalidate">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4 required">
                  <label>Nombre</label>
                  <input class="form-control" type="text" ng-model="contact.first_name" required>
              </div>

              <div class="form-group col-md-4 required">
                  <label>Apellido</label>
                  <input class="form-control" type="text" ng-model="contact.last_name" required>
              </div>

              <div class="form-group col-md-4 required">
                  <label>Correo electrónico</label>
                  <input class="form-control" placeholder="Ej. micorreo@perumedia.com.pe" type="email" ng-model="contact.email" required>
              </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3 required">
                    <label>Código de país</label>
                    <oi-select
                    ng-model="contact.phone_code_id" 
                    oi-options="phone_code.id as (phone_code.country_name + '  +' + phone_code.code) for phone_code in phone_codes"
                    placeholder="Seleccionar"
                    required
                    ></oi-select>
                </div>

                <div class="form-group col-md-3 optional">
                    <label>Teléfono</label>
                    <input class="form-control" placeholder="Ej. 2659966" type="text" ng-model="contact.phone">
                </div>

                <div class="form-group col-md-3 optional">
                    <label>Celular</label>
                    <input class="form-control" placeholder="Ej. 999888777" type="text" ng-model="contact.mobile_phone">
                </div>

                <div class="form-group col-md-3 optional">
                    <label>Anexo</label>
                    <input class="form-control" placeholder="Ej. 265" type="text" ng-model="contact.extension">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4 required">
                    <label>País</label>
                    <oi-select
                          ng-model="contact.country_id"
                          oi-options="country.id as country.name for country in countries"
                          placeholder="Seleccionar"
                          required>
                  </oi-select>
                </div>

                <div class="form-group col-md-4 required">
                    <label>Estado</label>
                    <input class="form-control" placeholder="Ej. Lima, La libertad, Tacna" type="text" ng-model="contact.state" required>
                </div>

                <div class="form-group col-md-4 required">
                    <label>Ciudad</label>
                    <input class="form-control" placeholder="Ej. Trujillo, Huacho, Chimbote" type="text" ng-model="contact.city" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6 required">
                    <label>Dirección 1</label>
                    <input class="form-control" placeholder="Ej. Av. 28 de Julio 174" type="text" ng-model="contact.address_line_1" required>
                </div>

                <div class="form-group col-md-6 optional">
                    <label>Dirección 2</label>
                    <input class="form-control" placeholder="Ej. Cercado de Lima, Surco" type="text" ng-model="contact.address_line_2">
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col-md-4 required">
                    <label>Empresa</label>

                    <oi-select
                            ng-model="contact.customer_id"
                            oi-options="customer.id as customer.name for customer in customers.data | limitTo: 10"
                            ng-change="getCustomer(contact.customer_id)"
                            placeholder="Seleccionar"
                            required></oi-select>
                </div>

                <div class="form-group col-md-4 required">
                    <label>Cargo</label>
                    <input class="form-control" placeholder="Ej. Analista programador, Soporte" type="text" ng-model="contact.job_title" required>
                </div>

                <div class="form-group col-md-4 required">
                    <label>Tipo de contacto</label>
                    <oi-select
                            ng-model="contact.contact_type_id"
                            oi-options="contact_type.id as contact_type.name for contact_type in contact_types"
                            placeholder="Seleccionar"
                            required></oi-select>
                </div>
            </div>

            
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" ng-if="isDisabled" ng-disabled="frmContact.$invalid == isDisabled" class="btn btn-primary" ng-disabled="disable">Agregar</button>
            <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
            <a href="#!/contacts/" class="btn btn-danger">Regresar</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
