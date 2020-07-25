<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Agregar producto</h4>
</div>
<form ng-submit="addProduct(product)" novalidate>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <label>Código</label>
            <input type="text" class="form-control" ng-model="product.code" required>
        </div>

        <div class="form-group col-md-6">
            <label>Und / Medida</label>
            <select name="" id="" class="form-control" ng-model="product.unit" required>
                <option value="">Seleccionar</option>
                <option value="01">KILOGRAMOS</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            <label for="">Descripción</label>
            <input type="text" class="form-control" ng-model="product.description" required>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Precio/Uni(Inc.IGV)</label>
            <input type="text" class="form-control" ng-model="product.price" required>
        </div>
        <div class="form-group col-md-6">
            <label>Cantidad</label>
            <input type="text" class="form-control" ng-model="product.quantity" required>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4">
            <label>Sub. Total</label>
            <input type="text" class="form-control" ng-value="product.price * product.quantity | number : 2" disabled>
        </div>

        <div class="form-group col-md-4">
            <label>IGV (18%)</label>
            <input type="text" class="form-control" ng-value="(product.price * product.quantity) * igv | number : 2" disabled>
        </div>

        <div class="form-group col-md-4">
            <label>Total</label>
            <input type="text" class="form-control" ng-value="((product.price * product.quantity) * igv) + (product.price * product.quantity) | number : 2" disabled>
        </div>
    </div>
</div>
<div class="modal-footer text-right">
    <button type="submit" class="btn btn-primary">Agregar</button>
    <button type="button" class="btn btn-default" ng-click="closeModal()">Cerrar</button>
</div>
</form>