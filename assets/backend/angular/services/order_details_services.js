var app = angular.module('pmediaApp.order_details', []);

app.factory('Order_details', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        data_order_detail: [],
        // data_order_type: {},
        getOrderDetails: function(order_id) {
            var d = $q.defer();

            $http.get(base_url + 'admin/orders/' + order_id + '/details')
                .then(function(resp) {
                    self.err = resp.data.err;
                    self.message = resp.data.message;
                    self.status = resp.data.status;
                    self.data_order_details = resp.data;

                    return d.resolve();
                });

            return d.promise;
        }
    };

    return self;
}]);
