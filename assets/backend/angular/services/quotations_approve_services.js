var app = angular.module('pmediaApp.quotations_approve', []);

app.factory('Quotations_approve', ['$http', '$q', 'Upload', function($http, $q, Upload) {

	let self = {
		message: '',
        err: false,
        status: '',
        data_quotation: {},
        data_quotations: [],
        IGV: 0,
		tax: 0,
        total: 0,
        subtotal: 0,
  //       getQuotation: function(id) {
		// 	var d = $q.defer();

		// 	$http({
		// 		method: 'GET',
		// 		url: base_url + "admin/quotations/" + id
		// 	}).then(function(resp) {
		// 		self.data_order = resp.data;

		// 		self.err = resp.data.err;
		// 		self.message = resp.data.message;
		// 		self.status = resp.data.status;
		//   		return d.resolve();
		//   	});

		//   	return d.promise;
		// },
        getQuotationsPending: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/quotations-approve/dt/"
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				self.data_quotations_pending = resp.data;

				return d.resolve();
			});

			return d.promise;
		},
		approveQuotation: function(quotation_id) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/quotations-approve/${quotation_id}`
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		approveAllQuotations: function() {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: `${base_url}admin/quotations-approve/all`
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
				url: base_url + "admin/quotations-approve/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
	}

	return self;

}]);