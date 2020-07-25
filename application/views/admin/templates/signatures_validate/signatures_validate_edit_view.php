<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Firmas del formulario
    <small>Panel de administración de firmas del formulario</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#!/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#!/signatures-validate/">Todas las firmas del formulario</a></li>
    <li class="active">Editar firma</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">VALIDAR SOLICITUD FIRMA PERSONAL</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <h4 class="page-header"><i class="fa fa-shopping-cart"></i> Detalles del Producto</h4>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="">Producto</label>
                <input type="text" ng-value="signature.persdescproducto" class="form-control" disabled>
              </div>  

              <div class="form-group col-md-3">
                <label for="">Acción</label>
                <input type="text" ng-value="signature.persaccionproducto" class="form-control" disabled>
              </div>  

              <div class="form-group col-md-3">
                <label for="">Tiempo (Años)</label>
                <input type="text" ng-value="signature.perstiempoproducto" class="form-control" disabled>
              </div>  


              <div class="form-group col-md-3">
                <label for="">Solicitud de token</label>
                <input type="text" ng-value="signature.perssolicitatoken" class="form-control" disabled>
              </div>  
            </div>

            <div class="row">
              <div class="col-md-12">
                <h4 class="page-header"><i class="fa fa-archive"></i> Datos de la Organización</h4>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-4">
                <label for="">Organización</label>
                <input type="text" ng-value="signature.persempresauser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">RUC</label>
                <div class="input-group input-group-md">
	                <input type="text" class="form-control" ng-value="signature.persempresaruc" disabled>
	                    <span class="input-group-btn">
	                      <button type="button" class="btn btn-info btn-flat" ng-click="verifyRUC(signature.persempresaruc)"><i class="fa fa-search"></i></button>
	                    </span>
	              </div>
              </div>

              <div class="form-group col-md-4">
                <label for="">Representante Legal</label>
                <input type="text" ng-value="signature.persrepresentante" class="form-control" disabled>
              </div>
            </div>

			<div class="row">
              <div class="col-md-12">
                <h4 class="page-header"><i class="fa fa-archive"></i> Datos del Usuario de Firma</h4>
              </div>
            </div>

            <div class="row">
        	  <div class="form-group col-md-4">
                <label for="">Nombres</label>
                <input type="text" ng-value="signature.persnombreuser + ' ' + signature.persapellidouser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">Tipo Documento</label>
                <input type="text" ng-value="signature.perstipodocuser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">Nº Documento</label>
                <input type="text" ng-value="signature.persnrodocuser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">E-mail</label>
                <input type="text" ng-value="signature.persmailuser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">Cargo</label>
                <input type="text" ng-value="signature.perscargouser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">Área</label>
                <input type="text" ng-value="signature.persareauser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">Teléfono</label>
                <input type="text" ng-value="signature.perstelefuser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">Móvil</label>
                <input type="text" ng-value="signature.persmoviluser" class="form-control" disabled>
              </div>

              <div class="form-group col-md-4">
                <label for="">Anexo</label>
                <input type="text" ng-value="signature.persanexouser" class="form-control" disabled>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <h4 class="page-header"><i class="fa fa-archive"></i> Datos de Pago</h4>
              </div>
            </div>   

            <div class="row">
			  <div class="form-group col-md-3">
                <label for="">Tipo de Pago</label>
                <input type="text" ng-value="signature.pagopersnrocuenta" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Banco</label>
                <input type="text" ng-value="signature.pagopersbanco" class="form-control" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="">Empresa</label>
                <input type="text" ng-value="signature.pagopersempresaord" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Nº de Operación</label>
                <input type="text" ng-value="signature.pagopersnrooperacion" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Nº de Pedido</label>
                <input type="text" ng-value="signature.pagopersnropedido" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Moneda</label>
                <input type="text" ng-value="signature.pagopersmoneda" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Fecha</label>
                <input type="text" ng-value="signature.pagodatepicker1" class="form-control" disabled>
              </div>

              <div class="form-group col-md-3">
                <label for="">Importe</label>
                <input type="text" ng-value="signature.pagopersimporte" class="form-control" disabled>
              </div>
			</div>

			<div class="row">
              <div class="col-md-12">
                <h4 class="page-header"><i class="fa fa-archive"></i> Datos del contacto enviado</h4>
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
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ signature.persnombrecontacto }}</td>
                      <td>{{ signature.persmailcontacto }}</td>
                      <td>{{ signature.perscargocontacto }}</td>
                      <td>{{ signature.perstelefcontacto }}</td>
                      <td>{{ signature.persanexocontacto }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>         
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="button" class="btn btn-primary btn-flat" ng-if="isDisabled" ng-click="save(signature)">VALIDAR FIRMA</button>
            <button type="button" class="btn btn-primary btn-flat" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <a href="#!/signatures-validate/" class="btn btn-danger btn-flat">REGRESAR</a>

            <!-- <button type="button" class="btn btn-success pull-right" ng-click="getProductDetail(product.id_producto)">Detalle del producto</button> -->
          </div>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->
  </div>
</section>
<!-- /.content -->
