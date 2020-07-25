var app = angular.module('pmediaApp.adminProductTypeCtrl', []);

app.controller('adminProductTypeCtrl', ['$scope', '$routeParams', 'Users', 'Roles', function($scope, $routeParams, Users, Roles){

	var id = $routeParams.id;

	$scope.user = {};
	$scope.disable = false;

	$scope.add = function(user) {
		$scope.disable = true;

		Users.addUser(user).then(function() {
			$scope.disable = false;
	  		swal("Se ha agregado correctamente", {
		      icon: "success",
		    });

		    window.location = "#!/users/";
	  	});
	}

	$scope.save = function(user) {
		$scope.disable = true;

		Users.saveUser(user).then(function() {
			$scope.disable = false;
	  		swal("Se ha actualizado correctamente", {
		      icon: "success",
		    });

		    window.location = "#!/users/";
	  	});
	}

	Roles.getRoles().then(function() {
		$scope.all_roles = Roles.data_all_roles;
	});
	
	if(id) {
		$scope.setActive("adminUsers"); 

		Users.getUser(id).then(function() {
	  		
	  		$scope.user = Users.data_user;
	  	});

	}
	else {
		$scope.setActive("adminUserAdd");

	};

	

}]);