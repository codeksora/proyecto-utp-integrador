var app = angular.module('pmediaApp.adminConfigurationsCtrl', []);

app.controller('adminConfigurationsCtrl', [
	'$scope', 'Configurations', 'Users', 'Customers',
	function($scope, Configurations, Users, Customers){
	
	$scope.setActive("adminConfigurations");

	$scope.countUsers          = 0;
	$scope.countContactUsUsers = 0;
	$scope.quantityCustomers      = 0;

	$scope.isDisabled = true;

	// Configurations.load().then(function() {
	// 	$scope.config = Configurations.config;
	// });


	Customers.getQuantityCustomers().then(function() {
		$scope.quantityCustomers = Customers.data_quantity_customers;
	});

	$scope.edit = function(config) {
		$scope.isDisabled = false;
        $scope.alerts = [];

		Configurations.saveConfig(config).then(function() {
			$scope.isDisabled = true;

            $scope.activeAlert(Configurations.status, Configurations.message);

            // if(Configurations.err == false) window.location = "#!/contacts/";
		});
	}

}]);