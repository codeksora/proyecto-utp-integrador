<div class="modal-header bg-blue">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>DETALLE DEL ROL</strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
        <label>Nombre</label>
        <input type="text" class="form-control" ng-value="role.name" readonly>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-right" ng-click="closeModal()">Cerrar</button>
</div>