var app = angular.module('pmediaApp.users', []);

app.factory('Users', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_users: [],
		data_user: {},
		getUsers: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/users/"
			}).then(function(resp) {
		  		self.data_users = resp.data;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		addUser: function(user) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/users/",
				data: user
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});

	  		return d.promise;
		},
		saveUser: function(user, id) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: base_url + "admin/users/" + id,
				data: user
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				
		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		deleteUser: function(id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: base_url + "admin/users/" + id
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getUser: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/users/" + id
			}).then(function(resp) {
				self.data_user = resp.data;
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				
				return d.resolve();
			});

		  	return d.promise;
		},
		getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/users/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
	};

	return self;
}]);
