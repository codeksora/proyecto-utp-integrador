var app = angular.module('pmediaApp.quotation_product_details', []);

app.factory('Quotation_product_details', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		data_order_product_details_separate: [],
		data_order_product_details: [],
		data_order_product_detail: {},
		data_product_type: {},
		// data_order_type: {},
		getProductDetailsByQuotation: function(quotation_id) {
			var d = $q.defer();

			$http.get(base_url + 'admin/quotations/' + quotation_id + '/product-details')
		  	.then(function(resp) {
                self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_order_product_details = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		getProductDetailsByQuotationSeparate: function(quotation_id) {
			var d = $q.defer();

			$http.get(base_url + 'admin/quotations/' + quotation_id + '/product-details/separate')
		  	.then(function(resp) {
                self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_quotation_product_details_separate = resp.data;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		getProductDetailsByOrderSeparate: function(order_id) {
			var d = $q.defer();

			$http.get(base_url + 'admin/orders/' + order_id + '/product-details/separate')
		  	.then(function(resp) {
                self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_order_product_details_separate = resp.data;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		getProductTypeById: function(order_product_detail_id) {
			var d = $q.defer();

			$http.get(base_url + 'admin/orders/product-type/' + order_product_detail_id)
		  	.then(function(resp) {
                // self.err = resp.data.err;
				// self.message = resp.data.message;
				// self.status = resp.data.status;
		  		self.data_product_type = resp.data.id_tipoProducto;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		getQuotationProductDetail: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/quotation-product-details/${id}`
			}).then(function(resp) {
				self.data_quotation_product_detail = resp.data;
				// self.err = resp.data.err;
				// self.message = resp.data.message;
				// self.status = resp.data.status;
				
				return d.resolve(resp.data);
			});

		  	return d.promise;
		},
	};

	return self;
}]);
