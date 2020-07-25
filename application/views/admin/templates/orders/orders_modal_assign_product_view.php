<div ng-if="product_type_id == 1">
  <div class="modal-header bg-blue">
    <button type="button" class="close" ng-click="closeModal()">
      <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>CERTIFICADOS SSL REGISTRADOS</strong></h4>
  </div>

  <div class="modal-body">
      <table datatable="" 
            dt-options="dtOptionsSslCerts" 
            dt-instance="dtInstanceSslCerts" 
            dt-columns="dtColumnsSslCerts"
            class="table table-hover table-bordered table-striped"></table>

      <div uib-alert ng-repeat="alert in alertsSslCerts" class="alert alert-danger" close="closeAlertSslCerts($index)"><span ng-bind-html="alert.message"></span></div>
    </div>



  <div class="modal-footer">
    <button type="button" class="btn btn-flat btn-primary" ng-if="isDisabledSslCerts" ng-click="assignSslCert(ssl_certificate_id)">ASIGNAR DOMINIO</button>
    <button type="button" class="btn btn-flat btn-primary" ng-if="!isDisabledSslCerts" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
      <button type="button" class="btn btn-default btn-flat pull-right" ng-click="closeModal()">CERRAR</button>
  </div>
</div>

<div ng-if="product_type_id == 2">
  <div class="modal-header bg-blue">
    <button type="button" class="close" ng-click="closeModal()">
      <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>FIRMAS REGISTRADAS</strong></h4>
  </div>

  <div class="modal-body">
      <table datatable=""
             dt-options="dtOptionsSignatureForms"
             dt-instance="dtInstanceSignatureForms"
             dt-columns="dtColumnsSignatureForms"
             class="table table-hover table-bordered table-striped"></table>

      <div uib-alert ng-repeat="alert in alertsSslCerts" class="alert alert-danger" close="closeAlertSslCerts($index)"><span ng-bind-html="alert.message"></span></div>
    </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-flat btn-primary" ng-if="isDisabledSignatures" ng-click="assignSignature(idpersonal)">ASIGNAR FIRMA</button>
    <button type="button" class="btn btn-flat btn-primary" ng-if="!isDisabledSignatures" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
      <button type="button" class="btn btn-default btn-flat pull-right" ng-click="closeModal()">CERRAR</button>
  </div>
</div>