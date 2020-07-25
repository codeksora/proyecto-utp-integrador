var app = angular.module('pmediaApp.privileges', []);

app.factory('Privileges', ['$http', '$q', function($http, $q) {
	
	var self = {
		loading: true,
		err: false,
		data_privileges: [],
		data_privilege: {},
		getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/privileges/"
			}).then(function(resp) {
		  		self.data_privileges = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		getPrivilegesByRole: function(role_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/roles/${role_id}/privileges/`
			}).then(function(resp) {
		  		self.data_privileges = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		addPrivilege: function(privilege) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/privileges/",
				data: privilege
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});

		  	return d.promise;
		},
		savePrivilege: function(privilege, id) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: base_url + "admin/privileges/" + id,
				data: privilege
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				
		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		deletePrivilege: function(id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: base_url + "admin/privileges/" + id
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getPrivilege: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/privileges/" + id
			}).then(function(resp) {
				self.data_privilege = resp.data;
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