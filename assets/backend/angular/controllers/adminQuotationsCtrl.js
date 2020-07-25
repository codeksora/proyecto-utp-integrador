var app = angular.module('pmediaApp.adminQuotationsCtrl', []);

app.controller('adminQuotationsCtrl', [
	'$scope', '$filter', '$compile', '$uibModal', 'DTOptionsBuilder', 'DTColumnBuilder', 'Quotations',
	function($scope, $filter, $compile, $uibModal, DTOptionsBuilder, DTColumnBuilder, Quotations) {

	$scope.setActive("adminQuotations");

	Quotations
		.getPrivileges()
		.then(function() {
			$scope.privileges = Quotations.data_privileges;
		});

	$scope.dtOptionsQuotations = DTOptionsBuilder.newOptions()
		.withOption('ajax', {
			url: `${base_url}admin/quotations/dt/`,
			type: 'GET'
		})
		.withOption('createdRow', function(row, data, dataIndex) {
			$compile(angular.element(row).contents())($scope);
		})
		.withOption('order', [[0, 'desc']])
		.withOption('processing', true)
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

	$scope.dtColumnsQuotations = [
		DTColumnBuilder.newColumn(null).withTitle('Fecha de creación').withOption('order', 'asc').withOption('type', 'date')
			.renderWith(function(data, type, full, meta) {
				return $filter('date')(data.created_at, 'dd/MM/yyyy @ HH:mm:ss');
			}),
		DTColumnBuilder.newColumn('customer_name').withTitle('Cliente'),
		DTColumnBuilder.newColumn('user_full_name').withTitle('Creado por'),
		DTColumnBuilder.newColumn('quotation_number').withTitle('Nº Cot.'),
		DTColumnBuilder.newColumn(null).withTitle('Precio total')
			.renderWith(function(data, type, full, meta) {
				return $filter('currency')(data.order_total, data.currency_type_symbol + " ");
			}),
		DTColumnBuilder.newColumn(null).withTitle('Estado')
			.renderWith(function(data, type, full, meta) {
				return `<span class="label bg-${data.status_class}" tooltip-placement="top" uib-tooltip="${data.status_description}">${data.status_name}</span>`;
			}),
		DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
			.renderWith(function(data, type, full, meta) {
				let url_template = data.quotation_template_id == null ? `${base_url}assets/backend/pdfs/${data.quotation_document}` : `${base_url}admin/quotations/${data.id}/document/`
	
				let privilege = {
					read: ($scope.privileges.read == 1) 
						? `<button type="button" ng-click="getQuotation(${data.id})" class="btn btn-xs btn-info" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button> 
							<a href="${url_template}" target="_blank" class="btn btn-xs bg-purple" tooltip-placement="top" uib-tooltip="Descargar documento"><i class="fa fa-download"></i></a>` : ``,
					update: ($scope.privileges.update == 1) 
					? `<a href="#!/quotations/${data.id}/validate/" ng-if="${data.status_id} == 5" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Validar cotización"><i class="fa fa-external-link"></i></a>
						<button type="button" ng-if="${data.status_id} != 5" class="btn btn-xs bg-default" disabled><i class="fa fa-external-link"></i></button>` 
					: ``,
					delete: ($scope.privileges.delete == 1) 
					? `<button type="button" ng-click="disableQuotation(${data.id})" ng-if="${data.status_id} == 5" class="btn btn-xs btn-danger" tooltip-placement="top" uib-tooltip="Deshabilitar"><i class="fa fa-ban"></i></</button>
						<button type="button" ng-if="${data.status_id} != 5" class="btn btn-xs bg-default" disabled><i class="fa fa-ban"></i></button>` 
					: ``
				}
				return `${privilege.read} ${privilege.update} ${privilege.delete}`;
			})
	];

	$scope.dtInstanceQuotations = {};
	$scope.reloadDataQuotations = function() {
		$scope.dtInstanceQuotations.reloadData(function () {
		}, false);
	}

	

	$scope.getQuotation = function(id) {
		$uibModal
			.open({
				animation: true,
				scope: $scope,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: `${base_url}admin/quotations/modal_view`,
				controller: 'modalQuotationCtrl',
				size: 'lg',
				resolve: {
					data: {
						quotation_id: id
					}
				}
			})
			.result.then(function () {}, function () {});
	}

	


	$scope.disableQuotation = function(order_id) {
		swal({
		  title: "¿Estás seguro que desea deshabilitar el dato?",
		  text: "Una vez deshabilitado ya no se podrá modificar",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		  buttons: ["Cancelar", "Eliminar"]
		})
		.then((willDelete) => {
		  if (willDelete) {
			$scope.alerts = [];

		  	Quotations
				.disableQuotation(order_id)
				.then(function() {
					$scope.activeAlert(Quotations.status, Quotations.message);

					if(Quotations.err == false) $scope.reloadDataQuotations();
				});
				
		  }
		});
	}
	
}]);

app.controller('modalQuotationCtrl', ['$scope', '$uibModalInstance', 'data', 'DTOptionsBuilder', 'DTColumnBuilder', 'Quotations', 
	'Quotation_product_details', 'Order_obs', 'Ssl_certs_assigned', 'Signatures_assigned', 'Quotation_products',
	function ($scope, $uibModalInstance, data, DTOptionsBuilder, DTColumnBuilder, Quotations, 
		Quotation_product_details, Order_obs, Ssl_certs_assigned, Signatures_assigned, Quotation_products) {

	let quotation_id = data.quotation_id;

	Quotations
		.getQuotation(quotation_id)
		.then(function() {
			$scope.quotation = Quotations.data_quotation;
		});
		
	// Quotation_product_details.getProductDetailsByQuotation(quotation_id).then(function() {
	// 	$scope.quotation_product_details = Quotation_product_details.data_Quotation_product_details;
	// });

	Quotation_products.getQuotationProductsByQuotation(quotation_id).then(function() {
		$scope.products = Quotation_products.data_products;
	});

	// Order_obs.getOrderObs(order_id).then(function() {
	// 	$scope.order_obs = Order_obs.data_order_obs;
	// });

	// Order_ssl_certs_assign.getSslCertsByOrder(order_id).then(function() {
	// 	$scope.ssl_certs_assign = Order_ssl_certs_assign.data_ssl_certs_assign;
	// });

	// Ssl_certs_assigned.getSslCertsAssignedByOrder(order_id).then(function() {
	// 	$scope.ssl_certs_assigned = Ssl_certs_assigned.data_ssl_certs_assigned.data;
	// });

	// Signatures_assigned.getSignaturesAssignedByOrder(order_id).then(function() {
	// 	$scope.signatures_assigned = Signatures_assigned.data_signatures_assigned.data;
	// });

	// $scope.order_certs_ssl = data.order_certs_ssl;
	// $scope.order_firms = data.order_firms;

	$scope.isDisabled = true;

	$scope.addObs = function(obs) {
		$scope.isDisabled = false;

		Order_obs
			.addOrderObs(obs)
			.then(function() {
				$scope.isDisabled = true;

				Orders.getOrder($scope.order.id_orden).then(function() {
					$scope.order_observations = Orders.data_order_observations;
				});

				$scope.obs = {};
			});
	}
	
	$scope.dtOptionsDetails = DTOptionsBuilder.newOptions()
		.withBootstrap()
		.withLanguageSource(language_dt);

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
}]);