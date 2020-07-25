var app = angular.module('pmediaApp.product_san_details', []);

app.factory('Product_san_details', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        message: '',
        status: '',
        data_product_san_details: [],
        data_product_san_detail: {},
        getSanDetailsByProduct: function(product_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + `admin/products/${product_id}/san-details`
            }).then(function(resp) {
                self.data_product_san_details = resp.data;

                return d.resolve();
            });

            return d.promise;
        }
    };

    return self;
}]);

