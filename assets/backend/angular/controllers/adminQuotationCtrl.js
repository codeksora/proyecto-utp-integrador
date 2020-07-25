var app = angular.module('pmediaApp.adminQuotationCtrl', []);

app.controller('adminQuotationCtrl', [
	'$scope', '$routeParams', 'Quotations', 'Customers', 'Currency_types', 
	'Product_types', 'Quotation_products', '$uibModal', 'DTOptionsBuilder', 
	'DTColumnDefBuilder', 'Order_types', 'Orders', 'Quotation_templates', 'Contacts', 'Credit_times',
	function($scope, $routeParams, Quotations, Customers, Currency_types, 
		Product_types, Quotation_products, $uibModal, DTOptionsBuilder, 
		DTColumnDefBuilder, Order_types, Orders, Quotation_templates, Contacts, Credit_times) {

	var quotation_id = $routeParams.id;

	$scope.quotation = Quotations;

	$scope.quotation.quotation_template_id = undefined;
	$scope.quotation.contact_id = undefined;
	$scope.quotation.IGV = $scope.config.igv;
	$scope.quotation.data_products = [];
	$scope.quotation.currency_type_id = undefined;
	$scope.quotation.customer_id = undefined;
	$scope.quotation.observation = '';
	$scope.quotation.expiration_date = moment();
	$scope.quotation.reception_date = moment();
	$scope.quotation.order_date = moment();
	$scope.quotation.order_type_id = undefined;

	$scope.isDisabled = true;
	$scope.customers = [];

	$scope.single_date_options = {
			singleDatePicker: true,
			locale: {
					format: "DD/MM/YYYY",
					daysOfWeek: ["Dom", "Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb"]
			}
		}

	Customers
		.getCustomers()
		.then(function() {
			$scope.customers = Customers.data_customers;
		});
    
   Credit_times
    .getCreditTimes()
    .then(function() {
     $scope.credit_times = Credit_times.data_credit_times;
   });

	Contacts
		.getContacts()
		.then(function() {
			$scope.contacts = Contacts.data_contacts;
		});
	
	Quotation_templates
		.getQuotationTemplates()
		.then(function() {
			$scope.quotation_templates = Quotation_templates.data_quotation_templates;
		});

	Order_types
		.getOrderTypes()
		.then(function() {
			$scope.order_types = Order_types.data_order_types;
		});

	Currency_types
		.getCurrencyTypes()
		.then(function() {
			$scope.currency_types = Currency_types.data_currency_types;
		});

	Product_types
		.getProductTypes()
		.then(function() {
			$scope.product_types = Product_types.data_product_types;
		});

	$scope.deleteProduct = function(index) {
		Quotations.deleteProduct(index);
	}

	$scope.quotation.products = [];

	$scope.dtOptionsQuotations = DTOptionsBuilder
		.newOptions()
		.withBootstrap()
		.withBootstrapOptions({
            pagination: {
                classes: {
                    ul: 'pagination pagination-sm'
                }
            }
        })
		.withLanguageSource(language_dt);

	$scope.dtInstanceQuotations = {};
	$scope.reloadDataQuotations = function() {
		$scope.dtInstanceQuotations.reloadData(function () {
		}, false);
	}

	$scope.dtColumnDefsQuotations = [
		DTColumnDefBuilder.newColumnDef(0),
		DTColumnDefBuilder.newColumnDef(1),
		DTColumnDefBuilder.newColumnDef(2),
		DTColumnDefBuilder.newColumnDef(3),
		DTColumnDefBuilder.newColumnDef(4),
		DTColumnDefBuilder.newColumnDef(5),
		DTColumnDefBuilder.newColumnDef(6),
		DTColumnDefBuilder.newColumnDef(7).notSortable()
	];

	$scope.addProductModal = function() {
		$uibModal
			.open({
				animation: true,
				scope: $scope,
				backdrop: 'static',
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: base_url + 'admin/quotations/modal_add_product_view',
				controller: 'modalQuotationsAddProductCtrl',
				size: 'md',
				resolve: {
					data: {
						quotation: $scope.quotation
					}
				}
			})
			.result.then(function() {}, function() {});
	}

	$scope.add = function(quotation) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Quotations
			.addQuotation(quotation)
			.then(function() {
				$scope.isDisabled = true;

				$scope.activeAlert(Quotations.status, Quotations.message);

				if(Quotations.err == false) window.location = "#!/quotations/";
				
			});
	}

	if(quotation_id) {
		Quotations.getQuotation(quotation_id).then(function() {
			$scope.quotation = Quotations.data_quotation;
			// if(Orders.err == true) window.location = "#!/orders/";

			$scope.quotation.expiration_date = moment();
			$scope.quotation.reception_date = moment();
			$scope.quotation.order_date = moment();
			$scope.quotation.order_type_id = undefined;
		});

		Quotation_products.getQuotationProductsByQuotation(quotation_id).then(function() {
			$scope.products = Quotation_products.data_products;
		});

		$scope.validate = function(quotation) {
			$scope.isDisabled = false;
			Quotations
				.validateQuotation(quotation, quotation_id)
				.then(function() {
					$scope.isDisabled = true;

					$scope.activeAlert(Quotations.status, Quotations.message);

					if(Quotations.err == false) window.location = "#!/orders/";
				});
		}

		$scope.setActive("adminQuotations"); 
	} else {
		$scope.setActive("adminQuotationAdd");
	}

}]);

