<div class="row">
                <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>DATOS DE LA SOLICITUD</strong></h4>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary" ng-click="showFormDetail = !showFormDetail">Mostrar / Ocultar detalles de la solicitud</button>
                </div>
            </div>

            <div ng-if="showFormDetail">
                <div class="row">
                    <div class="form-group col-md-12">
                        <h5 class="modal-title text-red"><strong>DATOS DE LA ORGANIZACIÓN</strong></h5>
                    </div>
                </div>

                <div class="row">
                    <dl class="col-md-3">
                    <dt>Organización</dt>
                    <dd>{{ ssl_cert_assigned.organizacion_cli }}</dd>
                    </dl>
                    <dl class="col-md-3">
                    <dt>RUC</dt>
                    <dd>{{ ssl_cert_assigned.ruc_cli }} </dd>
                    </dl>
                    <dl class="col-md-3">
                    <dt>Dirección</dt>
                    <dd>{{ ssl_cert_assigned.direccion_cli }}</dd>
                    </dl>
                    <dl class="col-md-3">
                    <dt>Teléfono</dt>
                    <dd>{{ ssl_cert_assigned.telefono_cli }}</dd>
                    </dl>
                  <dl class="col-md-12">
                  <dt>Código Postal</dt>
                  <dd>{{ ssl_cert_assigned.codPostal_cli }}</dd>
                  </dl>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <h5 class="modal-title text-red"><strong>DATOS DEL PRODUCTO</strong></h5>
                    </div>
                </div>

                <div class="row">
                    <dl class="col-md-3">
                    <dt>Periodo</dt>
                    <dd>{{ ssl_cert_assigned.periodo }}</dd>
                    </dl>
                    <dl class="col-md-3">
                    <dt>Concepto</dt>
                    <dd>{{ ssl_cert_assigned.accion }} </dd>
                    </dl>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <h5 class="modal-title text-red"><strong>DATOS DEL SERVIDOR</strong></h5>
                    </div>
                </div>

                <div class="row">
                    <dl class="col-md-3">
                    <dt>Servidor</dt>
                    <dd>{{ ssl_cert_assigned.servidor }}</dd>
                    </dl>
                    <dl class="col-md-3">
                    <dt>Cantidad</dt>
                    <dd>{{ ssl_cert_assigned.cantservidor }}</dd>
                    </dl>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-12">
                        <h5 class="modal-title text-red"><strong>INFORMACIÓN DEL CSR</strong></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <dl class="col-md-12">
                            <dt>Common name</dt>
                            <dd>{{ ssl_cert_assigned.CommonName_CSR }}</dd>
                            </dl>
                            <dl class="col-md-12">
                            <dt>Organización</dt>
                            <dd>{{ ssl_cert_assigned.Organizacion_CSR }}</dd>
                            </dl>
                            <dl class="col-md-12">
                            <dt>U. Organizac.</dt>
                            <dd>{{ ssl_cert_assigned.UnidadOrganizacion_CSR }}</dd>
                            </dl>
                            <dl class="col-md-12">
                            <dt>Localidad</dt>
                            <dd>{{ ssl_cert_assigned.Ciudad_CSR }}</dd>
                            </dl>
                            <dl class="col-md-12">
                            <dt>Estado</dt>
                            <dd>{{ ssl_cert_assigned.Estado_CSR }}</dd>
                            </dl>
                            <dl class="col-md-12">
                            <dt>País</dt>
                            <dd>{{ ssl_cert_assigned.Pais_CSR }}</dd>
                            </dl>
                          
                            <dl class="col-md-12">
                            <dt>Key</dt>
                            <dd>{{ ssl_cert_assigned.key_CSR }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row">
                            <dl class="col-md-12">
                                <dt>CSR</dt>
                                <dd>{{ ssl_cert_assigned.Desc_csr }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <h5 class="modal-title text-red"><strong>CONTACTOS ENVIADOS</strong></h5>
                        <p>Los siguientes Contactos han sido enviados a traves del Formulario.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Empresa</th>
                                    <th>Email</th>
                                    <th>Cargo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Administrativo</td>
                                    <td>{{ ssl_cert_assigned.nombreSSL_Adm }} {{ ssl_cert_assigned.apellidoSSL_Adm }}</td>
                                    <td>{{ ssl_cert_assigned.organizacionSSL_Adm }}</td>
                                    <td>{{ ssl_cert_assigned.mailSSL_Adm }}</td>
                                    <td>{{ ssl_cert_assigned.cargoSSL_Adm }}</td>
                                    <td>{{ ssl_cert_assigned.telOfSSL_Adm }}</td>
                                    <td>{{ ssl_cert_assigned.direccionSSL_Adm }}</td>
                                </tr>

                                <tr>
                                    <td>Técnico</td>
                                    <td>{{ ssl_cert_assigned.nombreSSL_Tec }} {{ ssl_cert_assigned.apellidoSSL_Tec }}</td>
                                    <td>{{ ssl_cert_assigned.organizacionSSL_Tec }}</td>
                                    <td>{{ ssl_cert_assigned.mailSSL_Tec }}</td>
                                    <td>{{ ssl_cert_assigned.cargoSSL_Tec }}</td>
                                    <td>{{ ssl_cert_assigned.telOfSSL_Tec }}</td>
                                    <td>{{ ssl_cert_assigned.direccionSSL_Tec }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                <hr>
                    <h4 class="modal-title"><strong>SELECCIONE LOS CONTACTOS QUE SERAN ASIGNADOS AL CERTIFICADO SSL</strong></h4>
                    <p>Contactos registrados en el Sistema, seleccione los contactos que seran asignados al Certificado para su seguimiento.</p>
                </div>
            </div>

            <div class="row" ng-if="contacts_ssl_certs_assigned.data.length < 2">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-danger" ng-click="assignContacts()">Asignar contactos al certificado SSL</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo de contacto</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th></th>
                            </tr>
                        </thead>       
                        <tbody>
                            <tr ng-repeat="contact_ssl_certs_assigned in contacts_ssl_certs_assigned.data">
                                <td>{{ contact_ssl_certs_assigned.contact_type_name }}</td>
                                <td>{{ contact_ssl_certs_assigned.first_name + ' ' + contact_ssl_certs_assigned.last_name }}</td>
                                <td>{{ contact_ssl_certs_assigned.email }}</td>
                                <td>{{ contact_ssl_certs_assigned.job_title }}</td>
                                <td>{{ contact_ssl_certs_assigned.phone }}</td>
                                <td>{{ contact_ssl_certs_assigned.address_line_1 }}</td>
                                <td><button type="button" class="btn btn-danger btn-xs" ng-click="deleteContactSslCertAssigned(contact_ssl_certs_assigned.id)"><i class="fa fa-close"></i></button></td>
                            </tr>
                        </tbody>     
                    </table>
                </div>
            </div>
<!-- COMENTARIOS -->
<div class="row">
    <div class="form-group col-md-12">
                    <hr>
                    <h4 class="modal-title"><strong>COMENTARIOS</strong></h4>
                </div>
</div>
<div class="row">
  <div class="col-md-12 chat">
      <!-- chat item -->
      <div class="item" ng-repeat="comm in comments_ssl_certs_assigned">
        <img ng-src="<?php echo base_url(); ?>uploads/{{ comm.image_name || 'default.jpg' }}" alt="user image" class="offline">

        <p class="message">
          <a href="" class="name">
            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{ comm.created_at | date:'dd/MM/yyyy @ h:mma' }}</small>
            {{ comm.user_full_name }}
          </a>
          {{ comm.message }}
        </p>
      </div>
      <!-- /.item -->
  </div>
  
  <div class="col-md-12">
    <div class="input-group">
      <input class="form-control" placeholder="Escribe tu comentario..." ng-model="comment.message">

      <div class="input-group-btn">
        <button type="button" class="btn btn-success" ng-click="addCommentSslCertificatesAssigned(comment)" ng-disabled="!comment.message"><i class="fa fa-plus"></i></button>
      </div>
    </div>
    <br>
    <div uib-alert ng-repeat="alert in alertsCommentSslCertsAssigned" class="alert alert-danger" close="closeAlertComment($index)"><span ng-bind-html="alert.message"></span></div>
  </div>
</div>