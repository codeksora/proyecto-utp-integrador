var app = angular.module('pmediaApp.quotations', []);

app.factory('Quotations', ['$http', '$q', 'Upload', function($http, $q, Upload) {

	let self = {
		message: '',
        err: false,
        status: '',
        data_quotation: {},
        data_quotations: [],
        IGV: 0,
		tax: 0,
        total: 0,
        subtotal: 0,
        getQuotation: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/quotations/" + id
			}).then(function(resp) {
				self.data_quotation = resp.data;

				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		return d.resolve();
		  	});

		  	return d.promise;
		},
        getQuotations: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/quotations/"
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_quotations = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		addQuotation: function(quotation) {
			var d = $q.defer();

      $http({
				method: 'POST',
				url: base_url + "admin/quotations/",
        data: quotation
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});
		  	return d.promise;
		},
		validateQuotation: function(quotation, quotation_id) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/quotations/${quotation_id}`,
				data: quotation
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		disableQuotation: function(quotation_id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: `${base_url}admin/quotations/${quotation_id}`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		calculate: function() {
            self.subtotal = 0;

            for(item of self.data_products) {

                item.subtotal = (item.product_detail_price + (item.product_san_detail_price * item.qty_san));

                item.discount = (item.subtotal * item.amount) * (item.discount_perc / 100);
                item.total = (item.subtotal * item.amount) - item.discount;

                self.subtotal += item.total;
            }

            self.subtotal = parseFloat(self.subtotal.toFixed(2));	
 
            self.tax = self.subtotal * self.IGV;
            self.tax = parseFloat(self.tax.toFixed(2));

			self.total = self.subtotal + self.tax;	
		},
		addProduct: function(product) { 
			self.data_products.push(product);

            self.calculate();
		},
		deleteProduct: function(index) {
            self.data_products.splice(index, 1);
            self.calculate();
        },
        getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/quotations/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
	}

	return self;

}]);