app.controller('modalQuotationsAddProductCtrl', [
	'$scope', '$uibModalInstance', 'data', 'Products', 'Product_types', 'Quotations', 'Quantity_years', 'Product_details', 'Concepts', 'Providers',
	function($scope, $uibModalInstance, data, Products, Product_types, Quotations, Quantity_years, Product_details, Concepts, Providers) {

	$scope.product_types = [];

	$scope.quotation = data.quotation;

	$scope.product = {}
	$scope.product.discount = 0;
	$scope.product.qty_san = 0;

	Product_types
		.getProductTypes()
		.then(function() {
			$scope.product_types = Product_types.data_product_types;
		});

	Product_details
		.getProductDetailsByCurrencyType($scope.quotation.currency_type_id)
		.then(function() {
			$scope.product_details = Product_details.data_product_details;
		});
    
  Providers
    .getProviders()
    .then(function() {
      $scope.providers = Providers.data_providers;
  })

	Concepts
		.getConcepts()
		.then(function() {
			$scope.concepts = Concepts.data_concepts;
		});

	$scope.getProductDetails = function(product_detail_id) {
		$scope.sans = [];
		if(product_detail_id) {
			Product_details
				.getProductDetailById(product_detail_id, $scope.quotation.currency_type_id)
				.then(function() {
					$scope.product_detail = Product_details.data_product_detail;

					for (var i=0; i<= Product_details.data_product_detail.san_max; i++) {
						$scope.sans.push(i);
					}
				});
		}
		
	}

	// Products
	// 	.getProducts()
	// 	.then(function() {
	// 		$scope.products = Products.data_products;
	// 	});

	$scope.addProduct = function(product) {
		Product_details.getProductDetailById(product.product_id, $scope.quotation.currency_type_id).then(function() { 
			let product_arr = Product_details.data_product_detail;

			product_arr.amount = product.amount;
			product_arr.mails = product.mails;
      product_arr.domains = product.domains;
			product_arr.concept_id = product.concept_id;
			product_arr.discount_perc = product.discount ? product.discount : 0;
			product_arr.qty_san = product.qty_san ? product.qty_san : 0;

			// $scope.product.san_price = $scope.order.currency_type_id == 1 ? $scope.product.price_san_pen : $scope.product.price_san_usd;
			Quotations.addProduct(product_arr);
		});
		
		$uibModalInstance.close('closed');
	};
	
	
	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
}]);