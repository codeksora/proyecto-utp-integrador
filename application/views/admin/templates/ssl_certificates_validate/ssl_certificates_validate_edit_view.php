<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Productos
    <small>Panel de administración de productos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/products/">Todos los productos</a></li>
    <li class="active">Editar producto</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detalle del CSR</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
          <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-header"><i class="fa fa-list"></i> Lista de Productos solicitados</h4>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table datatable=""
                    dt-options="dtOptionsSslCertsAssigned"
                    dt-instance="dtInstanceSslCertsAssigned"
                    dt-columns="dtColumnsSslCertsAssigned"
                    class="table table-hover table-bordered"></table>
              </div>              
            </div>

            <div class="row">
              <div class="col-md-12">
                <h4 class="page-header"><i class="fa fa-shopping-cart"></i> Detalles del Producto</h4>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="">Concepto</label>
                <input type="text" ng-value="ssl_cert.accion" class="form-control" disabled>
              </div>  

              <div class="form-group col-md-3">
                <label for="">Tiempo</label>
                <input type="text" ng-value="ssl_cert.periodo" class="form-control" disabled>
              </div>  

              <div class="form-group col-md-3">
                <label for="">Producto</label>
                <input type="text" ng-value="ssl_cert.producto" class="form-control" disabled>
              </div>  

              <div class="form-group col-md-3">
                <label for="">Cantidad</label>
                <input type="text" ng-value="ssl_cert.cantservidor" class="form-control" disabled>
              </div>  
            </div>

            <div class="row">
              <div class="col-md-12">
                <h4 class="page-header"><i class="fa fa-archive"></i> Información del CSR</h4>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-3">
                <label for="">Common name</label>
                <input type="text" ng-value="ssl_cert.CommonName_CSR" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Organización</label>
                <input type="text" ng-value="ssl_cert.Organizacion_CSR" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">U. Organizac</label>
                <input type="text" ng-value="ssl_cert.UnidadOrganizacion_CSR" class="form-control" disabled>
              </div>
            <div class="form-group col-md-3">
                <label for="">Localidad</label>
                <input type="text" ng-value="ssl_cert.Ciudad_CSR" class="form-control" disabled>
              </div>
            </div>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="">Estado</label>
                <input type="text" ng-value="ssl_cert.Estado_CSR" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">País</label>
                <input type="text" ng-value="ssl_cert.Pais_CSR" class="form-control" disabled>
              </div>
              
              <div class="form-group col-md-3">
                <label for="">Código Postal</label>
                <input type="text" ng-value="ssl_cert.codPostal_cli" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Key</label>
                <input type="text" ng-value="ssl_cert.Key_CSR" class="form-control" disabled>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-12">
                  <textarea cols="30" rows="20" class="form-control" disabled>{{ ssl_cert.Desc_csr }}</textarea>
              </div>
            </div>   

            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
                    <tr class="bg-yellow">
                      <th>Nombres</th>
                      <th>Correo</th>
                      <th>Cargo</th>
                      <th>Telf.</th>
                      <th>Anx.</th>
                      <th>País</th>
                      <th>Prov</th>
                      <th>Ciudad</th>
                      <th>Dirección</th>
                      <th>Postal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ ssl_cert.nombreSSL_Adm }} {{ ssl_cert.apellidoSSL_Adm }}</td>
                      <td>{{ ssl_cert.mailSSL_Adm }}</td>
                      <td>{{ ssl_cert.cargoSSL_Adm }}</td>
                      <td>{{ ssl_cert.telOfSSL_Adm }}</td>
                      <td>{{ ssl_cert.anexoSSL_Adm }}</td>
                      <td>{{ ssl_cert.paisSSL_Adm }}</td>
                      <td>{{ ssl_cert.provSSL_Adm }}</td>
                      <td>{{ ssl_cert.ciudadSSL_Adm }}</td>
                      <td>{{ ssl_cert.direccionSSL_Adm }}</td>
                      <td>{{ ssl_cert.codPostalSSL_Adm }}</td>
                    </tr>

                    <tr>
                      <td>{{ ssl_cert.nombreSSL_Tec }} {{ ssl_cert.apellidoSSL_Tec }}</td>
                      <td>{{ ssl_cert.mailSSL_Tec }}</td>
                      <td>{{ ssl_cert.cargoSSL_Tec }}</td>
                      <td>{{ ssl_cert.telOfSSL_Tec }}</td>
                      <td>{{ ssl_cert.anexoSSL_Tec }}</td>
                      <td>{{ ssl_cert.paisSSL_Tec }}</td>
                      <td>{{ ssl_cert.provSSL_Tec }}</td>
                      <td>{{ ssl_cert.ciudadSSL_Tec }}</td>
                      <td>{{ ssl_cert.direccionSSL_Tec }}</td>
                      <td>{{ ssl_cert.codPostalSSL_Tec }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>         
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" ng-if="isDisabled" ng-disabled="frmSslCertValidate.$invalid == isDisabled" ng-click="save(ssl_cert)">Validar certificado SSL</button>
            <button type="button" class="btn btn-primary" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
            <a href="#!/ssl-certificates-validate/" class="btn btn-danger">Regresar</a>

            <!-- <button type="button" class="btn btn-success pull-right" ng-click="getProductDetail(product.id_producto)">Detalle del producto</button> -->
          </div>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
