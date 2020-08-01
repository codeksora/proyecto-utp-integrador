var app = angular.module('pmediaApp.adminProductCategoriesCtrl', []);

app.controller('adminProductCategoriesCtrl', [
	'$scope', '$compile', 'Product_categories', 'DTColumnBuilder', 'DTOptionsBuilder',
	function($scope, $compile, Product_categories, DTColumnBuilder, DTOptionsBuilder){

    Product_categories
		.getPrivileges()
		.then(function() {
			$scope.privileges = Product_categories.data_privileges;
        });
        
    $scope.dtColumnsProductCategories = [
        DTColumnBuilder.newColumn('name').withTitle('Nombre'),
        // DTColumnBuilder.newColumn(null).withTitle('Fecha Creación').withOption('type', 'date')
        //     .renderWith(function(data, type, full, meta) {
        //         return $filter('date')(data.created_at, 'dd/MM/yyyy', 'UTC');
        //     }),
        DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
            .renderWith(function(data, type, full, meta) { 
                let privilege = {
                    read: ($scope.privileges.read == 1) ? `<button ng-click="getProductCategory(${data.id})" class="btn btn-xs btn-info" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button>` : '',
                    update: ($scope.privileges.update == 1) ? `<a href="#!/product-categories/${data.id}/edit/" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Editar"><i class="fa fa-pencil"></i></a>`:''
                    // delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteProductCategory(${data.id})" class="btn btn-xs btn-danger" tooltip-placement="top" uib-tooltip="Eliminar"><i class="fa fa-close"></i></button>`:''
                }
                return `${privilege.read} ${privilege.update} ${privilege.delete}`;
            })
    ];

    $scope.dtOptionsProductCategories = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            url: `${base_url}admin/product-categories/dt`,
            type: 'GET'
        })
        .withOption('createdRow', function(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        })
        // .withOption('order', [[7, 'desc']])
        .withOption('processing', true)
//         .withOption('responsive', true)
        .withOption('serverSide', true)
        .withDataProp('data')
        .withBootstrap()
        .withBootstrapOptions({
            pagination: {
                classes: {
                    ul: 'pagination pagination-sm'
                }
            }
        })
        .withLanguageSource(language_dt);

    $scope.dtInstanceProductCategories = {};
    $scope.reloadDataProductCategories = function() {
        $scope.dtInstanceProductCategories.reloadData(function (json) {
        }, false);
    }
        
	// // let id = $routeParams.id;

	// $scope.product = {};
	// $scope.product_details = [];

	// $scope.isDisabled = true;
	// $scope.alerts = [];

	// $scope.htmlVariable = '';

	// $scope.add = function(product) {
	// 	$scope.isDisabled = false;
	// 	$scope.alerts = [];
	// 	Products
    //         .addProduct(product)
    //         .then(function() {
    //             $scope.isDisabled = true;

	// 			$scope.activeAlert(Products.status, Products.message);

    //             if(Products.err == false) window.location = "#!/products/";
    //         });
	// }

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

	// if(id) {

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

       

	// 	// Guardar
	// 	$scope.save = function(product) {
	// 		$scope.isDisabled = false;
	// 		$scope.alerts = [];

	// 		Products
	// 			.saveProduct(product)
	// 			.then(function() {
	// 				$scope.isDisabled = true;

	// 				$scope.activeAlert(Products.status, Products.message);

	// 				if(Products.err == false) window.location = "#!/products/";
	// 			});
	// 	}

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

	// }
	// else $scope.setActive("adminProductAdd");


}]);