var app = angular.module('pmediaApp.countries', []);

app.factory('Countries', ['$http', '$q', function($http, $q) {
	
	let self = {
		loading: true,
		code: 0,
		errorMsg: '',
		err: false,
		data_countries: [],
		getCountries: function() {
			let d = $q.defer();
			// $http.get("https://restcountries.eu/rest/v2/all")
			$http({
				method: 'GET',
				url: `${base_url}admin/countries`
			}).then(function(resp) {
		  		self.data_countries = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);