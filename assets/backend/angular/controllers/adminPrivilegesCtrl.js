var app = angular.module('pmediaApp.adminPrivilegesCtrl', []);

app.controller('adminPrivilegesCtrl', [
	'$scope', '$uibModal', 'DTOptionsBuilder', 'DTColumnBuilder', 'Privileges', 
function($scope, $uibModal, DTOptionsBuilder, DTColumnBuilder, Privileges) {
	
	$scope.setActive("adminPrivileges");

	$scope.privileges = [];
	$scope.privilege = {};
	$scope.alerts = [];
	
	$scope.getPrivilege = function(id) {
		Privileges.getPrivilege(id).then(function() {			
			$scope.privilege = Privileges.data_privilege;

			$uibModal
			.open({
				animation: true,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: base_url + 'admin/privileges/modal_view',
				controller: 'modalPrivilegeCtrl',
				size: 'md',
				resolve: {
					data: function () {
						return $scope.privilege;
					}
				}
			})
			.result.then(function () {}, function () {});
		});
	}

	Privileges.getPrivileges().then(function() {
		$scope.privileges = Privileges.data_privileges;
	});

	var language = base_url + 'assets/backend/angular/lib/dataTables-spanish.json';
	
	$scope.dtOptions = DTOptionsBuilder.newOptions()
		.withBootstrap()
		.withLanguageSource(language);

	$scope.deletePrivilege = function(index, id) {
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

		  	Privileges.deletePrivilege(id).then(function() {
				$scope.alerts = [{
					status: Privileges.status,
					message: Privileges.message
				}];

				if(Privileges.err == false) $scope.privileges.splice(index, 1);
		  	});
		    
		  }
		});
	}

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	};

}]);

app.controller('modalPrivilegeCtrl', function ($scope, $uibModalInstance, data) {
	$scope.privilege = data;	

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
});