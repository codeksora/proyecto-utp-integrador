<div class="modal-header bg-navy">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>AGREGAR DOMINIO</strong></h4>
</div>
<form name="frmDomain" ng-submit="saveDomain(domain)" novalidate="novalidate">
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Seleccionar la empresa a asignar</label>
                <select class="form-control" ng-model="customers_domains.customer_id" ng-options="customer.id as customer.name for customer in customers">
                    <option value="">Seleccionar</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <button class="btn btn-primary btn-block btn-flat" ng-click="addCustomer()"><strong><i class="fa fa-plus"></i> Asignar empresa a este common name</strong></button>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de la empresa</th>
                            <th>RUC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="customer in domainsCustomers">
                            <td>{{ customer.name }}</td>
                            <td>{{ customer.document_number }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>        
        </div>
        <div uib-alert ng-repeat="alert in alertsAddDomain" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
    </div>
    <div class="modal-footer text-right">
        <button type="submit" class="btn btn-flat bg-navy" ng-if="isDisabledAddDomain" ng-disabled="frmDomain.$invalid == isDisabledAddDomain">Agregar</button>
        <button type="button" class="btn btn-flat bg-navy" ng-if="!isDisabledAddDomain" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
        <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">Cerrar</button>
    </div>
</form>