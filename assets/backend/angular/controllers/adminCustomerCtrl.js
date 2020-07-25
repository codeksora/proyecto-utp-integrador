var app = angular.module('pmediaApp.adminCustomerCtrl', []);

app.controller('adminCustomerCtrl', [
	'$scope', '$routeParams', 'Customers', 'Countries', 'Sunat', 'Document_types', 'Sectors', 'Phone_codes',
	function($scope, $routeParams, Customers, Countries, Sunat, Document_types, Sectors, Phone_codes){

	var id = $routeParams.id;

	$scope.client = {};
	$scope.isDisabled = true;
	$scope.countries = [];
	$scope.customer = {}


	$scope.isDisabledSearch = true;

	Phone_codes
        .getPhoneCodes()
        .then(function() {
            $scope.phone_codes = Phone_codes.data_phone_codes;
        });

	Countries
		.getCountries()
		.then(function() {
			$scope.countries = Countries.data_countries;
		});
	
	Document_types
		.getDocumentTypes()
		.then(function() {
			$scope.document_types = Document_types.data_document_types;
		});

	Sectors
		.getSectors()
		.then(function() {
			$scope.sectors = Sectors.data_sectors;
		});

	$scope.searchOnSunat = function(document_number) {
		$scope.isDisabledSearch = false;
		
		Sunat
			.getDataByRuc(document_number)
			.then(function() {
				$scope.customer.name = Sunat.data_sunat.name;
				$scope.customer.address_line_1 = Sunat.data_sunat.address;

				$scope.activeAlert(Sunat.status, Sunat.message);

				$scope.isDisabledSearch = true;
			});
	}

	$scope.searchOnSunatEdit = function(document_number) {
		$scope.isDisabledSearch = false;

		Sunat
			.getDataByRucEdit(document_number)
			.then(function() {
				$scope.customer.name = Sunat.data_sunat.name;
				$scope.customer.address_line_1 = Sunat.data_sunat.address;

				$scope.activeAlert(Sunat.status, Sunat.message);

				$scope.isDisabledSearch = true;
			});
	}

	$scope.add = function(customer) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Customers
			.addCustomer(customer)
			.then(function() {
				$scope.isDisabled = true;

				$scope.activeAlert(Customers.status, Customers.message);

				if(Customers.err == false) window.location = "#!/customers/";
			});
	}
	
	if(id) {
		$scope.setActive("adminCustomers"); 

		Customers
			.getCustomer(id)
			.then(function() {
				$scope.customer = Customers.data_customer;
			});
		  
		$scope.save = function(customer) {
			$scope.isDisabled = false;

			Customers
				.saveCustomer(customer)
				.then(function() {
					$scope.isDisabled = true;

					$scope.activeAlert(Customers.status, Customers.message);

					if(Customers.err == false) window.location = "#!/customers/";
				});
		}

	}
	else {
		$scope.setActive("adminCustomerAdd");
	};
}]);