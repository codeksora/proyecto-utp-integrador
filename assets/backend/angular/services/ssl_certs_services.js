var app = angular.module('pmediaApp.ssl_certs', []);

app.factory('Ssl_certs', ['$http', '$q', function($http, $q) {

    let self = {
        loading: true,
        err: false,
        data_ssl_certs: [],
        getSslCertsByCustomer: function(cutomer_id) {
            let d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + "admin/customers/" + cutomer_id + "/ssl-certificates/"
            }).then(function(resp) {
                self.data_ssl_certs = resp.data;

                return d.resolve(resp.data);
            });

            return d.promise;
        },
        getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/ssl-certificates/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
        },
        assignDomainToCustomer: function(domain_customer) {
            var d = $q.defer();

            $http({
				method: 'PUT',
                url: base_url + "admin/ssl-certificates/",
                data: domain_customer
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