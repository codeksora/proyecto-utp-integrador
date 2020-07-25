var app = angular.module('pmediaApp.order_types', []);

app.factory('Order_types', ['$http', '$q', function($http, $q) {

	var self = {
		'loading': true,
		'err': false,
		'data_order_types': [],
		'data_order_type': {},
		getOrderTypes: function() {
			var d = $q.defer();

			$http.get(base_url + "admin/order-types/")
		  	.then(function(resp) {
		  		self.data_order_types = resp.data;

		  		return d.resolve();
		  	});

			return d.promise;
		},
		// addUser: function(user) {
		// 	var d = $q.defer();
    //
		// 	$http.post(base_url + "admin/admin_users/add/", user)
		//   	.then(function(resp) {
    //
		//   		return d.resolve();
		//   	});
    //
		//   	return d.promise;
		// },
		// saveUser: function(user) {
		// 	var d = $q.defer();
    //
		// 	$http.post(base_url + "admin/admin_users/update/", user)
		//   	.then(function(resp) {
    //
		//   		return d.resolve();
		//   	});
    //
		//   	return d.promise;
		// },
		// deleteUser: function(id) {
		// 	var d = $q.defer();
    //
		// 	$http.post(base_url + "admin/admin_users/delete/", {id: id})
		//   	.then(function(resp) {
    //
		//   		return d.resolve();
		//   	});
    //
		//   	return d.promise;
		// },
		// getUser: function(id) {
		// 	var d = $q.defer();
    //
		// 	$http.get(base_url + "admin/admin_users/user/" + id)
		//   	.then(function(resp) {
    //
		//   		self.data_user = resp.data;
    //
		//   		return d.resolve();
		//   	});
    //
		//   	return d.promise;
		// }
	};

	return self;
}]);
