var app = angular.module('pmediaApp.adminProviderCtrl', []);

app.controller('adminProviderCtrl', [
	'$scope', '$routeParams', 'Providers',
	function($scope, $routeParams, Providers){

	var id = $routeParams.id;

	$scope.isDisabledProviders = true;

	$scope.add = function(provider) {
		$scope.isDisabledProviders = false;

		Providers.addProvider(provider).then(function() {

	  		$scope.activeAlert(Providers.status, Providers.message);
    
            if(Providers.err == false) {
            	window.location = "#!/providers/";
            } else {
            	$scope.isDisabledProviders = true;
            }
	  	});
	}

	
	
	if(id) {
		$scope.setActive("adminProviders"); 

		Providers.getProvider(id).then(function() {
	  		
	  		$scope.provider = Providers.data_provider;
	  	});

	  	$scope.save = function(provider) {
			$scope.isDisabledProviders = false;

			Providers.saveProvider(provider).then(function() {

				$scope.activeAlert(Providers.status, Providers.message);
    
	            if(Providers.err == false) window.location = "#!/providers/";
	            else $scope.isDisabledProviders = true;
		  	});
		}

	}
	else {
		$scope.setActive("adminProviderAdd");

	};

	

}]);