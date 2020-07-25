var app = angular.module('pmediaApp.sunat', []);

app.factory('Sunat', ['$http', '$q', function($http, $q) {
    let self = {
        err: false,
        message: '',
        status: '',
        data_sunat: {},
        getDataByRuc: function(doc_num) {
            var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/sunat/search/${doc_num}`,
			}).then(function(resp) {
                self.data_sunat = resp.data;
				self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

		  		return d.resolve();
		  	});

		  	return d.promise;
        },
        getDataByRucEdit: function(doc_num) {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/sunat/search-edit/${doc_num}`,
            }).then(function(resp) {
                self.data_sunat = resp.data;
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;

                return d.resolve();
            });

            return d.promise;
        }
    }

    return self;
}]);