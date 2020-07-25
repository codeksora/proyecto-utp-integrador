<div class="modal-header bg-maroon">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>AGREGAR DOMINIO</strong></h4>
</div>
<form name="frmDomain" ng-submit="saveDomain(domain)" novalidate="novalidate">
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12">
                <label>COMMON NAME</label>
                <input type="text" class="form-control" ng-model="domain.common_name" required>
            </div>        
        </div>
        <div uib-alert ng-repeat="alert in alertsAddDomain" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
    </div>
    <div class="modal-footer text-right">
        <button type="submit" class="btn btn-flat bg-maroon" ng-if="isDisabledAddDomain" ng-disabled="frmDomain.$invalid == isDisabledAddDomain">Agregar</button>
        <button type="button" class="btn btn-flat bg-maroon" ng-if="!isDisabledAddDomain" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
        <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">Cerrar</button>
    </div>
</form>