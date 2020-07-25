var app = angular.module('pmediaApp.concepts', []);

app.factory('Concepts', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_concepts: [],
		data_concept: {},
		getConcepts: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/concepts/`
			}).then(function(resp) {
		  		self.data_concepts = resp.data;
				// self.data_privileges = resp.data.privileges;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
		}
	};

	return self;
}]);
