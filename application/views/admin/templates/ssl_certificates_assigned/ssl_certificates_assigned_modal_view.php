<!-- PENDIENTES -->
<div ng-if="ssl_cert_assigned.ssl_certificate_status_id == 1">
    <div class="modal-header bg-red">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>LISTADO DE CONTACTOS ASIGNADOS A LA EMPRESA</strong></h4>
    </div>
    <!-- <form name="frmAssignDomainToCustomer" ng-submit="saveAssignDomainToCustomer(ssl_cert)" novalidate="novalidate"> -->
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <p>Seleccione los contactos para el envio del Formulario</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
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
            <div uib-alert ng-repeat="alert in alertsSslCertsAssigned" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
        </div>
        <div class="modal-footer text-right">
            <button type="button" ng-click="sendEmail(0)" class="btn btn-flat bg-aqua" ng-if="isDisabledSslCertAssigned" ng-disabled="!isDisabledSslCertAssigned">OMITIR</button>
            <button type="button" ng-click="sendEmail()" class="btn btn-flat bg-red" ng-if="isDisabledSslCertAssigned" ng-disabled="!isDisabledSslCertAssigned"><i class="fa fa-envelope"></i> ENVIAR CORREO</button>
            <button type="button" class="btn btn-flat bg-red" ng-if="!isDisabledSslCertAssigned" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">CERRAR</button>
        </div>
    <!-- </form> -->
</div>

