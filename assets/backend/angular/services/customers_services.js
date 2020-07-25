var app = angular.module('pmediaApp.customers', []);

app.factory('Customers', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		code: 0,
		errorMsg: '',
		err: false,
		data_customers: [],
		data_customer: {},
		data_quantity_customers: {},
		pages: [],
		getCustomers: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/customers/`
			}).then(function(resp) {
		  		self.data_customers = resp.data;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		addCustomer: function(customer) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: `${base_url}admin/customers/`,
				data: customer
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		saveCustomer: function(customer) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/customers/${customer.id}`,
				data: customer
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		deleteCustomer: function(customer_id) {
			var d = $q.defer();

			$http({
				method: 'DELETE',
				url: `${base_url}admin/customers/${customer_id}`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getCustomer: function(customer_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/customers/${customer_id}`
			}).then(function(resp) {
		  		self.data_customer = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/customers/privileges/`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		getQuantityCustomers: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/customers/quantity"
			}).then(function(resp) {
				self.data_quantity_customers = resp.data;

				return d.resolve(resp.data);
			});

			return d.promise;
		},
		getCustomerByRuc: function(ruc) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/customers/ruc/${ruc}`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},

	};

	return self;
}]);
