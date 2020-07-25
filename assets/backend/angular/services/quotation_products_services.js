var app = angular.module('pmediaApp.quotation_products', []);

app.factory('Quotation_products', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        // data_order_detail: [],
        data_products: [],
        getQuotationProductsByQuotation: function(quotation_id) {
            var d = $q.defer();

            $http.get(base_url + 'admin/quotations/' + quotation_id + '/products')
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
