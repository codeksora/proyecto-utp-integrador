<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>DETALLES DEL CLIENTE</strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Nombre de la Empresa</th>
                        <th>Sector</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.sector_name }}</td>
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
                        <td>{{ '+' + customer.code }}</td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.mobile_phone }}</td>
                        <td>{{ customer.extension }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Tipo de documento</th>
                        <th>Número de documento</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ customer.document_type_name }}</td>
                        <td>{{ customer.document_number }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>Sitio web</th>
                        <th>País</th>
                        <th>Estado</th>
                        <th>Ciudad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="{{ customer.website }}" target="_blank">{{ customer.website }}</a></td>
                        <td>{{ customer.country_name }}</td>
                        <td>{{ customer.state }}</td>
                        <td>{{ customer.city }}</td>
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
                        <td>{{ customer.address_line_1 }}</td>
                        <td>{{ customer.address_line_2 }}</td>
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
                        <th>Dirección de envío</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ customer.shipping_address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-right" ng-click="closeModal()">Cerrar</button>
</div>