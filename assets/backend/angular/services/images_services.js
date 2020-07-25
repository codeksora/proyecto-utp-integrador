var app = angular.module('pmediaApp.images', []);

app.factory('Images', ['$http', '$q', 'Upload', function($http, $q, Upload) {
	
	var self = {
		'loading': true,
		'err': false,
		'msg': '',
		'data_images': [],
		'total_records' : 1,
		'pag_actual': 1,
		'total_pages': 1,
		'next_page': 1,
		'prev_page': 1,
		'data_image': {}, 
		'data_all_images': {}, 
		'pages': [],
		getAllImages: function() {
			var d = $q.defer();

			$http.get(base_url + "admin/images/all_images/")
		  	.then(function(resp) {

		  		self.data_all_images = resp.data;

		  		return d.resolve();
		  	});

		  	return d.promise;
		},
		addImage: function(image) {
			var d = $q.defer();

			Upload.upload({
	            url: base_url + "admin/images/add/",
	            data: image
	        }).then(function (resp) {
				
				self.err = resp.data.err;
				self.msg = resp.data.msg;

	        	return d.resolve();
	           
	        }, function (resp) {
	            //console.log('Error status: ');
	        }, function (evt) {
	           // console.log('progress: ');
	        });

		  	return d.promise;
		}
	};

	return self;
}]);