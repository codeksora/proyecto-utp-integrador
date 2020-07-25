var app = angular.module('pmediaApp.contact_types', []);

app.factory('Contact_types', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_contact_types: [],
		getContactTypes: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/contact-types/`
			}).then(function(resp) {
		  		self.data_contact_types = resp.data;
				// self.data_privileges = resp.data.privileges;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		}
	};

	return self;
}]);
