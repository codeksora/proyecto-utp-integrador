var app = angular.module('pmediaApp.customer_contacts', []);

app.factory('Customer_contacts', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        data_customer_contacts: [],
        // data_order_type: {},
        getContactsByCustomer: function(customer_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/customers/${customer_id}/contacts`
            }).then(function(resp) {
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;
                self.data_customer_contacts = resp.data;

                return d.resolve();
            });

            return d.promise;
        }
    };

    return self;
}]);
