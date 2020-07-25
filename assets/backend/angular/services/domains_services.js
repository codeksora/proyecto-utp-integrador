var app = angular.module('pmediaApp.domains', []);

app.factory('Domains', ['$http', '$q', function($http, $q) {
	
	let self = {
		message: '',
        err: false,
        status: '',
        data_domains: [],
		data_privileges: {},
		data_customers: [],
		getDomains: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/domains/"
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_domains = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		addDomain: function(domain) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/domains/",
				data: domain
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
				url: base_url + "admin/domains/privileges/"
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		getCustomersByDomain: function(domain_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/domains/${domain_id}/customers`
			}).then(function(resp) {
		  		self.data_customers = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
	};

	return self;
}]);