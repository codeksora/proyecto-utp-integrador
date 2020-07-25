var app = angular.module('pmediaApp.order_firm_certs_assign', []);

app.factory('Order_firm_certs_assign', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		data_order_firm_certs: [],
		// data_order_type: {},
		getFirmCertsByOrder: function(order_id) {
			var d = $q.defer();

			$http.get(base_url + 'admin/orders/' + order_id + '/firms-assigned')
		  	.then(function(resp) {
                self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_order_firm_certs = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		addFirmCert: function(order_id, cert_id, product_id) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + 'admin/orders/' + order_id + '/firms-assigned',
				data: {
					cert_id: cert_id,
					product_id: product_id
				}
			}).then(function(resp) {
				// self.err = resp.data.err;
				// self.message = resp.data.message;
				// self.status = resp.data.status;

				return d.resolve();
			});


			return d.promise;
		}
	};

	return self;
}]);
