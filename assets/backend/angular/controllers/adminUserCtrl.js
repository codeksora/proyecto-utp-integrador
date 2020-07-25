var app = angular.module('pmediaApp.adminUserCtrl', []);

app.controller('adminUserCtrl', [
	'$scope', '$routeParams', 'Users', 'Roles', 
	function($scope, $routeParams, Users, Roles){

	var id = $routeParams.id;

	$scope.user = {};
	$scope.isDisabled = true;
	$scope.alerts = [];

	$scope.add = function(user) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Users.addUser(user).then(function() {
			$scope.isDisabled = true;

			$scope.activeAlert(Users.status, Users.message);

			if(Users.err == false) window.location = "#!/users/";
		});
	}

	Roles
		.getRoles()
		.then(function() {
			$scope.roles = Roles.data_roles;
		});

	if(id) {
		$scope.setActive("adminUsers");

		Users
			.getUser(id)
			.then(function() {
				$scope.user = Users.data_user;

				if(Users.err == true) window.location = "#!/users/";
			});

		$scope.save = function(user) {
			$scope.isDisabled = false;
			$scope.alerts = [];

			Users
				.saveUser(user, id)
				.then(function() {
					$scope.isDisabled = true;

					$scope.activeAlert(Users.status, Users.message);

					if(Users.err == false) window.location = "#!/users/";
				});
		}

	} else {
		$scope.setActive("adminUserAdd");

	};



}]);
