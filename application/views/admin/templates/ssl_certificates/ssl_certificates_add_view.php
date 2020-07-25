<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>DATOS DEL USUARIO</strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <dl class="col-md-6">
        <dt>Nombre</dt>
        <dd>{{ user.full_name }}</dd>
        </dl>
        <dl class="col-md-6">
        <dt>Nombre de usuario</dt>
        <dd>{{ user.username }}</dd>
        </dl>
    </div>
        
    <div class="row">
        <dl class="col-md-6">
        <dt>Correo electrónico</dt>
        <dd>{{ user.email }}</dd>
        </dl>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-right" ng-click="closeModal()">Cerrar</button>
</div>