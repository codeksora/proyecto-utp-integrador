var app = angular.module('pmediaApp.phone_codes', []);

app.factory('Phone_codes', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_phone_codes: [],
		data_phone_code: {},
		getProduct: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/products/" + id
			}).then(function(resp) {
				self.data_user = resp.data;
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_product = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getPhoneCodes: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/phone-codes/`
			}).then(function(resp) {
		  		self.data_phone_codes = resp.data;
				// self.data_privileges = resp.data.privileges;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		addProduct: function(product_data) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/products/",
				data: product_data
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		saveProduct: function(product_data, product_prices_data) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: base_url + "admin/products/" + product_data.id,
				data: {
					product: product_data,
					product_prices: product_prices_data
				}
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		deleteProduct: function(product_id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: base_url + "admin/products/" + product_id
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/products/privileges/"
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
	};

	return self;
}]);
