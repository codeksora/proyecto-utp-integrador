var app = angular.module('pmediaApp.product_details', []);

app.factory('Product_details', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        message: '',
        status: '',
        data_product_details: [],
        data_product_detail: {},
        getProductDetailsByCurrencyType: function(currency_type_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + `admin/product-details/currency-type/${currency_type_id}`
            }).then(function(resp) {
                self.data_product_details = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        getProductDetailById: function(product_price_id, currency_type_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + `admin/product-details/${product_price_id}/currency-type/${currency_type_id}`
            }).then(function(resp) { 
                self.data_product_detail = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        getDetailsByProduct: function(product_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + `admin/products/${product_id}/details`
            }).then(function(resp) {
                self.data_product_details = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        saveProductDetailsByProduct: function(product_id) {
            var d = $q.defer();

            $http({
                method: 'PUT',
                url: base_url + `admin/products/${product_id}/details`
            }).then(function(resp) {
                self.data_product_details = resp.data;

                return d.resolve();
            });

            return d.promise;
        }
    };

    return self;
}]);

