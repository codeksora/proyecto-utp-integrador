var app = angular.module('pmediaApp.sectors', []);

app.factory('Sectors', ['$http', '$q', function($http, $q) {
	
	let self = {
		loading: true,
		err: false,
		data_sectors: [],
		getSectors: function() {
			let d = $q.defer();
			$http({
				method: 'GET',
				url: `${base_url}admin/sectors`
			}).then(function(resp) {
		  		self.data_sectors = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);