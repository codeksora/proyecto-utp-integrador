<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>DETALLES DEL CONTACTO</strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Nombre</th>
                        <th>Apellido</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ contact.first_name }}</td>
                        <td>{{ contact.last_name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Código</th>
                        <th>Teléfono</th>
                        <th>Celular</th>
                        <th>Anexo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ contact.code }}</td>
                        <td>{{ contact.phone }}</td>
                        <td>{{ contact.mobile_phone }}</td>
                        <td>{{ contact.extension }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Empresa</th>
                        <th>Sitio web</th>
                        <th>Cargo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ contact.customer_name }}</td>
                        <td>{{ contact.website }}</td>
                        <td>{{ contact.job_title }}</td>
                    </tr>
                </tbody>
            </table>
        </div>   
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>País</th>
                        <th>Estado</th>
                        <th>Ciudad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ contact.country_name }}</td>
                        <td>{{ contact.state }}</td>
                        <td>{{ contact.city }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Dirección 1</th>
                        <th>Dirección 2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ contact.address_line_1 }}</td>
                        <td>{{ contact.address_line_2 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Tipo de contacto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ contact.contact_type_name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-right" ng-click="closeModal()">Cerrar</button>
</div>