<!-- FORMULARIO -->
<div ng-if="ssl_cert_assigned.ssl_certificate_status_id == 2">
    <div class="modal-header bg-yellow">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>ACTUALIZANDO DATOS DEL CERTIFICADO DE ESTADO FORMULARIO A VALIDADOS</strong></h4>
    </div>
    <form name="frmAssignDomainToCustomer" ng-submit="toValidate(ssl_cert_assigned)" novalidate="novalidate">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <h4 class="modal-title"><strong>DATOS DE LA ORDEN</strong></h4>
                </div>
            </div>

            <div class="row">
                <dl class="col-md-4">
                <dt>Nro. de Orden</dt>
                <dd>{{ ssl_cert_assigned.order_number }}</dd>
                </dl>
                <dl class="col-md-4">
                <dt>Fecha de Orden</dt>
                <dd>{{ ssl_cert_assigned.order_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
                <dl class="col-md-4">
                <dt>Fecha de vencimiento</dt>
                <dd>{{ ssl_cert_assigned.order_expiration_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>DATOS DEL CERTIFICADO</strong></h4>
                </div>
            </div>

            <div class="row">
                <dl class="col-md-4">
                <dt>Concepto</dt>
                <dd>{{ ssl_cert_assigned.accion }}</dd>
                </dl>
                <dl class="col-md-4">
                <dt>Producto</dt>
                <dd>{{ ssl_cert_assigned.product_name }}</dd>
                </dl>
                <dl class="col-md-4">
                <dt>Common name</dt>
                <dd>{{ ssl_cert_assigned.common_name }}</dd>
                </dl>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Sistema operativo *</label>
                    <select class="form-control" ng-options="operating_system_type.id as operating_system_type.name for operating_system_type in operating_system_types" ng-model="ssl_cert_assigned.operating_system_type_id" required>
                        <option value="">Seleccionar</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Tipo de servidor *</label>
                    <select class="form-control" ng-options="server_type.id as server_type.name for server_type in server_types | filter:{operating_system_type_id:ssl_cert_assigned.operating_system_type_id}" ng-model="ssl_cert_assigned.server_type_id" ng-disabled="!ssl_cert_assigned.operating_system_type_id" required>
                        <option value="">Seleccionar</option>
                    </select>
                </div>
            </div>

            <div ng-if="ssl_cert_assigned.is_san == 1">

                <div class="row">
                    <div class="form-group col-md-12">
                        <hr>
                        <h4 class="modal-title"><strong>SAN ADICIONALES</strong></h4>
                    </div>
                </div>

                <div class="row" ng-if="ssl_cert_assigned.addtional_sans.length < ssl_cert_assigned.total_san">
                    <div class="form-group col-md-6">
                        <div class="input-group input-group-md">
                          <input type="text" class="form-control" ng-model="prev_common_name" required>
                          <span class="input-group-btn">
                              <button type="button" class="btn bg-purple btn-flat" ng-click="addSan(prev_common_name)"><i class="fa fa-plus"></i></button>
                          </span>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th># ID</th>
                                    <th>Common name</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(key, addtional_san) in ssl_cert_assigned.addtional_sans track by $index">
                                    <td>{{ key + 1 }}</td>
                                    <td>{{ addtional_san }}</td>
                                    <td><button type="button" class="btn btn-danger btn-xs" ng-click="deleteSan($index)"><i class="fa fa-close"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <?php $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_form_detail_view'); ?>

            

            <div uib-alert ng-repeat="alert in alertsSslCertsAssigned" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
        </div>
        <div class="modal-footer text-right">
            <button type="submit" class="btn btn-flat bg-yellow" ng-if="isDisabledSslCertAssigned" ng-disabled="frmAssignDomainToCustomer.$invalid == isDisabledSslCertAssigned">Validar información</button>
            <button type="button" class="btn btn-flat bg-yellow" ng-if="!isDisabledSslCertAssigned" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">Cerrar</button>
        </div>
    </form>
</div>

<!-- VALIDADOS -->
<div ng-if="ssl_cert_assigned.ssl_certificate_status_id == 3">
    <div class="modal-header bg-aqua">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>ACTUALIZANDO DATOS DEL CERTIFICADO : CERTIFICADO LISTO PARA SU ENROLAMIENTO</strong></h4>
    </div>
    <form name="frmSslCertificatesAssigned" ng-submit="toIssue(ssl_cert_assigned)" novalidate="novalidate">
        <div class="modal-body">
        <div class="row">
                <div class="form-group col-md-12">
                    <h4 class="modal-title"><strong>DATOS DE LA ORDEN</strong></h4>
                </div>
            </div>

            <div class="row">
                <dl class="col-md-3">
                    <dt>Nro. de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Nro. de Orden Cliente</dt>
                    <dd>{{ ssl_cert_assigned.customer_order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de vencimiento</dt>
                    <dd>{{ ssl_cert_assigned.order_expiration_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>DATOS DEL CERTIFICADO</strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id de pedido *</label>
                    <input type="text" class="form-control" ng-model="ssl_cert_assigned.enroll_code" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Concepto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.concept_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Producto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.product_name" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Common name</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.common_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Sistema operativo</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.operating_system_types" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Tipo de servidor</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.server_type_name" readonly>
                </div>
            </div>

            <div ng-if="ssl_cert_assigned.is_san == 1">
                <div class="row">
                    <div class="form-group col-md-12">
                        <hr>
                        <h4 class="modal-title"><strong>CERTIFICADOS SAN - NOMBRES ALTERNOS</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombres alternos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="additional_san in additional_sans">
                                    <td>{{ additional_san.common_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_form_detail_view'); ?>
                      
            <div uib-alert ng-repeat="alert in alertsSslCertsAssigned" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
        </div>
        <div class="modal-footer text-right">
            <button type="submit" class="btn btn-flat bg-aqua" ng-if="isDisabledSslCertAssigned" ng-disabled="frmSslCertificatesAssigned.$invalid == isDisabledSslCertAssigned">ENVIAR PARA SU EMISIÓN</button>
            <button type="button" class="btn btn-flat bg-aqua" ng-if="!isDisabledSslCertAssigned" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">CERRAR</button>
        </div>
    </form>
</div>

<!-- POR EMITIR -->
<div ng-if="ssl_cert_assigned.ssl_certificate_status_id == 4">
    <div class="modal-header bg-purple">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>ACTUALIZANDO DATOS DEL CERTIFICADO DE ESTADO PROCESO A EMITIDO</strong></h4>
    </div>
    <form name="frmSslCertificatesAssigned" ng-submit="toInstall(ssl_cert_assigned)" novalidate="novalidate">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <h4 class="modal-title"><strong>DATOS DE LA ORDEN</strong></h4>
                </div>
            </div>

            <div class="row">
                <dl class="col-md-3">
                    <dt>Nro. de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Nro. de Orden Cliente</dt>
                    <dd>{{ ssl_cert_assigned.customer_order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de vencimiento</dt>
                    <dd>{{ ssl_cert_assigned.order_expiration_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
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
                    <input date-range-picker type="text" class="form-control" ng-model="ssl_cert_assigned.issue_date" options="single_date_options" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de vencimiento *</label>
                    <input date-range-picker type="text" class="form-control" ng-model="ssl_cert_assigned.expiration_date" options="single_date_options" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id de pedido *</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.enroll_code" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Concepto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.concept_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Producto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.product_name" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Common name</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.common_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Sistema operativo</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.operating_system_types" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Tipo de servidor</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.server_type_name" readonly>
                </div>
            </div>
       
            <?php $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_form_detail_view'); ?>
                
            <div uib-alert ng-repeat="alert in alertsSslCertsAssigned" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
        </div>
        <div class="modal-footer text-right">
            <button type="submit" class="btn btn-flat bg-purple" ng-if="isDisabledSslCertAssigned" ng-disabled="frmSslCertificatesAssigned.$invalid == isDisabledSslCertAssigned">ENVIAR PARA SU INSTALACIÓN</button>
            <button type="button" class="btn btn-flat bg-purple" ng-if="!isDisabledSslCertAssigned" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">CERRAR</button>
        </div>
    </form>
</div>

<!-- POR INSTALAR -->
<div ng-if="ssl_cert_assigned.ssl_certificate_status_id == 5">
    <div class="modal-header bg-navy">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>FORMULARIO PARA LA INSTALACION DEL CERTIFICADO SSL</strong></h4>
    </div>
    <form name="frmSslCertificatesAssigned" ng-submit="toInstalled(ssl_cert_assigned)" novalidate="novalidate">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <h4 class="modal-title"><strong>DATOS DE LA ORDEN</strong></h4>
                </div>
            </div>

            <div class="row">
                <dl class="col-md-3">
                    <dt>Nro. de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Nro. de Orden Cliente</dt>
                    <dd>{{ ssl_cert_assigned.customer_order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de vencimiento</dt>
                    <dd>{{ ssl_cert_assigned.order_expiration_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>DATOS DEL CERTIFICADO</strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Fecha de instalación *</label>
                    <input date-range-picker type="text" class="form-control" ng-model="ssl_cert_assigned.installation_date" options="single_date_options" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de emisión</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.issue_date | date: 'dd/MM/yyyy'" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de vencimiento</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.expiration_date | date: 'dd/MM/yyyy'" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id de pedido *</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.enroll_code" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Concepto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.product_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Producto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.product_name" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Common name</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.common_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Sistema operativo</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.operating_system_types" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Tipo de servidor</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.server_type_name" readonly>
                </div>
            </div>

            <?php $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_form_detail_view'); ?>
                      
            <div uib-alert ng-repeat="alert in alertsSslCertsAssigned" class="alert alert-danger" close="closeAlert($index)"><span ng-bind-html="alert.message"></span></div>
        </div>
        <div class="modal-footer text-right">
            <button type="submit" class="btn btn-flat bg-navy" ng-if="isDisabledSslCertAssigned" ng-disabled="frmSslCertificatesAssigned.$invalid == isDisabledSslCertAssigned">ENVIAR A INSTALADOS</button>
            <button type="button" class="btn btn-flat bg-navy" ng-if="!isDisabledSslCertAssigned" disabled><i class="fa fa-pulse fa-spinner"></i> CARGANDO</button>
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">CERRAR</button>
        </div>
    </form>
</div>

<!-- INSTALADO -->
<div ng-if="ssl_cert_assigned.ssl_certificate_status_id == 6">
    <div class="modal-header bg-green">
        <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>DETALLE DEL CERTIFICADO SSL</strong></h4>
    </div>
    <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <h4 class="modal-title"><strong>DATOS DE LA ORDEN</strong></h4>
                </div>
            </div>

            <div class="row">
                <dl class="col-md-3">
                    <dt>Nro. de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Nro. de Orden Cliente</dt>
                    <dd>{{ ssl_cert_assigned.customer_order_number }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de Orden</dt>
                    <dd>{{ ssl_cert_assigned.order_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
                <dl class="col-md-3">
                    <dt>Fecha de vencimiento</dt>
                    <dd>{{ ssl_cert_assigned.order_expiration_date | date: 'dd/MM/yyyy' }}</dd>
                </dl>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>DATOS DEL CERTIFICADO</strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Fecha de instalación *</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.installation_date | date: 'dd/MM/yyyy'" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de emisión</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.issue_date | date: 'dd/MM/yyyy'" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Fecha de vencimiento</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.expiration_date | date: 'dd/MM/yyyy'" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id de pedido *</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.enroll_code" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Concepto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.concept_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Producto</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.product_name" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Common name</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.common_name" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Sistema operativo</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.operating_system_types" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Tipo de servidor</label>
                    <input type="text" class="form-control" ng-value="ssl_cert_assigned.server_type_name" readonly>
                </div>
            </div>

            <?php $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_form_detail_view'); ?>
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-flat btn-default" ng-click="closeModal()">CERRAR</button>
        </div>
</div>