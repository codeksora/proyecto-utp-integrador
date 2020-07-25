<div class="modal-header bg-blue">
	<button type="button" class="close" ng-click="closeModal()">
	<span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title"><strong>DETALLE DE LA COTIZACIÓN</strong></h4>
</div>
<div class="modal-body">
	<div class="row">
	  <div class="form-group col-md-4">
	    <label>Moneda</label>
	    <input type="text" class="form-control" ng-value="quotation.currency_type_name" readonly>
	  </div>

	  <div class="form-group col-md-4">
	    <label>Documento de cotización</label>
	    <a href="<?php echo base_url(); ?>{{ quotation.quotation_template_id == null ? 'assets/backend/pdfs/' + quotation.quotation_document : 'admin/quotations/' + quotation.id + '/document/' }}" class="btn btn-block bg-purple btn-flat" target="_blank"><i class="fa fa-download"></i> Ver documento</a>
	  </div>
	</div>

	<div class="row">
	  <div class="col-md-12">
	    <table datatable="ng" dt-options="dtOptionsDetails" dt-instance="dtInstanceDetails" class="table table-hover table-bordered table-striped">
	        <thead>
	            <tr>
	                <th>Producto</th>
	                <th>Cantidad</th>
					<th>Subtotal</th>
					<th>Descuento</th>
					<th>Total</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr ng-repeat="(key, product) in products">
	                <td>{{ product.concept_name }} de {{ product.product_name }}
						{{ product.quantity_year_id == 1 ? '' : ' por ' + product.quantity_year_name }}
						{{ product.qty_san == 0 ? '' : ' + ' + product.qty_san + ' SAN' }}
					</td>
	                <td>{{ product.amount }}</td>
					<td>{{ product.subtotal | currency: product.currency_type_symbol + ' ' }}</td>
					<td>{{ product.discount | currency: product.currency_type_symbol + ' ' }}</td>
					<td>{{ product.total | currency: product.currency_type_symbol + ' ' }}</td>
	            </tr>
	        </tbody>
	    </table>
	  </div>
	</div>

	<div class="row">
	  <div class="col-md-6 col-md-offset-6">
	    <table class="table">
	      <tbody>
	      <tr>
	        <th style="width:50%">Subtotal:</th>
	        <td>{{ quotation.subtotal | currency: quotation.symbol + ' ' }}</td>
	      </tr>
	      <tr>
	        <th>I.G.V.:</th>
	        <td>{{ quotation.tax | currency: quotation.symbol + ' ' }}</td>
	      </tr>
	      <tr>
	        <th>Total:</th>
	        <td>{{ quotation.total | currency: quotation.symbol + ' ' }}</td>
	      </tr>
	    </tbody>
	    </table>
	  </div>
	</div>

<!-- <div class="row">
  <div class="col-md-12">
    <h2 class="page-header"><i class="fa fa-chevron-circle-right"></i> Historial de comentarios</h2>
  </div>
  <div class="col-md-12">
    <div class="box box-success">
      <div class="chat" id="chat-box">
        <div class="item" ng-repeat="order_ob in order_obs">
          <img src="/dist/img/avatar5.png" alt="user image" class="online">

          <p class="message">
            <a href="#" class="name">
              <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{ order_ob.created_at | date: 'dd/MM/yyyy HH:mm:ss' : 'UTC' }}</small>
              {{ order_ob.full_name }}
            </a>
            {{ order_ob.message }}
          </p>
        </div>
      </div>

      <div class="box-footer">
        <form name="frmObs" id="frmObs" ng-submit="addObs(obs, order)" novalidate="novalidate">
          <div class="form-group">
            <textarea class="form-control" ng-model="obs.message" rows="5" required></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-danger" ng-if="isDisabled" ng-disabled="frmObs.$invalid == isDisabled"><i class="fa fa-plus"></i> Añadir comentario</button>
            <button type="button" class="btn btn-danger" ng-if="!isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> -->
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default pull-right" ng-click="closeModal()">Cerrar</button>
</div>