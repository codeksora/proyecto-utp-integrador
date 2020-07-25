var app = angular.module('pmediaApp.comments_ssl_certs_assigned', []);

app.factory('Comments_ssl_certs_assigned', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_comments_ssl_certificates_assigned: [],
		getCommentsSslCertificatesAssigned: function(ssl_cert_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned_id}/comments/`,
			}).then(function(resp) {
				self.data_comments_ssl_certificates_assigned = resp.data;
				
		  		return d.resolve();
		  	});

			return d.promise;
		},
		addCommentsSslCertificatesAssigned: function(comment, ssl_cert_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned_id}/comments/`,
				data: {
          comment,
					ssl_cert_assigned_id
				}
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

			return d.promise;
		},
// 		deleteContactsSslCertificatesAssigned: function(contact_ssl_cert_assigned_id, ssl_cert_assigned_id) {
// 			var d = $q.defer();

// 			$http({
// 				method: 'DELETE',
// 				url: `${base_url}admin/ssl-certificates-assigned/${ssl_cert_assigned_id}/contacts/${contact_ssl_cert_assigned_id}`,
// 			}).then(function(resp) {
// 				self.err = resp.data.err;
// 				self.message = resp.data.message;
// 				self.status = resp.data.status;

// 		  		return d.resolve();
// 		  	});

// 			return d.promise;
// 		}
	};

	return self;
}]);
