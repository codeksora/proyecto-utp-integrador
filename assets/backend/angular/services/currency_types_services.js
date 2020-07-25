var app = angular.module('pmediaApp.currency_types', []);

app.factory('Currency_types', ['$http', '$q', function($http, $q) {

	var self = {
		'loading': true,
		'err': false,
		'data_currency_types': [],
		'data_currency_type': {},
		getCurrencyTypes: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/currency-types/"
			}).then(function(resp) {
		  		self.data_currency_types = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		}
	};

	return self;
}]);
