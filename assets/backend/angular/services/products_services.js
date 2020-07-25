var app = angular.module('pmediaApp.products', []);

app.factory('Products', ['$http', '$q', 'Upload', function($http, $q, Upload) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_products: [],
		data_product: {},
		data_products_by_product_type: [],
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
		getProducts: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/products/"
			}).then(function(resp) {
		  		self.data_products = resp.data.data;
				// self.data_privileges = resp.data.privileges;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		getProductsByProductType: function(product_type_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/product_types/${product_type_id}/products/`
			}).then(function(resp) {
				self.data_products_by_product_type = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		addProduct: function(product_data) {
			var d = $q.defer();

			Upload.upload({
	            url: `${base_url}admin/products/`,
	            data: product_data
	        }).then(function (resp) {
	        	self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

	        	return d.resolve();
	           
	        }, function (resp) {
	            //console.log('Error status: ');
	        }, function (evt) {
	           // console.log('progress: ');
	        });

		  	return d.promise;
		},
		saveProduct: function(product_data) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: base_url + "admin/products/" + product_data.id,
				data: product_data
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		saveInfoDocument: function(product_data) {
			var d = $q.defer();

		  	Upload.upload({
	            url: `${base_url}admin/products/${product_data.id}/information-document`,
	            data: product_data,
	        }).then(function (resp) {
	        	self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

	        	return d.resolve();
	           
	        }, function (resp) {
	            //console.log('Error status: ');
	        }, function (evt) {
	           // console.log('progress: ');
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
