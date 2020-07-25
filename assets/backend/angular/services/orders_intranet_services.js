var app = angular.module('pmediaApp.orders_intranet', []);

app.factory('Orders_intranet', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
    	data_orders: [],
		data_order: {},
		data_order_details: [],
		data_order_firms: [],
		data_order_observations: [],
		data_order_products: [],
		data_customer: {},
		data_perusecurity: {},
		getOrder: function(order_id) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/orders-intranet/" + order_id
			}).then(function(resp) {
				self.data_order = resp.data.order;
				self.data_customer = resp.data.customer;
				self.data_perusecurity = resp.data.perusecurity;

				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		getProductsByOrder: function(order_id) {
			var d = $q.defer();

			$http.get(base_url + 'admin/orders-intranet/' + order_id + '/products')
		  	.then(function(resp) {
		  		self.data_order_products = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		getOrders: function(recDateStart, recDateEnd) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/orders-intranet/",
				params: {
					recDateStart: recDateStart,
					recDateEnd: recDateEnd
				}
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		self.data_orders = resp.data;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		},
		getOrdersByFilter: function(customer, n_fact, startRec, endRec) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + 'admin/orders/filter',
				params: {
					customer: customer,
					n_fact: n_fact,
					startRec: startRec,
					endRec: endRec
				}
			}).then(function(resp) {
				// self.err = resp.data.err;
				// self.message = resp.data.message;
				// self.status = resp.data.status;
				// self.data_orders = resp.data;

				return d.resolve(resp.data);
			});

			return d.promise;
		},
		addProduct: function(product) {
			var d = $q.defer();

			$http.post(base_url + "admin/admin_products/add/", product)
		  	.then(function(resp) {

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		addOrderObs: function(user) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/orders_obs/",
				data: {
					user: user, 
					order: self.data_order 
				}
			})
		  	.then(function(resp) {
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
