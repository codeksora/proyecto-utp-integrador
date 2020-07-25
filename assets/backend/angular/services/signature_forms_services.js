var app = angular.module('pmediaApp.signature_forms', []);

app.factory('Signature_forms', ['$http', '$q', function($http, $q) {

    let self = {
        loading: true,
        err: false,
        data_signature_forms: [],
        getSignatureForms: function(cutomer_id) {
            let d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/signature-forms/`
            }).then(function(resp) {
                self.data_signature_forms = resp.data;

                return d.resolve(resp.data);
            });

            return d.promise;
        }
    };

    return self;
}]);