var app = angular.module('pmediaApp.order_products', []);

app.factory('Order_products', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        // data_order_detail: [],
        data_products: [],
        getOrderDProductsByOrder: function(order_id) {
            var d = $q.defer();

            $http.get(base_url + 'admin/orders/' + order_id + '/products')
                .then(function(resp) {
                    self.err = resp.data.err;
                    self.message = resp.data.message;
                    self.status = resp.data.status;
                    self.data_products = resp.data;

                    return d.resolve();
                });

            return d.promise;
        }
    };

    return self;
}]);
