var app = angular.module('pmediaApp.signatures_assigned', []);

app.factory('Signatures_assigned', ['$http', '$q', function($http, $q) {

    let self = {
        loading: true,
        err: false,
        data_signature_assigned: {},
        data_signatures_assigned: [],
        getSignaturesAssignedByOrder: function(order_id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/orders/${order_id}/signatures-assigned/`
            }).then(function(resp) {
                self.data_signatures_assigned = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        getSignatureAssigned: function(id) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/signatures-assigned/${id}`
            }).then(function(resp) {
                self.data_signature_assigned = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        addSignatureAssigned: function(signature_assigned) {
            var d = $q.defer();

            $http({
                method: 'POST',
                url: base_url + "admin/signatures-assigned/",
                data: signature_assigned
            }).then(function(resp) {
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;

                return d.resolve();
            });

            return d.promise;
        },
        sendToInstall: function(signature_assigned) {
            var d = $q.defer();

            $http({
                method: 'PUT',
                url: `${base_url}admin/signatures-assigned/${signature_assigned.id}/send-to-install`,
                data: signature_assigned
            }).then(function(resp) {
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;

                return d.resolve();
            });

            return d.promise;
        },
        getPrivileges: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/signatures-assigned/privileges/`
			}).then(function(resp) {
				self.data_privileges = resp.data;

				return d.resolve();
			});

			return d.promise;
		}
    };

    return self;
}]);