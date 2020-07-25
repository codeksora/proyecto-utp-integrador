<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Datos de {{ privilege.role_name + ' - ' + privilege.menu_name }}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <dl class="col-md-6">
        <dt>Menú</dt>
        <dd>{{ privilege.menu_name }}</dd>
        </dl>
        <dl class="col-md-6">
        <dt>Rol</dt>
        <dd>{{ privilege.role_name }}</dd>
        </dl>
    </div>

    <div class="row">
        <dl class="col-md-3">
        <dt>Leer</dt>
        <dd>
            <i ng-if="privilege.read == 1" class="fa fa-check"></i> 
            <i ng-if="privilege.read == 0" class="fa fa-close"></i>
        </dd>
        </dl>

        <dl class="col-md-3">
        <dt>Insertar</dt>
        <dd>
            <i ng-if="privilege.insert == 1" class="fa fa-check"></i> 
            <i ng-if="privilege.insert == 0" class="fa fa-close"></i>
        </dd>
        </dl>

        <dl class="col-md-3">
        <dt>Actualizar</dt>
        <dd>
            <i ng-if="privilege.update == 1" class="fa fa-check"></i> 
            <i ng-if="privilege.update == 0" class="fa fa-close"></i>
        </dd>
        </dl>

        <dl class="col-md-3">
        <dt>Eliminar</dt>
        <dd>
            <i ng-if="privilege.delete == 1" class="fa fa-check"></i> 
            <i ng-if="privilege.delete == 0" class="fa fa-close"></i>
        </dd>
        </dl>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
</div>