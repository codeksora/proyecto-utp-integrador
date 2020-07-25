var app = angular.module('pmediaApp.adminProfileCtrl', []);

app.controller('adminProfileCtrl', [
	'$scope', '$routeParams', 'Profile', 'Roles', 'Menus', 'Images', 
	function($scope, $routeParams, Profile, Roles, Menus, Images){

	var id = $routeParams.id;

	$scope.setActive("adminProfile");

	$scope.profile = {};
	$scope.disable = false;
	$scope.all_images = [];
	$scope.user = {};
	
	Images.getAllImages().then(function() {
		$scope.all_images = Images.data_all_images;
	});

	$scope.save = function(user) {
		$scope.disable = true;

		Profile.saveProfile(user).then(function() {
			$scope.disable = false;
	  		swal("Se ha actualizado correctamente", {
				icon: "success",
			});
			
			setTimeout(function() {
				location.reload();
			}, 1500);
	  	});
	}

	$scope.savePass = function(user) {
		$scope.disable = true;

		Profile.saveNewPass(user).then(function() {
			$scope.disable = false;
			if(Profile.err == false) {
				swal(Profile.msg, {
					icon: 'success',
				});	

				setTimeout(function() {
					location.reload();
				}, 1500);

			} else {
				swal(Profile.msg, {
					icon: 'error',
				});	
			}
						
			
		});
	}
	
  	Menus.getMenus().then(function() {
		$scope.all_menus = Menus.data_all_menus;
	});
	  
	$scope.add_image = function(image) {
		$scope.disable = true; 
		
		Images.addImage(image).then(function() {
			$scope.disable = false;
			if(Images.err) {
				swal(Images.msg, {
					icon: "error"
				});
			} else {
				swal("Se ha agregado correctamente", {
					icon: "success"
				});
				
				$scope.image = {};
				$scope.formImage.$setPristine();
				
				Images.getAllImages().then(function() {
					$scope.all_images = Images.data_all_images;
				});
				
			}
		});
	}
	/*
	if(id) {
		$scope.setActive("adminPrivileges"); 

		Privileges.getPrivilege(id).then(function() {
	  		
	  		$scope.privilege = Privileges.data_privilege;
	  	});

	}
	else {
		$scope.setActive("adminPrivilegeAdd");

	};*/

	Profile.getProfile().then(function() {
		$scope.user = Profile.data_user;
	})
	

}]);