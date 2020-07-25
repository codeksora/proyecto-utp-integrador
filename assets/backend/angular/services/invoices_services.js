var app = angular.module('pmediaApp.invoices', []);

app.factory('Invoices', ['$http', '$q', function($http, $q) {

    var self = {
        loading: true,
        err: false,
        tax: 0,
        total: 0,
        subtotal: 0,
        IGV: 0,
        observation: undefined,
        data_invoices: [],
        data_invoice: {},
        data_customer: {},
        data_products: [],
        getInvoices: function() {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: `${base_url}admin/invoices/`
            }).then(function(resp) {
                self.data_invoices = resp.data;

                return d.resolve(resp.data);
            });

            return d.promise;
        },
        getDetailByDocNum: function(doc_num) {
            var d = $q.defer();

            $http({
                method: 'POST',
                url: `${base_url}admin/invoices/info-sunat`,
                data: {
                    document_number: doc_num
                }
            }).then(function(resp) {
                self.data_customer = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        // calculate: function() {
        //     self.subtotal = 0;

        //     for(item of self.data_products) {
        //         self.subtotal += item.price * item.quantity;
        //     }

        //     self.tax = self.subtotal * self.IGV;
        //     self.total = self.subtotal + self.tax;
        // },
        // addProduct: function(product) {
        //     self.data_products.push(product);
        //     self.calculate();
        // },
        // deleteProduct: function(index) {
        //     self.data_products.splice(index, 1);
        //     self.calculate();
        // },
        addInvoice: function(invoice) {
			var d = $q.defer();

			$http({
                method: 'POST',
                url: `${base_url}admin/invoices/`,
                data: invoice
            }).then(function(resp) {
                self.err = resp.data.err;
				self.message = resp.data.message;
				self.status = resp.data.status;

                          
		  		return d.resolve();
		  	});

		  	return d.promise;
		}
    };

    return self;
}]);
