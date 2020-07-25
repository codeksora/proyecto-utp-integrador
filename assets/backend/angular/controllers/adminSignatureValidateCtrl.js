var app = angular.module('pmediaApp.adminSignatureValidateCtrl', []);

app.controller('adminSignatureValidateCtrl', [
    '$scope', '$routeParams', '$compile', '$filter', 'Signatures_validate', 'DTColumnBuilder', 'DTOptionsBuilder', 'Customers',
    function($scope, $routeParams, $compile, $filter, Signatures_validate, DTColumnBuilder, DTOptionsBuilder, Customers){

    var id = $routeParams.id;

    $scope.setActive("adminSignatureValidate");

    if(id) {

        $scope.isDisabled = true;

        Signatures_validate
            .getSignatureValidate(id)
            .then(function() {
                $scope.signature = Signatures_validate.data_signature_validate;
            });

	    $scope.save = function(signature) {
	        $scope.isDisabled = false;

	        Signatures_validate
	            .validateSignature(signature)
	            .then(function() {
	                $scope.isDisabled = true;
	                
	                $scope.activeAlert(Signatures_validate.status, Signatures_validate.message);

	                if(Signatures_validate.err == false) window.location = "#!/signatures-validate/";

	            });
	    }

	    $scope.verifyRUC = function(ruc) {
			Customers
				.getCustomerByRuc(ruc)
				.then(function() {
					$scope.activeAlert(Customers.status, Customers.message);
				});
	    }
    }

}]);