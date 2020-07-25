var app = angular.module('pmediaApp.quotation_templates', []);

app.factory('Quotation_templates', ['$http', '$q', function($http, $q) {

	var self = {
		loading: true,
		err: false,
		message: '',
		status: '',
		data_quotation_templates: [],
		data_user: {},
		getQuotationTemplates: function() {
			var d = $q.defer();

			$http({
				method: 'GET',
				url: base_url + "admin/quotation-templates/"
			}).then(function(resp) {
		  		self.data_quotation_templates = resp.data;

		  		return d.resolve(resp.data);
		  	});

			return d.promise;
        }
    }

    return self;
}]);