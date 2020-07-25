var app = angular.module('pmediaApp.adminProductsCtrl', []);

app.controller('adminProductsCtrl', [
		'$scope', '$uibModal', '$compile', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 
		'Products', 'Product_details', 'Product_types', 'Providers',
		function($scope, $uibModal, $compile, $filter, DTOptionsBuilder, DTColumnBuilder, 
			Products, Product_details, Product_types, Providers) {

		$scope.setActive("adminProducts");

		$scope.products = [];
		$scope.product = {};
		$scope.alerts = [];
		$scope.product_prices = [];
		$scope.product_types = [];

		$scope.search = {}

		$scope.search.productDate = {
			date: {
				startDate: null,
				endDate: null
			},
			options: {
				pickerClasses: 'custom-display', //angular-daterangepicker extra
				buttonClasses: 'btn',
				applyButtonClasses: 'btn-primary',
				cancelButtonClasses: 'btn-danger',
				locale: {
					applyLabel: "Aplicar",
					cancelLabel: 'Cancelar',
					separator: ' - ',
					format: "DD/MM/YYYY",
								daysOfWeek: ["Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb", "Dom"],
								monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo","Junio","Julio",
														"Agosto","Septiembre","Octubre","Noviembre","Diciembre"]
				}
			}
		}

		$scope.getProduct = function(id) {
			$uibModal
			.open({
				animation: true,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: base_url + 'admin/products/modal_view',
				controller: 'modalProductCtrl',
				size: 'lg',
				resolve: {
					data: {
						product_id: id
					}
				}
			})
			.result.then(function () {}, function () {});
		}

		Products
			.getPrivileges()
			.then(function() {
				$scope.privileges = Products.data_privileges;
			});

		Product_types
			.getProductTypes()
			.then(function() {
				$scope.product_types = Product_types.data_product_types;
			});

		Providers
			.getProviders()
			.then(function() {
				$scope.providers = Providers.data_providers;
			});

		let provider_s = '';
		let product_type_s = '';
		let startRec_s = '';
		let endRec_s = '';

		$scope.searchProduct = (search) => {

				provider_s = search.provider_name ? search.provider_name : '';
				product_type_s = search.product_type_name ? search.product_type_name : '';
				startRec_s = search.productDate.date.startDate != null ? search.productDate.date.startDate.format('YYYY-MM-DD') : '';
				endRec_s = search.productDate.date.endDate != null ? search.productDate.date.endDate.format('YYYY-MM-DD') : '';

				$scope.dtInstanceProducts.changeData(`${base_url}admin/products/?provider_s=${provider_s}&product_type_s=${product_type_s}&startRec_s=${startRec_s}&endRec=${endRec_s}`);
			
		}
		
		$scope.dtOptionsProducts = DTOptionsBuilder.newOptions()
			.withOption('ajax', {
				url: `${base_url}admin/products/?provider_s=${provider_s}&product_type_s=${product_type_s}`,
				type: 'GET'
			})
			.withOption('createdRow', function(row, data, dataIndex) {
				$compile(angular.element(row).contents())($scope);
			})
			.withOption('order', [[5, 'desc']])
			.withOption('processing', true)
			.withOption('serverSide', true)
			.withDataProp('data')
			.withBootstrap()
			.withLanguageSource(language_dt);

		$scope.dtColumnsProducts = [
			DTColumnBuilder.newColumn('provider_name').withTitle('Proveedor'),
			DTColumnBuilder.newColumn('name').withTitle('Producto'),
			DTColumnBuilder.newColumn('product_type_name').withTitle('Tipo de producto'),
			DTColumnBuilder.newColumn(null).withTitle('Fecha de creación').withOption('type', 'date')
				.renderWith(function(data, type, full, meta) {
					return $filter('date')(data.created_at, 'dd/MM/yyyy');
				}),
			DTColumnBuilder.newColumn('full_name').withTitle('Creado por'),
			DTColumnBuilder.newColumn('updated_at').withTitle('').notVisible(),
			DTColumnBuilder.newColumn(null).withTitle('Ficha técnica').withClass('td-small text-center')
				.renderWith(function(data, type, full, meta) {
					let html = (data.information_document) ? `<a href="${base_url}product_docs/${data.information_document}" target="_blank" class="btn btn-xs bg-purple"><i class="fa fa-download"></i></a>` : '';
					return html;
				}),
			DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
				.renderWith(function(data, type, full, meta) {

					let privilege = {
						read: ($scope.privileges.read == 1) ? `<button ng-click="getProduct(${data.id})" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>` : ``,
						update: ($scope.privileges.update == 1) ? `<a href="#!/products/${data.id}/edit/" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>`:'',
						delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteProduct(${data.id})" class="btn btn-xs btn-danger"><i class="fa fa-close"></i></button>`:''
					}
					return `${privilege.read} ${privilege.update} ${privilege.delete}`;
				})
		];

		$scope.dtInstanceProducts = {};
		$scope.reloadDataProducts = function() {
			$scope.dtInstanceProducts.reloadData(function () {
			}, false);
		}

		$scope.deleteProduct = function(product_id) {
			swal({
				title: "¿Estás seguro que desea eliminar el dato?",
				text: "Una vez eliminado ya no se podrá recuperar",
				icon: "warning",
				buttons: true,
				dangerMode: true,
				buttons: ["Cancelar", "Eliminar"]
			})
			.then((willDelete) => {
				if (willDelete) {
					$scope.alerts = [];
												
					Products
						.deleteProduct(product_id)
						.then(function() {
							$scope.activeAlert(Products.status, Products.message);

							if(Products.err == false) $scope.reloadDataProducts();
						});
					
				}
			});
		}

		$scope.closeAlert = function(index) {
			$scope.alerts.splice(index, 1);
		};
}]);

app.controller('modalProductCtrl', function ($scope, $uibModalInstance, data, Products, Product_details, Product_san_details) {
	let product_id = data.product_id;

	Products
		.getProduct(product_id)
		.then(function() {
			$scope.product = Products.data_product;
		});

	Product_details
		.getDetailsByProduct(product_id)
		.then(function() {
			$scope.product_details = Product_details.data_product_details;
		});

	Product_san_details
		.getSanDetailsByProduct(product_id)
		.then(function() {
			$scope.product_san_details = Product_san_details.data_product_san_details;
		});

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
});