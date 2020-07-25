var app = angular.module('pmediaApp.adminOrdersCtrl', []);

app.controller('adminOrdersCtrl', [
	'$scope', '$uibModal', '$compile', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 'Orders', 'Customers',
function($scope, $uibModal, $compile, $filter, DTOptionsBuilder, DTColumnBuilder, Orders, Customers) {

	$scope.setActive("adminOrders");
	$scope.isDisabled = true;
	$scope.dtInstance = {};
	$scope.filter = {};

	$scope.orders = [];
	$scope.order = {};
	$scope.order_details = [];
	$scope.order_certs_ssl = [];
	$scope.order_firms = [];
	$scope.order_observations = [];
	$scope.obs = {};

	Orders
		.getPrivileges()
		.then(function() {
			$scope.privileges = Orders.data_privileges;
		});

	$scope.dateOrder = {
		date: {
			startDate: null,
			endDate: null
		},
		minDate: moment().subtract(1, 'year'),
		maxDate: moment(),
		options: {
			buttonClasses: 'btn',
			applyButtonClasses: 'btn-primary',
			cancelButtonClasses: 'btn-danger',
			locale: {
				applyLabel: "Aplicar",
				cancelLabel: 'Cancelar',
				customRangeLabel: 'Rango personalizado',
				separator: ' - ',
				format: "DD/MM/YYYY",
				daysOfWeek: ["Dom" ,"Lun", "Mar", "Mie" ,"Jue", "Vie", "sáb"],
				monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo","Junio","Julio",
										"Agosto","Septiembre","Octubre","Noviembre","Diciembre"]
			},
			ranges: {
				'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
				'Últimos 30 días': [moment().subtract(29, 'days'), moment()]
			},
		}
	}

	//Lista de clientes
	Customers.getCustomers().then(function() {
		$scope.customers = Customers.data_customers;
	});

	$scope.filterOrder = function(filter, dateOrder) {
		$scope.isDisabled = false;

		$scope.filter = filter;

		$scope.dtInstanceOrders.changeData(function() {
			let customer = ($scope.filter['customer'] != undefined && $scope.filterCustomer == true) ? filter.customer : '';
			let n_fact = angular.isDefined(filter.n_fact) ? filter.n_fact : '';
			let startRec = dateOrder.date.startDate != null ? dateOrder.date.startDate.format('YYYY-MM-DD') : '';
			let endRec = dateOrder.date.endDate != null ? dateOrder.date.endDate.format('YYYY-MM-DD') : '';
			$scope.isDisabled = true;

			return Orders.getOrdersByFilter(customer, n_fact, startRec, endRec);
		});


	}

	$scope.getOrder = function(id) {
		$uibModal
			.open({
				animation: true,
				scope: $scope,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: `${base_url}admin/orders/modal_view`,
				controller: 'modalOrderCtrl',
				size: 'lg',
				resolve: {
					data: {
						order_id: id
					}
				}
			})
			.result.then(function () {}, function () {});
	}

	$scope.getProductsAssigned = function(id) {
		$uibModal
			.open({
				animation: true,
				scope: $scope,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: `${base_url}admin/orders/modal_assign_view`,
				controller: 'modalOrderAssignCtrl',
				size: 'lg',
				resolve: {
					data: {
						order_id: id
					}
				}
			})
			.result.then(function () {}, function () {});
	}

	$scope.dtOptionsOrders = DTOptionsBuilder.newOptions()
		.withOption('ajax', {
			url: `${base_url}admin/orders/`,
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
		.withLanguageSource(language_dt);

	$scope.dtColumnsOrders = [
		DTColumnBuilder.newColumn(null).withTitle('Recepción').withOption('order', 'asc').withOption('type', 'date')
			.renderWith(function(data, type, full, meta) {
				return $filter('date')(data.reception_date, 'dd/MM/yyyy', 'UTC');
			}),
		DTColumnBuilder.newColumn(null).withTitle('Vencimiento')
			.renderWith(function(data, type, full, meta) {
				return $filter('date')(data.expiration_date, 'dd/MM/yyyy', 'UTC');
			}),
		DTColumnBuilder.newColumn('customer_name').withTitle('Cliente'),
		DTColumnBuilder.newColumn('customer_order_number').withTitle('Nro. Orden Ext.'),
		DTColumnBuilder.newColumn('invoice_number').withTitle('Nro. Factura'),
		DTColumnBuilder.newColumn('full_name').withTitle('Creado por'),
		// DTColumnBuilder.newColumn(null).withTitle('Estado').withClass('text-center')
		// 	.renderWith(function(data) {
		// 		return `<span class="label label-${data.nro_cotizacionOrd == 'ABIERTA'?'success':'danger'}">${ data.nro_cotizacionOrd ? data.nro_cotizacionOrd : 'SIN ESTADO' }</span>`;
		// 	}),
		DTColumnBuilder.newColumn(null).withTitle('Asignar').notSortable().withClass('text-center')
			.renderWith(function(data) {
				return `<a href="#!/orders/${data.id}/assign/" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Asignar"><i class="fa fa-check"></i></a>`;
			}),
		DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
			.renderWith(function(data, type, full, meta) {
				let privilege = {
					read: ($scope.privileges.read == 1) ? `<button type="button" ng-click="getOrder(${data.id})" class="btn btn-xs bg-aqua" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button>
							<button type="button" ng-click="getProductsAssigned(${data.id})" class="btn btn-xs bg-purple"><i class="fa fa-archive"></i></button>` : ``,
					update: ($scope.privileges.update == 1) ? `<a href="#!/orders/${data.id}/edit/" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Editar"><i class="fa fa-pencil"></i></a>`:'',
				}
				return `${privilege.read} ${privilege.update}`;
			})
	];

	$scope.dtInstanceOrders = {};
	$scope.reloadDataOrders = function() {
		$scope.dtInstanceOrders.reloadData(function () {
		}, false);
	}

	$scope.deleteOrder = function(order_id) {
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

		  	Orders
				.deleteOrder(order_id)
				.then(function() {
					$scope.activeAlert(Orders.status, Orders.message);

					if(Orders.err == false) $scope.reloadDataOrders();
				});
				
		  }
		});
	}

}]);

