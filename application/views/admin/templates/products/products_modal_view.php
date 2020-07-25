<div class="modal-header bg-blue">
    <button type="button" class="close" ng-click="closeModal()">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>DETALLE DEL PRODUCTO</strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-3">
            <label>Proveedor</label>
            <input type="text" class="form-control" ng-value="product.provider_name" readonly>
        </div>
        <div class="form-group col-md-3">
            <label>Tipo de producto</label>
            <input type="text" class="form-control" ng-value="product.product_type_name" readonly>
        </div>
        <div class="form-group col-md-3">
            <label>Nombre del producto</label>
            <input type="text" class="form-control" ng-value="product.name" readonly>
        </div>

        <div class="form-group col-md-3">
            <label>Ficha Técnica</label>
            <a ng-if="product.information_document" class="btn btn-block bg-purple btn-flat" href="<?php echo site_url('product_docs'); ?>{{ product.information_document }}" target="_blank"><i class="fa fa-download"></i> Clic aquí para descargar</a>
            <button type="button" ng-if="!product.information_document" class="btn btn-block bg-purple btn-flat" disabled>No tiene ficha técnica</button>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            <label>Descripción</label>
            <textarea class="form-control" ng-value="product.description" rows="7" readonly></textarea>
        </div>
    </div>

    <div class="row" ng-if="product_details.length > 0">
        <div class="form-group col-md-6" ng-repeat="product_detail in product_details">
            <label for="">{{ product_detail.quantity_year_description }} (dólares)</label>
            <input type="text" class="form-control" ng-value="product_detail.price | currency: 'US$ '" readonly>
        </div>
    </div>
  
  <div class="row" ng-if="product_details.length > 0">
        <div class="form-group col-md-6" ng-repeat="product_detail in product_details">
            <label for="">{{ product_detail.quantity_year_description }} (soles)</label>
            <input type="text" class="form-control" ng-value="product_detail.price_pen | currency: 'S/. '" readonly>
        </div>
    </div>

    <div class="row" ng-if="product.is_san == 1">
        <div class="form-group col-md-3">
            <label for="">SAN base</label>
            <input type="text" class="form-control" ng-value="product.san_base" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="">SAN máx.</label>
            <input type="text" class="form-control" ng-value="product.san_max" readonly>
        </div>
      
      <div class="col-md-12">
        <div class="row">
          <div class="form-group col-md-6" ng-repeat="product_san_detail in product_san_details">
              <label for="">SAN {{ product_san_detail.quantity_year_description }} (dolares)</label>
              <input type="text" class="form-control" ng-value="product_san_detail.price | currency: 'US$ '" readonly>
          </div>
        </div>
        
        <div class="row">
          <div class="form-group col-md-6" ng-repeat="product_san_detail in product_san_details">
            <label for="">SAN {{ product_san_detail.quantity_year_description }} (soles)</label>
            <input type="text" class="form-control" ng-value="product_san_detail.price_pen | currency: 'S/. '" readonly>
        </div>
        </div>
      </div>

    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Producto creado por</label>
            <input type="text" class="form-control" ng-value="product.user_full_name" readonly>
        </div>

        <div class="form-group col-md-6">
            <label>Fecha de creación</label>
            <input type="text" class="form-control" ng-value="product.created_at | date: 'dd/MM/yyyy @ HH:mm:ss'" readonly>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-right" ng-click="closeModal()">CERRAR</button>
</div>