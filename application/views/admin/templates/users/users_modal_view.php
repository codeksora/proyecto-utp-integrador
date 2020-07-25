<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>INFORMACIÓN DEL USUARIO</strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" class="form-control" ng-value="user.full_name" readonly>
        </div>
        <div class="form-group col-md-6">
            <label>Nombre de usuario</label>
            <input type="text" class="form-control" ng-value="user.username" readonly>
        </div>
    </div>
        
    <div class="row">
        <div class="form-group col-md-6">
            <label>Correo electrónico</label>
            <input type="text" class="form-control" ng-value="user.email" readonly>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-right" ng-click="closeModal()">CERRAR</button>
</div>