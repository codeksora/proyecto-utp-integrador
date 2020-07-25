var app = angular.module('pmediaApp.adminPrivilegeCtrl', []);

app.controller('adminPrivilegeCtrl', [
	'$scope', '$routeParams', 'Privileges', 'Roles', 'Menus', 
function($scope, $routeParams, Privileges, Roles, Menus){

	var id = $routeParams.id;

	$scope.privilege = {};
	$scope.isDisabled = true;
	$scope.alerts = [];

	$scope.add = function(privilege) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Privileges.addPrivilege(privilege).then(function() {
			$scope.isDisabled = true;

			$scope.alerts = [{
				status: Privileges.status,
				message: Privileges.message
			}];

			if(Privileges.err == false) $scope.privilege = {}
	  	});
	}

	$scope.save = function(privilege) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Privileges.savePrivilege(privilege, id).then(function() {
			$scope.isDisabled = true;
			
			$scope.alerts = [{
				status: Privileges.status,
				message: Privileges.message
			}];
	  	});
	}

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	};

	Roles.getRoles().then(function() {
	  		
  		$scope.roles = Roles.data_roles;
  	});

  	Menus.getMenus().then(function() {
  		$scope.menus = Menus.data_menus;
  	});
	
	if(id) {
		$scope.setActive("adminPrivileges"); 

		Privileges.getPrivilege(id).then(function() {
			$scope.privilege = Privileges.data_privilege;

			if(Privileges.err == true) window.location = "#!/privileges/";
	  	});

	}
	else {
		$scope.setActive("adminPrivilegeAdd");

	};

	

}]);