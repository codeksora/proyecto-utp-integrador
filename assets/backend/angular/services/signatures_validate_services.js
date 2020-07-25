var app = angular.module('pmediaApp.signatures_validate', []);

app.factory('Signatures_validate', ['$http', '$q', function($http, $q) {

    let self = {
        loading: true,
        err: false,
        data_signature_validate: {},
        data_signatures_validate: [],
        getSignaturesValidate: function() {
            let d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + "admin/signatures-validate/"
            }).then(function(resp) {
                self.data_signatures_validate = resp.data;

                return d.resolve(resp.data);
            });

            return d.promise;
        },
        getSignatureValidate: function(id) {
            let d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + "admin/signatures-validate/" + id
            }).then(function(resp) {
                self.data_signature_validate = resp.data;

                return d.resolve(resp.data);
            });

            return d.promise;
        },
        getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/signatures-validate/privileges/"
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
        },
        validateSignature: function(signature) {
            var d = $q.defer();

            $http({
				method: 'PUT',
                url: `${base_url}admin/signatures-validate/`,
                data: signature
			}).then(function(resp) {
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

				return d.resolve();
			});

            return d.promise;
        }
    };

    return self;
}]);