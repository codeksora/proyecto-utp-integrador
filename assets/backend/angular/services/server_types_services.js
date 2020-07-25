var app = angular.module('pmediaApp.server_types', []);

app.factory('Server_types', ['$http', '$q', function($http, $q) {
	
	let self = {
		loading: true,
		err: false,
		data_server_types: [],
		getServerTypes: function() {
			let d = $q.defer();
			$http({
				method: 'GET',
				url: `${base_url}admin/server-types`
			}).then(function(resp) {
		  		self.data_server_types = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);