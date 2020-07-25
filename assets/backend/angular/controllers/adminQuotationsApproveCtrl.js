var app = angular.module('pmediaApp.adminQuotationsApproveCtrl', []);

app.controller('adminQuotationsApproveCtrl', [
	'$scope', '$filter', '$compile', '$uibModal', 'Quotations', 'Quotations_approve', 'DTOptionsBuilder', 'DTColumnBuilder', 
	function($scope, $filter, $compile, $uibModal, Quotations, Quotations_approve, DTOptionsBuilder, DTColumnBuilder) {

	$scope.setActive("adminQuotationsApprove");

	Quotations_approve
		.getPrivileges()
		.then(function() {
			$scope.privileges = Quotations_approve.data_privileges;
		});
	
	$scope.dtOptionsQuotationsApprove = DTOptionsBuilder.newOptions()
		.withOption('ajax', {
			url: `${base_url}admin/quotations-approve/dt/`,
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

	$scope.dtColumnsQuotationsApprove = [
		DTColumnBuilder.newColumn(null).withTitle('Fecha de creación').withOption('order', 'asc').withOption('type', 'date')
			.renderWith(function(data, type, full, meta) {
				return $filter('date')(data.created_at, 'dd/MM/yyyy', 'UTC');
			}),
		DTColumnBuilder.newColumn('customer_name').withTitle('Cliente'),
		DTColumnBuilder.newColumn('user_full_name').withTitle('Creado por'),
		DTColumnBuilder.newColumn(null).withTitle('Precio total')
			.renderWith(function(data, type, full, meta) {
				return $filter('currency')(data.order_total, data.currency_type_symbol);
			}),
		DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
			.renderWith(function(data, type, full, meta) {
				let privilege = {
					read: ($scope.privileges.read == 1) 
						? `<button type="button" ng-click="getQuotation(${data.id})" class="btn btn-xs btn-info" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button> 
							<a href="${base_url}assets/backend/pdfs/${data.quotation_document}" target="_blank" class="btn btn-xs bg-purple" tooltip-placement="top" uib-tooltip="Descargar documento"><i class="fa fa-download"></i></a>` : ``,
					update: ($scope.privileges.update == 1) 
					? `<button type="button" ng-click="approveQuotation(${data.id})" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Aprobar cotización"><i class="fa fa-check"></i></button>` 
					: ``,
					delete: ($scope.privileges.delete == 1) 
					? `<button type="button" ng-click="disableQuotation(${data.id})" class="btn btn-xs btn-danger" tooltip-placement="top" uib-tooltip="Deshabilitar"><i class="fa fa-ban"></i></button>` 
					: ``
				}
				return `${privilege.read} ${privilege.update} ${privilege.delete}`;
			})
	];

	$scope.dtInstanceQuotationsApprove = {};
	$scope.reloadDataQuotationsApprove = function() {
		$scope.dtInstanceQuotationsApprove.reloadData(function () {
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

	$scope.disableQuotation = function(quotation_id) {
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
				.disableQuotation(quotation_id)
				.then(function() {
					$scope.activeAlert(Quotations.status, Quotations.message);

					if(Quotations.err == false) $scope.reloadDataQuotationsApprove();
				});
				
		  }
		});
	}

	$scope.approveQuotation = function(quotation_id) {
		swal({
		  title: "¿Estás seguro que desea aprobar la cotización?",
		  text: "Luego de esto, la cotización podrá validarse como orden",
		  icon: "info",
		  buttons: true,
		  dangerMode: false,
		  buttons: ["Cancelar", "Aprobar"]
		})
		.then((willDelete) => {
		  if (willDelete) {
			$scope.alerts = [];

		  	Quotations_approve
				.approveQuotation(quotation_id)
				.then(function() {
					$scope.activeAlert(Quotations_approve.status, Quotations_approve.message);

					if(Quotations_approve.err == false) $scope.reloadDataQuotationsApprove();
				});
				
		  }
		});
	}

	$scope.approveAllQuotations = function() {
		swal({
			title: "¿Estás seguro que desea aprobar todas las cotizaciones?",
			text: "Luego de esto, las cotizaciones se podrán validar como orden",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			buttons: ["Cancelar", "Aprobar todos"]
		  })
		  .then((willDelete) => {
			if (willDelete) {
			  $scope.alerts = [];
  
				Quotations_approve
				  .approveAllQuotations()
				  .then(function() {
					  $scope.activeAlert(Quotations_approve.status, Quotations_approve.message);
  
					  if(Quotations_approve.err == false) $scope.reloadDataQuotationsApprove();
				  });
				  
			}
		  });
	}
}]);