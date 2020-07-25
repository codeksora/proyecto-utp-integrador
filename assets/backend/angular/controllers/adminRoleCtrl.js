var app = angular.module('pmediaApp.adminRoleCtrl', []);

app.controller('adminRoleCtrl', [
	'$scope', '$routeParams', 'Roles', 'Menus', 'Privileges', 
	function($scope, $routeParams, Roles, Menus, Privileges){

	var role_id = $routeParams.id;

	$scope.role = {};
	$scope.isDisabled = true;
	$scope.alerts = [];

	$scope.add = function(role) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Roles.addRole(role).then(function() {
			$scope.isDisabled = true;

		    $scope.alerts = [{
				status: Roles.status,
				message: Roles.message
			}];

			if(Roles.err == false) $scope.role = {}
	  	});
	}

	 

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	};

	$scope.save = function(role) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Roles.saveRole(role, role_id).then(function() {
			$scope.isDisabled = true;
			
			$scope.alerts = [{
				status: Roles.status,
				message: Roles.message
			}];
	  	});
	}
	
	if(role_id) {
		$scope.setActive("adminRoles"); 

		Roles.getRole(role_id).then(function() {
	  		
			  $scope.role = Roles.data_role;
			  
			  if(Roles.err == true) window.location = "#!/roles/";
	  	});

	  	Privileges.getPrivilegesByRole(role_id).then(function() {
			$scope.role.menus = Privileges.data_privileges;
		});

	}
	else {
		$scope.setActive("adminRoleAdd");

		Menus.getMenus().then(function() {
			$scope.role.menus = Menus.data_menus;
		});

	};

	

}]);