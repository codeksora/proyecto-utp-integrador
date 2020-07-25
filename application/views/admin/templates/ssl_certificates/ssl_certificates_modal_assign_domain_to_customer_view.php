<div class="modal-header bg-navy">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>AGREGAR DOMINIO</strong></h4>
</div>
<form name="frmAssignDomainToCustomer" ng-submit="saveAssignDomainToCustomer(ssl_cert)" novalidate="novalidate">
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="">Empresa</label>
                <select class="form-control" ng-model="ssl_cert.customer_id" ng-options="customer.id as customer.name for customer in customers.data" required>
                    <option value="">Seleccionar</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="">Dominio</label>
                <select class="form-control" ng-model="ssl_cert.domain_id" ng-options="domain.id as domain.common_name for domain in domains.data" required>
                    <option value="">Seleccionar</option>
                </select>
            </div>
        </div>
        <div uib-alert ng-repeat="alert in alertsAssignDomainToCustomer" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
    </div>
    <div class="modal-footer text-right">
        <button type="submit" class="btn btn-flat bg-navy" ng-if="isDisabledAssignDomainToCustomer" ng-disabled="frmAssignDomainToCustomer.$invalid == isDisabledAssignDomainToCustomer">Asignar</button>
        <button type="button" class="btn btn-flat bg-navy" ng-if="!isDisabledAssignDomainToCustomer" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
        <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">Cerrar</button>
    </div>
</form>