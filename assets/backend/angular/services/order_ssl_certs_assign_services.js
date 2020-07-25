var app = angular.module('pmediaApp.order_ssl_certs_assign', []);

app.factory('Order_ssl_certs_assign', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		data_order_ssl_certs_assign: [],
		// data_order_type: {},
		getSslCertsByOrder: function(order_id) {
			var d = $q.defer();

			$http.get(base_url + 'admin/orders/' + order_id + '/ssl-certificates-assigned')
		  	.then(function(resp) {
                self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_order_ssl_certs_assign = resp.data;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		addSslCert: function(order_id, cert_id, product_id) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + 'admin/orders/' + order_id + '/ssl-certificates-assigned',
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
