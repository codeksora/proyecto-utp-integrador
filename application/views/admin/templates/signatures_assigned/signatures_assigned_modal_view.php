<div ng-if="signature_assigned.signature_status_id == 1">
    <div class="modal-header bg-red">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>ACTUALIZANDO DATOS DE LA FIRMA</strong></h4>
    </div>
    <form name="frmSignatureAssigned" ng-submit="toInstall(signature_assigned)" novalidate="novalidate">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <h4 class="modal-title"><strong>DATOS DE LA ORDEN</strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="">Nro. de Orden Interna</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.order_number" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Nro. de Orden Externa</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.customer_order_number" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Fecha de Orden</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.order_date | date: 'dd/MM/yyyy'" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Fecha de vencimiento</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.order_expiration_date | date: 'dd/MM/yyyy'" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>DATOS DEL CERTIFICADO</strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Fecha de emisión *</label>
                    <input date-range-picker type="text" class="form-control" ng-model="signature_assigned.issue_date" options="single_date_options" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de instalación *</label>
                    <input date-range-picker type="text" class="form-control" ng-model="signature_assigned.installation_date" options="single_date_options" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de vencimiento *</label>
                    <input date-range-picker type="text" class="form-control" ng-model="signature_assigned.expiration_date" options="single_date_options" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id de pedido *</label>
                    <input type="text" class="form-control" ng-model="signature_assigned.enroll_code" required>
                </div>

                <div class="form-group col-md-8">
                    <label for="">Producto</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.product_name" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Usuario</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.persnombreuser" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Correo</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.persmailuser" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Cargo</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.perscargouser" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                <hr>
                    <h4 class="modal-title"><strong>SELECCIONE LOS CONTACTOS QUE SERAN ASIGNADOS A LA FIRMA</strong></h4>
                    <p>Contactos registrados en el Sistema, seleccione los contactos que seran asignados a la firma para su seguimiento.</p>
                </div>
            </div>

            <div class="row" ng-if="contacts_signatures_assigned.data < 1">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-danger" ng-click="assignContacts()">Asignar contactos a la firma</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nombres y Apellidos</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Teléfonos</th>
                                <th>Dirección</th>
                                <th></th>
                            </tr>
                        </thead>       
                        <tbody>
                            <tr ng-repeat="contact_signatures_assigned in contacts_signatures_assigned.data">
                                <td>{{ contact_signatures_assigned.contact_type_name }}</td>
                                <td>{{ contact_signatures_assigned.first_name + ' ' + contact_signatures_assigned.last_name }}</td>
                                <td>{{ contact_signatures_assigned.email }}</td>
                                <td>{{ contact_signatures_assigned.job_title }}</td>
                                <td>{{ contact_signatures_assigned.phone }}</td>
                                <td>{{ contact_signatures_assigned.address_line_1 }}</td>
                                <td><button type="button" class="btn btn-danger btn-xs" ng-click="deleteContactSignatureAssigned(contact_signatures_assigned.id)"><i class="fa fa-close"></i></button></td>
                            </tr>
                        </tbody>     
                    </table>
                </div>
            </div>

            
                      
            <div uib-alert ng-repeat="alert in alertsSslCertsAssigned" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
        </div>
        <div class="modal-footer text-right">
            <button type="submit" class="btn btn-flat bg-red" ng-if="isDisabledSignatureAssigned" ng-disabled="frmSignatureAssigned.$invalid == isDisabledSignatureAssigned">ENVIAR PARA SU INSTALACIÓN</button>
            <button type="button" class="btn btn-flat bg-red" ng-if="!isDisabledSignatureAssigned" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">CERRAR</button>
        </div>
    </form>
</div>

<div ng-if="signature_assigned.signature_status_id == 2">
    <div class="modal-header bg-green">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>DETALLES DE LA FIRMA</strong></h4>
    </div>
    <form name="frmSignatureAssigned" ng-submit="toInstall(signature_assigned)" novalidate="novalidate">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <h4 class="modal-title"><strong>DATOS DE LA ORDEN</strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="">Nro. de Orden Interna</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.order_number" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Nro. de Orden Externa</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.customer_order_number" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Fecha de Orden</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.order_date | date: 'dd/MM/yyyy'" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Fecha de vencimiento</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.order_expiration_date | date: 'dd/MM/yyyy'" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>DATOS DEL CERTIFICADO</strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Fecha de emisión</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.issue_date | date: 'dd/MM/yyyy'" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de instalación</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.installation_date | date: 'dd/MM/yyyy'" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de vencimiento</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.expiration_date | date: 'dd/MM/yyyy'" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id de pedido</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.enroll_code" readonly>
                </div>

                <div class="form-group col-md-8">
                    <label for="">Producto</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.product_name" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Usuario</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.persnombreuser" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Correo</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.persmailuser" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Cargo</label>
                    <input type="text" class="form-control" ng-value="signature_assigned.perscargouser" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                <hr>
                    <h4 class="modal-title"><strong>SELECCIONE LOS CONTACTOS QUE SERAN ASIGNADOS A LA FIRMA</strong></h4>
                    <p>Contactos registrados en el Sistema, seleccione los contactos que seran asignados a la firma para su seguimiento.</p>
                </div>
            </div>

            <div class="row" ng-if="contacts_signatures_assigned.data < 1">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-danger" ng-click="assignContacts()">Asignar contactos a la firma</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nombres y Apellidos</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Teléfonos</th>
                                <th>Dirección</th>
                                <th></th>
                            </tr>
                        </thead>       
                        <tbody>
                            <tr ng-repeat="contact_signatures_assigned in contacts_signatures_assigned.data">
                                <td>{{ contact_signatures_assigned.contact_type_name }}</td>
                                <td>{{ contact_signatures_assigned.first_name + ' ' + contact_signatures_assigned.last_name }}</td>
                                <td>{{ contact_signatures_assigned.email }}</td>
                                <td>{{ contact_signatures_assigned.job_title }}</td>
                                <td>{{ contact_signatures_assigned.phone }}</td>
                                <td>{{ contact_signatures_assigned.address_line_1 }}</td>
                                <td><button type="button" class="btn btn-danger btn-xs" ng-click="deleteContactSignatureAssigned(contact_signatures_assigned.id)"><i class="fa fa-close"></i></button></td>
                            </tr>
                        </tbody>     
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">CERRAR</button>
        </div>
    </form>
</div>