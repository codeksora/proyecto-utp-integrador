var app = angular.module('login.loginService', []);

app.factory('LoginService', ['$http', '$q', ($http, $q) => {

	let self = {
		err: false,
		status: '',
		message: '',
		user_data: {},
		data_user_remember: {},
		login: data => {
			var d = $q.defer();

				$http({
					method: 'POST',
					url: base_url + "auth/",
					data: data
				}).then((resp) => {
					self.user_data = resp.data.user_data;
					self.err = resp.data.err;
					self.status = resp.data.status;
					self.message = resp.data.message;

					return d.resolve();
				});

			return d.promise;
		},
		remember_me: () => {
			var d = $q.defer();

				$http({
					method: 'GET',
					url: base_url + "remember_me/"
				}).then(function(resp) {
					self.data_user_remember = resp.data;

					return d.resolve();
				});

			return d.promise;
		}
	}

	return self;
}]);