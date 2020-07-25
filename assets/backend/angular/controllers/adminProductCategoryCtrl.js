var app = angular.module('pmediaApp.adminProductCategoryCtrl', []);

app.controller('adminProductCategoryCtrl', [
	'$scope', '$routeParams', 'Product_categories',
	function($scope, $routeParams, Product_categories){

	let product_category_id = $routeParams.id;

	// $scope.product = {};
	// $scope.product_details = [];

	$scope.isDisabled = true;
	// $scope.alerts = [];

	// $scope.htmlVariable = '';

	$scope.add = function(product_category) {
		$scope.isDisabled = false;
		$scope.alerts = [];
		Product_categories
            .addProductCategory(product_category)
            .then(function() {
                $scope.isDisabled = true;

				$scope.activeAlert(Product_categories.status, Product_categories.message);

                if(Product_categories.err == false) window.location = "#!/product-categories/";
            });
	}

	// $scope.getProductDetail = function(product_id) {
	// 	Product_details
    //         .getProductDetails(product_id)
    //         .then(function() {
    //             $scope.product_details = Product_details.data_product_details;
    //         });
	// }

	

	// $scope.closeAlert = function(index) {
	// 	$scope.alerts.splice(index, 1);
	// };

	// // Recibir datos para los Dropdown
	// Product_types
    //     .getProductTypes()
    //     .then(function() {
    //         $scope.product_types = Product_types.data_product_types;
	// 	});
		
	// Product_categories
    //     .getProductCategories()
    //     .then(function() {
    //         $scope.product_categories = Product_categories.data_product_categories;
    //     });

	// Providers
    //     .getProviders()
    //     .then(function() {
    //         $scope.providers = Providers.data_providers;
    //     });
	
	// Quantity_years
	// 	.getQuantityYears()
	// 	.then(function() {
	// 		$scope.quantity_years = Quantity_years.data_quantity_years;
	// 	})

	if(product_category_id) {
        Product_categories.getProductCategory(product_category_id).then(function() {
            $scope.product_category = Product_categories.data_product_category;
        });

	// 	$scope.setActive("adminProducts");
	// 	$scope.product = {};

	// 	Products
	// 		.getProduct(id)
	// 		.then(function() {
	// 			$scope.product = Products.data_product;

	// 			if(Products.err == true) window.location = "#!/products/";

	// 			 Product_details
	// 	            .getDetailsByProduct(id)
	// 	            .then(function() {
	// 	                $scope.product.details = Product_details.data_product_details;
	// 	            });

	// 			Product_san_details
	// 	            .getSanDetailsByProduct(id)
	// 	            .then(function() {
	// 	                $scope.product.san_details = Product_san_details.data_product_san_details;
	// 	            });
	// 		});

       

		// Guardar
		$scope.save = function(product_category) {
			$scope.isDisabled = false;
			$scope.alerts = [];

			Product_categories
				.saveProductCategory(product_category)
				.then(function() {
					$scope.isDisabled = true;

					$scope.activeAlert(Product_categories.status, Product_categories.message);

					if(Product_categories.err == false) window.location = "#!/product-categories/";
				});
		}

	// 	$scope.saveInfoDocument = function(product) {
	// 		$scope.isDisabled = false;

	// 		Products
	// 			.saveInfoDocument(product)
	// 			.then(function() {
	// 				$scope.isDisabled = true;

	// 				$scope.activeAlert(Products.status, Products.message);

	// 				if(Products.err == false) window.location = "#!/products/";
	// 			});
	// 	}

	}
	// else $scope.setActive("adminProductAdd");


}]);