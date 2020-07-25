var app = angular.module('pmediaApp.adminRolesCtrl', []);

app.controller('adminRolesCtrl', [
	'$scope', '$uibModal', 'DTOptionsBuilder', 'DTColumnBuilder', 'Roles', 
function($scope, $uibModal, DTOptionsBuilder, DTColumnBuilder, Roles) {
	
	$scope.setActive("adminRoles");

	$scope.roles = [];
	$scope.role = {};
	$scope.alerts = [];

	$scope.getRole = function(id) {
		Roles.getRole(id).then(function() {			
			$scope.role = Roles.data_role;

			$uibModal
			.open({
				animation: true,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: base_url + 'admin/roles/modal_view',
				controller: 'modalRoleCtrl',
				size: 'md',
				resolve: {
					data: function () {
						return $scope.role;
					}
				}
			})
			.result.then(function () {}, function () {});
		});
	}

	Roles.getRoles().then(function() {
		$scope.roles = Roles.data_roles;
	}); 

	var language = base_url + 'assets/backend/angular/lib/dataTables-spanish.json';
	
	$scope.dtOptions = DTOptionsBuilder.newOptions()
		.withBootstrap()
		.withLanguageSource(language);

	$scope.deleteRole = function(index, id) {
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

		  	Roles.deleteRole(id).then(function() {
				$scope.alerts = [{
					status: Roles.status,
					message: Roles.message
				}];

				if(Roles.err == false) $scope.roles.splice(index, 1);
		  	});
		    
		  }
		});
	}

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	};

}]);

app.controller('modalRoleCtrl', function ($scope, $uibModalInstance, data) {
	$scope.role = data;	

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
});