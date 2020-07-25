var app = angular.module('pmediaApp.product_categories', []);

app.factory('Product_categories', ['$http', '$q', function($http, $q) {
	
	var self = {
		loading: true,
		err: false,
		data_product_categories: [],
		data_product_category: {},
		getProductCategories: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/product-categories/`
			}).then(function(resp) {
		  		self.data_product_categories = resp.data;
		  		
		  		return d.resolve();
		  	});

			return d.promise;
		},
		getProductCategory: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/product-categories/${id}`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_product_category = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		addProductCategory: function(contact) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: `${base_url}admin/product-categories/`,
				data: contact
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
				url: base_url + "admin/product-categories/privileges/"
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		saveProductCategory: function(product_category_data) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/product-categories/${product_category_data.id}`,
				data: product_category_data
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
	};

	return self;
}]);

