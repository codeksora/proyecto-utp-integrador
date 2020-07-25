var app = angular.module('pmediaApp.order_obs', []);

app.factory('Order_obs', ['$http', '$q', function($http, $q) {

    var self = {
        'loading': true,
        'err': false,
        'data_order_obs': [],
        addOrderObs: function(order) {
            var d = $q.defer();

            $http({
                method: 'POST',
                url: base_url + "admin/products/",
                data: product_data
            }).then(function(resp) {
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;

                return d.resolve();
            });

            return d.promise;
        },
        getOrderObs: function(order_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + 'admin/orders/' + order_id + '/observations/'
            }).then(function(resp) {
                self.data_order_obs = resp.data;

                return d.resolve();
            });

            return d.promise;
        }
    };

    return self;
}]);
