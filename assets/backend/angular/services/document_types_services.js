var app = angular.module('pmediaApp.document_types', []);

app.factory('Document_types', ['$http', '$q', function($http, $q) {
	
	let self = {
		loading: true,
		err: false,
		data_document_types: [],
		getDocumentTypes: function() {
			let d = $q.defer();
			$http({
				method: 'GET',
				url: `${base_url}admin/document-types`
			}).then(function(resp) {
		  		self.data_document_types = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);