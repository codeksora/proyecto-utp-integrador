var app = angular.module('pmediaApp.contacts', []);

app.factory('Contacts', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_contact: {},
		data_contacts: [],
		getContacts: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/contacts/`
			}).then(function(resp) {
				// self.err = resp.data.err;
				// self.message = resp.data.message;
				// self.status = resp.data.status;
		  		self.data_contacts = resp.data.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getContact: function(id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/contacts/${id}`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_contact = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getContactsByCustomer: function(customer_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/customers/${customer_id}/contacts`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_contacts = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		addContact: function(contact) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: `${base_url}admin/contacts/`,
				data: contact
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		save: function(contact_data) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/contacts/${contact_data.id}`,
				data: contact_data
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		deleteContact: function(contact_id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: `${base_url}admin/contacts/${contact_id}`
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
				url: `${base_url}admin/contacts/privileges/`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
	};

	return self;
}]);
