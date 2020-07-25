var app = angular.module('pmediaApp.credit_times', []);

app.factory('Credit_times', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_credit_times: [],
		data_credit_time: {},
		getCreditTimes: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/credit-times/`
			}).then(function(resp) {
		  		self.data_credit_times = resp.data;
				// self.data_privileges = resp.data.privileges;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		}
	};

	return self;
}]);
