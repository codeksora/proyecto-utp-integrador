var app = angular.module('pmediaApp.configurations', []);

app.factory('Configurations', ['$http', '$q', function($http, $q) {
	
	var self = {
		config: {},
		load: function() {
			var d = $q.defer();

			$http.get(base_url + "admin/configurations")
			.then(function(resp) {

					self.config = resp.data;
					d.resolve();

				}, 
				function() {
					d.reject();
					console.error("No se pudo cargar el archivo de configuración");
				});

			return d.promise;
		},
		saveConfig: function(config) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/configurations/`,
				data: config
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
}])