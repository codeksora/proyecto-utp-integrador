var app = angular.module('pmediaApp.login', []);

app.factory('Login', ['$http', '$q', function ($http, $q) {

	var self = {
		err: false,
		status: '',
		message: '',
		logout: function() {
			var d = $q.defer();

			$http({
                method: 'GET',
                url: base_url + "logout/"
            }).then(function(resp) {

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	}

	return self;
}]);
