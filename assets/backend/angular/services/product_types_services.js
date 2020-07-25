var app = angular.module('pmediaApp.product_types', []);

app.factory('Product_types', ['$http', '$q', function($http, $q) {
	
	var self = {
		loading: true,
		err: false,
		data_product_types: [],
		data_product_type: {},
		getProductTypes: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/product-types/`
			}).then(function(resp) {
		  		self.data_product_types = resp.data;
		  		
		  		return d.resolve();
		  	});

			return d.promise;
		}
	};

	return self;
}]);

