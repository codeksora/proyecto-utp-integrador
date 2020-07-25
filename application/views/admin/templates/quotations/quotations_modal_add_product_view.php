<div class="modal-header bg-primary">
    <button type="button" class="close" ng-click="closeModal()">
        <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>AGREGAR PRODUCTO</strong></h4>
    <p class="mb-0">Si se agrega descuento a un producto, la cotización pasará por un proceso de aprobación</p>
</div>
<form ng-submit="addProduct(product)" novalidate>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12 required">
            <label>Tipo de producto</label>
            <oi-select
                ng-model="product.product_type_id" 
                oi-options="product_type.id as product_type.name for product_type in product_types track by product_type.id" 
                placeholder="Seleccionar"
                required
                ></oi-select>
        </div>
      <div class="form-group col-md-12 required"> 
            <label>Proveedor</label>
            <oi-select
                ng-model="product.provider_id" 
                oi-options="provider.id as provider.name for provider in providers | filter:{product_type_id:product.product_type_id}"
                ng-disabled="!product.product_type_id" 
                placeholder="Seleccionar"
                required
                ></oi-select>
        </div>
        <div class="form-group col-md-12 required"> 
            <label>Producto</label>
            <oi-select
                ng-model="product.product_id" 
                oi-options="product_detail.id as product_detail.product_name for product_detail in product_details | filter:{provider_id:product.provider_id}:true"
                ng-disabled="!product.provider_id" 
                ng-change="getProductDetails(product.product_id)"
                placeholder="Seleccionar"
                required
                ></oi-select>
        </div> 

        <div class="form-group col-md-12 required">
            <label>Concepto</label>
            <oi-select
                ng-model="product.concept_id" 
                oi-options="concept.id as concept.name for concept in concepts track by concept.id" 
                placeholder="Seleccionar"
                required
                ></oi-select>
        </div>
    </div>

    <div class="row" ng-if="product.product_id">
        <div class="form-group col-md-12">
            <label for="">Descripción</label>
             <textarea class="form-control" ng-value="product_detail.product_description" rows="7" readonly></textarea>
        </div>

        <div class="form-group col-md-12" ng-if="product.product_type_id == 2">
            <label for="">Correo(s)</label>
            <tags-input type="email" ng-model="product.mails" placeholder="Añadir correo"></tags-input>
        </div>
      
      <div class="form-group col-md-12" ng-if="product.product_type_id == 1">
            <label for="">Dominio(s)</label>
            <tags-input type="text" ng-model="product.domains" placeholder="Añadir dominio"></tags-input>
        </div>
    
        <div class="form-group col-md-4">
            <label for="">Precio del producto</label>
            <input type="text" class="form-control" ng-value="product_detail.product_detail_price" readonly>
        </div>

        <div class="form-group col-md-4" ng-if="product_detail.is_san == 1">
            <label for="">Precio SAN</label>
            <input type="text" class="form-control" ng-value="product_detail.product_san_detail_price" readonly>
        </div>
    </div>

    
    <div class="row">
        <div class="form-group col-md-4 required">
            <label>Cant. del producto</label>
            <input type="number" class="form-control" ng-model="product.amount" min="1" required>
        </div>

        <div class="form-group col-md-4" ng-if="product_detail.is_san == 1">
            <label>Cant. SAN Adicional</label>
            <select class="form-control" ng-model="product.qty_san" ng-disabled="!product.product_id && !sans.length > 0" required>
                <option value="">Seleccionar</option>
                <option ng-repeat="san in sans" ng-value="san">{{ san }}</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="">Descuento % (opcional)</label>
            <input type="number" class="form-control" ng-model="product.discount" min="0" max="100">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4">
            <label>Total c/s Descuento</label>
            <input type="text" class="form-control" ng-value="(product.amount * (product_detail.product_detail_price + (product.qty_san * product_detail.product_san_detail_price))) - ((product.amount * (product_detail.product_detail_price + (product.qty_san * product_detail.product_san_detail_price))) * product.discount/100) | number : 2" disabled>
        </div>
    </div>
</div>
<div class="modal-footer text-right">
    <button type="submit" class="btn btn-primary btn-flat">AGREGAR</button>
    <button type="button" class="btn btn-default btn-flat" ng-click="closeModal()">CERRAR</button>
</div>
</form>