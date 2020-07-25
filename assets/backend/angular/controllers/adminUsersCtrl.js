var app = angular.module('pmediaApp.adminUsersCtrl', []);

app.controller('adminUsersCtrl', [
	'$scope', '$uibModal', '$compile', '$location', 'DTOptionsBuilder', 'DTColumnBuilder', 'Users',
	function($scope, $uibModal, $compile, $location, DTOptionsBuilder, DTColumnBuilder, Users){
	
	$scope.setActive("adminUsers");

	$scope.users = [];
	$scope.user = {};
	$scope.alerts = [];

	var q = $location.search().q;
	$scope.search = {
		q 
	}

//$scope.dtInstanceProducts.changeData(`${base_url}admin/products/?provider_s=${provider_s}&product_type_s=${product_type_s}&startRec_s=${startRec_s}&endRec=${endRec_s}`);
	
	$scope.searchUser = function(search) {
		var q = search.q;
		q ? $location.url('/users?q='+q) : $location.url('/users');
	}

	Users
		.getPrivileges()
		.then(function() {
			$scope.privileges = Users.data_privileges;
		});

	$scope.getUser = function(id) {
		$uibModal
		.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: `${base_url}admin/users/modal_view`,
			controller: 'modalUserCtrl',
			size: 'md',
			resolve: {
				data: function () {
					return {
						user_id: id
					};
				}
			}
		})
		.result.then(function () {}, function () {});
	}

	
	$scope.dtOptionsUsers = DTOptionsBuilder.newOptions()
		.withOption('ajax', {
			url: `${base_url}admin/users`,
			type: 'GET',
			data: {
				search: {
					value: q
				}
			}
		})
		.withOption('createdRow', function(row, data, dataIndex) {
			$compile(angular.element(row).contents())($scope);
		})
		.withOption('searching', false)
		.withOption('processing', true)
		.withOption('serverSide', true)
		.withOption('responsive', true)
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

	$scope.dtColumnsUsers = [
		DTColumnBuilder.newColumn('full_name').withTitle('Nombre'),
		DTColumnBuilder.newColumn('username').withTitle('Nombre de usuario'),
		DTColumnBuilder.newColumn('email').withTitle('Email'),
		DTColumnBuilder.newColumn('role_name').withTitle('Rol'),
		DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
			.renderWith(function(data, type, full, meta) {				
				let privilege = {
					read: ($scope.privileges.read == 1) ? `<button ng-click="getUser(${data.id})" class="btn btn-xs btn-info" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button>` : ``,
					update: ($scope.privileges.update == 1) ? `<a href="#!/users/${data.id}/edit/" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Editar"><i class="fa fa-pencil"></i></a>`:'',
					delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteUser(${data.id})" class="btn btn-xs btn-danger" tooltip-placement="top" uib-tooltip="Eliminar"><i class="fa fa-close"></i></button>`:''
				}
				return `${privilege.read} ${privilege.update} ${privilege.delete}`;
			})
	];

	$scope.dtInstanceUsers = {};
	$scope.reloadDataUsers = function() {
		$scope.dtInstanceUsers.reloadData(function () {
		}, false);
	}

	$scope.deleteUser = function(user_id) {
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

		  	Users
				.deleteUser(user_id)
				.then(function() {
					$scope.activeAlert(Users.status, Users.message);

					if(Users.err == false) $scope.reloadDataUsers();
				});
				
		  }
		});
	}

}]);

app.controller('modalUserCtrl', function ($scope, $uibModalInstance, data, Users) {
	let user_id = data.user_id;

	Users
		.getUser(user_id)
		.then(function() {
			$scope.user = Users.data_user;
		});

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
});