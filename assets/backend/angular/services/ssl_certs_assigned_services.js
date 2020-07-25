var app = angular.module('pmediaApp.ssl_certs_assigned', []);

app.factory('Ssl_certs_assigned', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		errors: [],
		data_ssl_certs_assigned: [],
        data_ssl_cert_assigned: {},
        data_privileges: {},
        getSslCertsAssignedByOrder: function(order_id) {
        	var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/orders/${order_id}/ssl-certificates-assigned/`
            }).then(function(resp) {
                self.data_ssl_certs_assigned = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        getSslCertAssigned: function(id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/ssl-certificates-assigned/${id}`
            }).then(function(resp) {
                self.data_ssl_cert_assigned = resp.data;

                return d.resolve();
            });

            return d.promise;
		},
		getSslCertAssignedBySslCertStatusId: function(ssl_certificate_status_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
				url: `${base_url}admin/ssl-certificates-assigned/`,
				params: {
					'search[ssl_certificate_status_id]': ssl_certificate_status_id,
					'search[value]': ''
				}
            }).then(function(resp) {
                self.data_ssl_certs_assigned = resp.data;
                return d.resolve();
            });

            return d.promise;
		},
		addSslCertsAssigned: function(ssl_cert_assigned) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/ssl-certificates-assigned/",
				data: ssl_cert_assigned
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				

				return d.resolve();
			});

	  		return d.promise;
		},
		sendToForm: function(contacts, ssl_cert_assigned_id, skip) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned_id}/send-to-form`,
				data: {
					contacts,
					skip
				}
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});

			return d.promise;
		},
		sendToValidate: function(ssl_cert_assigned) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned.id}/send-to-validate`,
				data: ssl_cert_assigned
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});

			return d.promise;
		},
		sendToIssue: function(ssl_cert_assigned) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned.id}/send-to-issue`,
				data: ssl_cert_assigned
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});

			return d.promise;
		},
		sendToInstall: function(ssl_cert_assigned) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned.id}/send-to-install`,
				data: ssl_cert_assigned
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.errors = resp.data.errors;

				return d.resolve();
			});

			return d.promise;
		},
		sendToInstalled: function(ssl_cert_assigned) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned.id}/send-to-installed`,
				data: ssl_cert_assigned
			}).then(function(resp) {
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
				url: `${base_url}admin/ssl-certificates-assigned/privileges/`
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
	};

	return self;
}]);
