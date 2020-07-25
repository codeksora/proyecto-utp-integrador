<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>DATOS DEL PROVEEDOR</strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
        	<label for="">Nombre</label>
        	<input type="text" class="form-control" ng-value="provider.name" readonly>
        </div>

        <div class="form-group col-md-6">
        	<label for="">Teléfono</label>
        	<input type="text" class="form-control" ng-value="provider.phone" readonly>
        </div>
    </div>
        
    <div class="row">
        <div class="form-group col-md-6">
        	<label for="">Email</label>
        	<input type="text" class="form-control" ng-value="provider.email" readonly>
        </div>

        <div class="form-group col-md-6">
        	<label for="">Sitio web</label>
        	<input type="text" class="form-control" ng-value="provider.website" readonly>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
        	<label for="">Creado en</label>
        	<input type="text" class="form-control" ng-value="provider.created_at | date: 'dd/MM/yyyy @ HH:mm:ss'" readonly>
        </div>

        <div class="form-group col-md-6">
        	<label for="">Última modificación</label>
        	<input type="text" class="form-control" ng-value="provider.updated_at | date: 'dd/MM/yyyy @ HH:mm:ss'" readonly>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
        	<label for="">Creado por</label>
        	<input type="text" class="form-control" ng-value="provider.user_full_name" readonly>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-flat pull-right" ng-click="closeModal()">CERRAR</button>
</div>