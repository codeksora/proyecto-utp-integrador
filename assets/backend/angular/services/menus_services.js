var app = angular.module('pmediaApp.menus', []);

app.factory('Menus', ['$http', '$q', function($http, $q) {
	
	var self = {
		data_all_menus: [],
		getMenus: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: `${base_url}admin/menus/`
			}).then(function(resp) {

		  		self.data_menus = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		}
	};

	return self;
}]);