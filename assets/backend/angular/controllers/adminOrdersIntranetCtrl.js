var app = angular.module('pmediaApp.adminOrdersIntranetCtrl', []);

app.controller('adminOrdersIntranetCtrl', [
	'$scope', '$uibModal', '$compile', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 'Orders_intranet', 'Customers',
function($scope, $uibModal, $compile, $filter, DTOptionsBuilder, DTColumnBuilder, Orders_intranet, Customers) {

    $scope.setActive("adminOrdersIntranet");
    
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

	// $scope.dateOrder = {
	// 	date: {
	// 		startDate: null,
	// 		endDate: null
	// 	},
	// 	minDate: moment().subtract(1, 'year'),
	// 	maxDate: moment(),
	// 	options: {
	// 		buttonClasses: 'btn',
	// 		applyButtonClasses: 'btn-primary',
	// 		cancelButtonClasses: 'btn-danger',
	// 		locale: {
	// 			applyLabel: "Aplicar",
	// 			cancelLabel: 'Cancelar',
	// 			customRangeLabel: 'Rango personalizado',
	// 			separator: ' - ',
	// 			format: "DD/MM/YYYY",
	// 			daysOfWeek: ["Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb", "Dom"],
	// 			monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo","Junio","Julio",
	// 									"Agosto","Septiembre","Octubre","Noviembre","Diciembre"]
	// 		},
	// 		ranges: {
	// 			'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
	// 			'Últimos 30 días': [moment().subtract(29, 'days'), moment()]
	// 		},
	// 	}
	// }

	//Lista de clientes
	// Customers.getCustomers().then(function() {
	// 	$scope.customers = Customers.data_customers;
	// });

	// $scope.filterOrder = function(filter, dateOrder) {
	// 	$scope.isDisabled = false;

	// 	$scope.filter = filter;

	// 	$scope.dtInstanceOrders.changeData(function() {
	// 		let customer = ($scope.filter['customer'] != undefined && $scope.filterCustomer == true) ? filter.customer : '';
	// 		let n_fact = angular.isDefined(filter.n_fact) ? filter.n_fact : '';
	// 		let startRec = dateOrder.date.startDate != null ? dateOrder.date.startDate.format('YYYY-MM-DD') : '';
	// 		let endRec = dateOrder.date.endDate != null ? dateOrder.date.endDate.format('YYYY-MM-DD') : '';
	// 		$scope.isDisabled = true;

	// 		return Orders.getOrdersByFilter(customer, n_fact, startRec, endRec);
	// 	});


	// }

	$scope.getOrder = function(id) {
		$uibModal
		.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: base_url + 'admin/orders/modal_view',
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

	$scope.dtOptionsOrders = DTOptionsBuilder.newOptions()
		.withOption('ajax', {
			url: `${base_url}admin/orders-intranet/`,
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
				return $filter('date')(data.fch_recepcionOrd, 'dd/MM/yyyy', 'UTC');
			}),
		DTColumnBuilder.newColumn(null).withTitle('Vencimiento')
			.renderWith(function(data, type, full, meta) {
				return $filter('date')(data.fch_vencimientoOrd, 'dd/MM/yyyy', 'UTC');
			}),
		DTColumnBuilder.newColumn('nombre').withTitle('Cliente'),
		DTColumnBuilder.newColumn('codOrden').withTitle('Nro. Orden'),
		DTColumnBuilder.newColumn(null).withTitle('Estado').withClass('text-center')
			.renderWith(function(data) {
				return `<span class="label label-${data.estadoOrd != 'ANULADA'?'success':'danger'}">${ data.estadoOrd ? data.estadoOrd : 'SIN ESTADO' }</span>`;
			}),
		DTColumnBuilder.newColumn(null).withTitle('Factura').notSortable().withClass('text-center')
			.renderWith(function(data) {
				return `<a href="#!/orders-intranet/${data.id_orden}/invoice/" class="btn btn-xs btn-primary"><i class="fa fa-paper-plane"></i></a>`;
			}),
		DTColumnBuilder.newColumn(null).withTitle('Boleta').notSortable().withClass('text-center')
			.renderWith(function(data) {
				return `<a href="#!/orders-intranet/${data.id_orden}/bill/" class="btn btn-xs btn-warning"><i class="fa fa-paper-plane"></i></a>`;
			})
	];

	$scope.dtInstanceOrders = {};
	$scope.reloadDataOrders = function() {
		$scope.dtInstanceOrders.reloadData(function () {
		}, false);
	}

}]);

// app.controller('modalOrderCtrl',
// 	function ($scope, $uibModalInstance, data, DTOptionsBuilder, DTColumnBuilder, Orders, Order_details, Order_obs, Order_ssl_certs_assign) {

// 	let order_id = data.order_id;

// 	Orders
// 		.getOrder(order_id)
// 		.then(function() {
// 			$scope.order = Orders.data_order;
// 		});

// 	Order_details
// 		.getOrderDetails(order_id)
// 		.then(function() {
// 			$scope.order_details = Order_details.data_order_details;
// 		});

// 	Order_obs
// 		.getOrderObs(order_id)
// 		.then(function() {
// 			$scope.order_obs = Order_obs.data_order_obs;
// 		});

// 	Order_ssl_certs_assign
// 		.getSslCertsByOrder(order_id)
// 		.then(function() {
// 			$scope.ssl_certs_assign = Order_ssl_certs_assign.data_ssl_certs_assign;
// 		});

// 	$scope.order_certs_ssl = data.order_certs_ssl;
// 	$scope.order_firms = data.order_firms;

	
// 	$scope.isDisabled = true;

// 	$scope.addObs = function(obs) {
// 		$scope.isDisabled = false;

// 		Order_obs
// 			.addOrderObs(obs)
// 			.then(function() {
// 				$scope.isDisabled = true;

// 				Orders.getOrder($scope.order.id_orden).then(function() {
// 					$scope.order_observations = Orders.data_order_observations;
// 				});

// 				$scope.obs = {};
// 			});
// 	}
	
// 	$scope.dtOptionsDetails = DTOptionsBuilder.newOptions()
// 		.withBootstrap()
// 		.withLanguageSource(language_dt);
	
// 	$scope.dtOptionsCertSsl = DTOptionsBuilder.newOptions()
// 		.withBootstrap()
// 		.withLanguageSource(language_dt);

// 	$scope.dtOptionsFirms = DTOptionsBuilder.newOptions()
// 		.withBootstrap()
// 		.withLanguageSource(language_dt);

// 	$scope.closeModal = function () {
// 		$uibModalInstance.dismiss('cancel');
// 	};
// });
