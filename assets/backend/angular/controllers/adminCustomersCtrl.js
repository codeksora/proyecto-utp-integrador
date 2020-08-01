var app = angular.module('pmediaApp.adminCustomersCtrl', []);

app.controller('adminCustomersCtrl', [
	'$scope', '$uibModal', '$compile', 'DTOptionsBuilder', 'DTColumnBuilder', 'Customers',
	function($scope, $uibModal, $compile, DTOptionsBuilder, DTColumnBuilder, Customers){

	$scope.setActive("adminCustomers"); 

	$scope.customers = [];

	Customers
        .getPrivileges()
        .then(function() {
            $scope.privileges = Customers.data_privileges;
		});
		
	$scope.getCustomer = function(id) {
		$uibModal
		.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: `${base_url}admin/customers/modal_view`,
			controller: 'modalCustomersCtrl',
			size: 'lg',
			resolve: {
				data: {
					customer_id: id
				}
			}
		})
		.result.then(function () {}, function () {});
	}
	
	$scope.dtOptionsCustomers = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            url: `${base_url}admin/customers/`,
            type: 'GET'
        })
        .withOption('createdRow', function(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        })
        // .withOption('order', [[0, 'desc']])
        .withOption('processing', true)
        // .withOption('responsive', true)
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

	$scope.dtColumnsCustomers = [
		DTColumnBuilder.newColumn('name').withTitle('Cliente'),
		DTColumnBuilder.newColumn('document_number').withTitle('RUC'),
		DTColumnBuilder.newColumn('address_line_1').withTitle('Dirección 1'),
		DTColumnBuilder.newColumn('address_line_2').withTitle('Dirección 2'),
		DTColumnBuilder.newColumn('phone').withTitle('Teléfono'),
		// DTColumnBuilder.newColumn(null).withTitle('Estado')
		// 	.renderWith(function(data, type, full, meta) {
		// 		return data.validacion == 0 ? '<i class="fa fa-ban text-danger"></i>' : '<i class="fa fa-check text-success"></i>';
		// 	}),
		DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
			.renderWith(function(data, type, full, meta) {				
				let privilege = {
					read: ($scope.privileges.read == 1) ? `<button ng-click="getCustomer(${data.id})" class="btn btn-xs btn-info" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button>` : ``,
					update: ($scope.privileges.update == 1) ? `<a href="#!/customers/${data.id}/edit/" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Editar"><i class="fa fa-pencil"></i></a>`:'',
					delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteCustomer(${data.id})" class="btn btn-xs btn-danger" tooltip-placement="top" uib-tooltip="Eliminar"><i class="fa fa-close"></i></button>`:''
				}
				return `${privilege.read} ${privilege.update} ${privilege.delete}`;
			})
	];

	$scope.dtInstanceCustomers = {};
    $scope.reloadDataCustomers = function() {
        $scope.dtInstanceCustomers.reloadData(function () {
        }, false);
    }


	$scope.deleteCustomer = function(customer_id) {

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
				
				Customers
					.deleteCustomer(customer_id)
					.then(function() {
						$scope.activeAlert(Customers.status, Customers.message);

						if(Customers.err == false) $scope.reloadDataCustomers();
					});
					
			}
		});
	}
}]);

app.controller('modalCustomersCtrl', function($scope, $uibModalInstance, data, Customers) {
    let customer_id = data.customer_id;

    Customers
        .getCustomer(customer_id)
        .then(function() {
			$scope.customer = Customers.data_customer;
		});

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
});