<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModalAssignContacts()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>AGREGAR CERTIFICADO SSL</strong></h4>
</div>
<form ng-submit="addContactsToSslCertificateAssigned(contact_to_ssl)">
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-4">
            <label>Tipo de Contacto</label>
            <select class="form-control" 
                ng-model="contact_to_ssl.contact_type_id"
                ng-options="contact_type.id as contact_type.name for contact_type in contact_types">
                <option value="">Seleccionar</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" ng-model="contactSel.allItemsSelected" ng-change="selectAll()"></th>
                        <th>Nombres</th>
                        <th>Cargo</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Anexo</th>
                        <th>Celular</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="contact in contacts">
                        <td><input type="checkbox" ng-model="contact.isChecked" ng-change="selectEntity()"></td>
                        <td>{{ contact.first_name + ' ' + contact.last_name }}</td>
                        <td>{{ contact.job_title }}</td>
                        <td>{{ contact.email }}</td>
                        <td>{{ contact.phone }}</td>
                        <td>{{ contact.extension }}</td>
                        <td>{{ contact.mobile_phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div uib-alert ng-repeat="alert in alertsContactsSslCert" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-flat btn-primary" ng-if="isDisabledContactsSslCert">AGREGAR CONTACTO</button>
    <button type="button" class="btn btn-flat btn-primary" ng-if="!isDisabledContactsSslCert" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
    <button type="button" class="btn btn-default pull-right" ng-click="closeModalAssignContacts()">Cerrar</button>
</div>
</form>

