var app = angular.module('pmediaApp.profile', []);

app.factory('Profile', ['$http', '$q', function($http, $q) {
	
	var self = {
		'loading': true,
		'msg': '',
		'err': false,
		'redirect_url': '',
		'total_records' : 1,
		'pag_actual': 1,
		'total_pages': 1,
		'next_page': 1,
		'prev_page': 1,
		'data_user': {}, 
		'data_import': {
			'all_images': {}
		}, 
		'pages': [],
		loadPage: function(pag) {
			var d = $q.defer();

			$http.get(base_url + "admin/roles/roles/" + pag)
			    .then(function(resp) {
			      
				self.err = resp.data.err;
				self.data_roles = resp.data.data_roles;
				self.total_records = resp.data.total_records;
				self.pag_actual = resp.data.pag_actual;
				self.total_pages = resp.data.total_pages;
				self.next_page = resp.data.next_page;
				self.prev_page = resp.data.prev_page;
				self.pages = resp.data.pages;
				
			      return d.resolve();
			    },
			    function() {

			    });

			return d.promise;
		},
		saveProfile: function(user) {
			var d = $q.defer();

			$http({
				method: 'PUT',
				url: base_url + "admin/profile/user/", 
				data: user
			}).then(function(resp) {

				self.redirect_url = resp.data.redirect_url;
				return d.resolve();
			});

			return d.promise;
		},
		getProfile: function() {
			var d = $q.defer();

			$http.get(base_url + "admin/profile/user/")
		  	.then(function(resp) {

		  		self.data_user = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		saveNewPass: function(user) {
			var d = $q.defer();

			$http.post(base_url + "admin/profile/update_pass/", user)
			.then(function(resp) {
				self.err = resp.data.err;
				self.msg = resp.data.msg;
				self.redirect_url = resp.data.redirect_url;
				return d.resolve();
			});

			return d.promise;
		}
	};

	return self;
}]);