var app = angular.module('pmediaApp.adminProvidersCtrl', []);

app.controller('adminProvidersCtrl', [
	'$scope', '$compile', '$filter', '$uibModal', 'DTOptionsBuilder', 'DTColumnBuilder', 'Providers',
	function($scope, $compile, $filter, $uibModal, DTOptionsBuilder, DTColumnBuilder, Providers) {

	$scope.setActive("adminProviders"); 

	Providers
		.getPrivileges()
		.then(function() {
			$scope.privileges = Providers.data_privileges;
		});

	$scope.dtOptionsProviders = DTOptionsBuilder.newOptions()
		.withOption('ajax', {
			url: `${base_url}admin/providers/dt/`,
			type: 'GET'
		})
		.withOption('createdRow', function(row, data, dataIndex) {
			$compile(angular.element(row).contents())($scope);
		})
		.withOption('processing', true)
		.withOption('serverSide', true)
		.withOption('order', [[4, 'desc']])
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

	$scope.dtColumnsProviders = [
		DTColumnBuilder.newColumn('name').withTitle('Nombre'),
		DTColumnBuilder.newColumn('phone').withTitle('Teléfono'),
		DTColumnBuilder.newColumn('email').withTitle('Email'),
		DTColumnBuilder.newColumn('website').withTitle('Sitio web'),
		DTColumnBuilder.newColumn(null).withTitle('última modificación').notVisible().withOption('type', 'date')
			.renderWith(function(data, type, full, meta) {
                return $filter('date')(data.updated_at, 'dd/MM/yyyy');
            }),
		DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
			.renderWith(function(data, type, full, meta) {				
				let privilege = {
					read: ($scope.privileges.read == 1) ? `<button ng-click="getProvider(${data.id})" class="btn btn-xs btn-info" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button>` : ``,
					update: ($scope.privileges.update == 1) ? `<a href="#!/providers/${data.id}/edit/" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Editar"><i class="fa fa-pencil"></i></a>`:'',
					delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteProvider(${data.id})" class="btn btn-xs btn-danger" tooltip-placement="top" uib-tooltip="Eliminar"><i class="fa fa-close"></i></button>`:''
				}
				return `${privilege.read} ${privilege.update} ${privilege.delete}`;
			})
	];

	$scope.dtInstanceProviders = {};
	$scope.reloadDataProviders = function() {
		$scope.dtInstanceProviders.reloadData(function () {
		}, false);
	}

	$scope.deleteProvider = function(provider_id) {
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

		  	Providers
				.deleteProvider(provider_id)
				.then(function() {
					$scope.activeAlert(Providers.status, Providers.message);

					if(Providers.err == false) $scope.reloadDataProviders();
				});
				
		  }
		});
	}

	$scope.getProvider = function(provider_id) {
		$uibModal
		.open({
			animation: true,
			scope: $scope,
            backdrop: 'static',
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: `${base_url}admin/providers/modal_view`,
			controller: 'modalProviderCtrl',
			size: 'md',
			resolve: {
				data: {
					provider_id
				}
			}
		})
		.result.then(function () {}, function () {});
	}


}]);

app.controller('modalProviderCtrl', [
	'$scope', '$uibModalInstance', 'data', 'Providers',
	function($scope, $uibModalInstance, data, Providers) {

	let provider_id = data.provider_id;		

	$scope.provider = {};

	Providers
        .getProvider(provider_id)
        .then(function() {
			$scope.provider = Providers.data_provider;
		});

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
}]);