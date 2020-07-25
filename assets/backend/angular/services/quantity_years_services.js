var app = angular.module('pmediaApp.quantity_years', []);

app.factory('Quantity_years', ['$http', '$q', function($http, $q) {
	
	let self = {
		loading: true,
		err: false,
		data_quantity_years: [],
		getQuantityYears: function() {
			let d = $q.defer();
			$http({
				method: 'GET',
				url: `${base_url}admin/quantity-years`
			}).then(function(resp) {
		  		self.data_quantity_years = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);