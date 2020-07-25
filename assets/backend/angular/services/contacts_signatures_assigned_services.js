var app = angular.module('pmediaApp.contacts_signatures_assigned', []);

app.factory('Contacts_signatures_assigned', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_contacts_signatures_assigned: [],
		getContactsSignaturesAssigned: function(signature_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/signatures-assigned/${signature_assigned_id}/contacts/`,
			}).then(function(resp) {
				self.data_contacts_signatures_assigned = resp.data;
				
		  		return d.resolve(resp.data.data);
		  	});

			return d.promise;
		},
		addContactsSignaturesAssigned: function(contacts, contact_to_signature, signature_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: `${base_url}admin/signatures-assigned/${signature_assigned_id}/contacts/`,
				data: {
					contacts: contacts,
					contact_to_signature: contact_to_signature,
					signature_assigned_id: signature_assigned_id
				}
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		deleteContactsSignaturesAssigned: function(contact_signature_assigned_id, signature_assigned_id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: `${base_url}admin/signatures-assigned/${signature_assigned_id}/contacts/${contact_signature_assigned_id}`,
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
