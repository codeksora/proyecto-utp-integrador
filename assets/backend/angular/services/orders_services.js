var app = angular.module('pmediaApp.orders', []);

app.factory('Orders', ['$http', '$q', 'Upload', function($http, $q, Upload) {

	var self = {
		loading: true,
		err: false,
    	data_orders: [],
		data_order: {},
		data_order_details: [],
		data_order_firms: [],
		data_order_observations: [],
		data_products: [],
		IGV: 0,
		tax: 0,
        total: 0,
        subtotal: 0,
		getOrder: function(id) {
			var d = $q.defer();

			$http.get(base_url + "admin/orders/" + id)
		  	.then(function(resp) {
				self.data_order = resp.data;

				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		// getOrdersFilter: function(filter) {
		// 	var d = $q.defer();
		//
		// 	$http({
		// 		method: 'GET',
		// 		url: base_url + "admin/orders/filter/",
		// 		params: {
		// 			customer: filter.customer
		// 		}
		// 	}).then(function(resp) {
		//   		self.data_orders = resp.data;
		//
		//   		return d.resolve();
		//   	});
		//
		// 	return d.promise;
		// },
		getOrders: function(recDateStart, recDateEnd) {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/orders/",
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
		addOrderObs: function(user) {
			var d = $q.defer();

			$http({
				method: 'POST',
				url: base_url + "admin/orders-obs/",
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
		saveOrder: function(order_data) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: base_url + "admin/orders/" + order_data.id,
				data: order_data
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;
				
		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		calculate: function() {
            self.subtotal = 0;

            for(item of self.data_products) {

                item.subtotal = (item.product_detail_price * item.amount) + (item.product_san_detail_price * item.qty_san);

                item.discount = item.subtotal * (item.discount_perc / 100);
                item.total = item.subtotal - item.discount;

                self.subtotal += item.total;
            }

            self.subtotal = parseFloat(self.subtotal.toFixed(2));	
 
            self.tax = self.subtotal * self.IGV;
            self.tax = parseFloat(self.tax.toFixed(2));

			self.total = self.subtotal + self.tax;	
		},
		addProduct: function(product) { 
			self.data_products.push(product);

            self.calculate();
		},
		deleteProduct: function(index) {
            self.data_products.splice(index, 1);
            self.calculate();
        },
        getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/orders/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
	};

	return self;
}]);
