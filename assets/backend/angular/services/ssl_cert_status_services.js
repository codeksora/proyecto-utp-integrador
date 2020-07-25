var app = angular.module('pmediaApp.ssl_cert_status', []);

app.factory('Ssl_cert_status', ['$http', '$q', function($http, $q) {
	
	let self = {
		loading: true,
		err: false,
		data_ssl_cert_status: [],
		getSslCertStatus: function() {
            let d = $q.defer();
            
			$http({
				method: 'GET',
				url: `${base_url}admin/ssl-cert-status`
			}).then(function(resp) {
		  		self.data_ssl_cert_status = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);