app.controller('modalOrderCtrl', ['$scope', '$uibModalInstance', 'data', 'DTOptionsBuilder', 'DTColumnBuilder', 'Orders', 
	'Quotation_product_details', 'Order_obs', 'Ssl_certs_assigned', 'Signatures_assigned', 'Quotation_products',
	function ($scope, $uibModalInstance, data, DTOptionsBuilder, DTColumnBuilder, Orders, 
		Quotation_product_details, Order_obs, Ssl_certs_assigned, Signatures_assigned, Quotation_products) {

	let order_id = data.order_id;

	Orders
		.getOrder(order_id)
		.then(function() {
			$scope.order = Orders.data_order;

			Quotation_product_details.getProductDetailsByQuotation($scope.order.quotation_id).then(function() {
				$scope.quotation_product_details = Quotation_product_details.data_quotation_product_details;
			});

			Quotation_products.getQuotationProductsByQuotation($scope.order.quotation_id).then(function() {
				$scope.products = Quotation_products.data_products;
			});
		});

	Ssl_certs_assigned.getSslCertsAssignedByOrder(order_id).then(function() {
		$scope.ssl_certs_assigned = Ssl_certs_assigned.data_ssl_certs_assigned.data;
	});

	Signatures_assigned.getSignaturesAssignedByOrder(order_id).then(function() {
		$scope.signatures_assigned = Signatures_assigned.data_signatures_assigned.data;
	});

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


app.controller('modalOrderAssignCtrl', [
	'$scope', '$uibModalInstance', 'data', 'DTOptionsBuilder', 'Ssl_certs_assigned', 'Signatures_assigned',
	function($scope, $uibModalInstance, data, DTOptionsBuilder, Ssl_certs_assigned, Signatures_assigned) {

	let order_id = data.order_id;

	Ssl_certs_assigned.getSslCertsAssignedByOrder(order_id).then(function() {
		$scope.ssl_certs_assigned = Ssl_certs_assigned.data_ssl_certs_assigned.data;
	});

	Signatures_assigned.getSignaturesAssignedByOrder(order_id).then(function() {
		$scope.signatures_assigned = Signatures_assigned.data_signatures_assigned.data;
	});

	$scope.dtOptionsCertSsl = DTOptionsBuilder.newOptions()
		.withBootstrap()
		.withLanguageSource(language_dt);

	$scope.dtOptionsFirms = DTOptionsBuilder.newOptions()
		.withBootstrap()
		.withLanguageSource(language_dt);

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};

}]);
