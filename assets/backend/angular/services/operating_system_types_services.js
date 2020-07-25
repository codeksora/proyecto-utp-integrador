var app = angular.module('pmediaApp.operating_system_types', []);

app.factory('Operating_system_types', ['$http', '$q', function($http, $q) {
	
	let self = {
		loading: true,
		err: false,
		data_operating_system_typess: [],
		getOperatingSystemTypes: function() {
			let d = $q.defer();
			$http({
				method: 'GET',
				url: `${base_url}admin/operating-system-types`
			}).then(function(resp) {
		  		self.data_operating_system_types = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);