<div class="modal-header bg-yellow">
  <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title"><strong>DETALLES DE PRODUCTOS ASIGNADOS</strong></h4>
</div>

<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-chevron-circle-right"></i> SSL asignados a la orden</h3>
            </div>
            <div class="box-body">
              <table datatable="ng" dt-options="dtOptionsCertSsl" dt-instance="dtInstanceCertSsl" class="table table-hover table-bordered table-striped">
                  <thead>
                      <tr>
                          <th>Common Name</th>
                          <th>Producto</th>
                          <th>Estado</th>
                          <th>Emision</th>
                          <th>Vencimiento</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr ng-repeat="(key, ssl_cert_assigned) in ssl_certs_assigned">
                          <td>{{ ssl_cert_assigned.common_name }}</td>
                          <td>{{ ssl_cert_assigned.product_name }}</td>
                          <td><span class="label bg-{{ ssl_cert_assigned.ssl_certificate_status_class }}">{{ ssl_cert_assigned.ssl_certificate_status_name }}</span></td>
                          <td>{{ ssl_cert_assigned.issue_date | date: "dd/MM/yyyy" : 'UTC' }}</td>
                          <td>{{ ssl_cert_assigned.expiration_date | date: "dd/MM/yyyy" : 'UTC' }}</td>
                      </tr>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-header">
          <h3 class="box-title"><i class="fa fa-chevron-circle-right"></i> Firmas asignadas a la orden</h3>
          </div>
          <div class="box-body">
              <table datatable="ng" dt-options="dtOptionsFirms" dt-instance="dtInstanceFirms" class="table table-hover table-bordered">
                  <thead>
                      <tr>
                          <th>Usuario</th>
                          <th>Correo</th>
                          <th>Producto</th>
                          <th>Estado</th>
                          <th>Emision</th>
                          <th>Vencimiento</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                      <tr ng-repeat="(key, signature_assigned) in signatures_assigned">
                          <td>{{ signature_assigned.persnombreuser }}</td>
                          <td>{{ signature_assigned.persmailuser }}</td>
                          <td>{{ signature_assigned.product_name }}</td>
                          <td><span class="label bg-{{ signature_assigned.signature_assigned_status_class }}">{{ signature_assigned.signature_status_name }}</span></td>
                          <td>{{ signature_assigned.issue_date | date: 'dd/MM/yyyy' }}</td>
                          <td>{{ signature_assigned.expiration_date | date: 'dd/MM/yyyy' }}</td>
                      </tr>
                  </tbody>
              </table>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default btn-flat pull-right" ng-click="closeModal()">CERRAR</button>
</div>