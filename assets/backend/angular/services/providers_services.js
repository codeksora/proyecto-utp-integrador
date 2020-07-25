var app = angular.module('pmediaApp.providers', []);

app.factory('Providers', ['$http', '$q', function($http, $q) {
	
	var self = {
		loading: true,
		err: false,
		data_providers: [],
		data_provider: {},
		getProvider: function(provider_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/providers/${provider_id}`
			}).then(function(resp) {
		  		self.data_provider = resp.data;
		  		
		  		return d.resolve();
		  	});

			return d.promise;
		},
		getProviders: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/providers/"
			}).then(function(resp) {
		  		self.data_providers = resp.data;
		  		
		  		return d.resolve();
		  	});

			return d.promise;
		},
		getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/providers/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		addProvider: function(provider) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: `${base_url}admin/providers/`,
				data: provider
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		saveProvider: function(provider) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/providers/${provider.id}`,
				data: provider
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		deleteProvider: function(provider_id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: `${base_url}admin/providers/${provider_id}`
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

