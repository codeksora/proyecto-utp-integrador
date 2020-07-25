var app = angular.module('pmediaApp.contacts_ssl_certs_assigned', []);

app.factory('Contacts_ssl_certs_assigned', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_contacts_ssl_certificates_assigned: [],
		getContactsSslCertificatesAssigned: function(ssl_cert_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned_id}/contacts/`,
			}).then(function(resp) {
				self.data_contacts_ssl_certificates_assigned = resp.data;
				
		  		return d.resolve(resp.data.data);
		  	});

			return d.promise;
		},
		addContactsSslCertificatesAssigned: function(contacts, contact_to_ssl, ssl_cert_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned_id}/contacts/`,
				data: {
					contacts: contacts,
					contact_to_ssl: contact_to_ssl,
					ssl_cert_assigned_id: ssl_cert_assigned_id
				}
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		deleteContactsSslCertificatesAssigned: function(contact_ssl_cert_assigned_id, ssl_cert_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned_id}/contacts/${contact_ssl_cert_assigned_id}`,
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
