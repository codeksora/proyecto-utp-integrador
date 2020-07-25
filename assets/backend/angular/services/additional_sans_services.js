var app = angular.module('pmediaApp.additional_sans', []);

app.factory('Additional_sans', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        data_additional_sans: [],
        // data_order_type: {},
        getAdditionalSansBySslCertificateAssigned: function(ssl_certificate_assigned_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/ssl-certificates-assigned/${ssl_certificate_assigned_id}/additional-sans`
            }).then(function(resp) {
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;
                self.data_additional_sans = resp.data;

                return d.resolve();
            });

            return d.promise;
        }
    };

    return self;
}]);
