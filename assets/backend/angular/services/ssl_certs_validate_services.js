var app = angular.module('pmediaApp.ssl_certs_validate', []);

app.factory('Ssl_certs_validate', ['$http', '$q', function($http, $q) {

    let self = {
        loading: true,
        err: false,
        data_ssl_certs_validate: [],
        getSslCertsValidate: function() {
            let d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + "admin/ssl-certificates-validate/"
            }).then(function(resp) {
                self.data_ssl_certs_validate = resp.data;

                return d.resolve(resp.data);
            });

            return d.promise;
        },
        getSslCertValidate: function(id) {
            let d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + "admin/ssl-certificates-validate/" + id
            }).then(function(resp) {
                self.data_ssl_cert_validate = resp.data;

                return d.resolve(resp.data);
            });

            return d.promise;
        },
        getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/ssl-certificates-validate/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
        },
        validateSslCert: function(ssl_cert) {
            var d = $q.defer();

            $http({
				method: 'PUT',
                url: `${base_url}admin/ssl-certificates-validate/`,
                data: ssl_cert
			}).then(function(resp) {
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