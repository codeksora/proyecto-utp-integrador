var app = angular.module('pmediaApp.roles', []);

app.factory('Roles', ['$http', '$q', function($http, $q) {
	
	var self = {
		loading: true,
		err: false,
		data_roles: [],
		data_all_roles: [],
		data_role: {}, 
		getRoles: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/roles/"
			}).then(function(resp) {
		  		self.data_roles = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		addRole: function(role) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/roles/",
				data: role
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});

	  		return d.promise;
		},
		saveRole: function(role, id) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: base_url + "admin/roles/" + id,
				data: role
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				
		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		deleteRole: function(id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: base_url + "admin/roles/" + id
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getRole: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/roles/" + id
			}).then(function(resp) {
				self.data_role = resp.data;
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				
				return d.resolve();
			});

		  	return d.promise;
		}
	};

	return self;
}]);