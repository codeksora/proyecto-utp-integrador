var app = angular.module('pmediaApp.adminContactCtrl', []);

app.controller('adminContactCtrl', [
    '$scope', '$routeParams', 'Contacts', 'Phone_codes', 'Countries', 'Customers', 'Contact_types',
    function($scope, $routeParams, Contacts, Phone_codes, Countries, Customers, Contact_types){

    $scope.setActive("adminContact"); 
    
    const contact_id = $routeParams.id;

    $scope.isDisabled = true;
    $scope.isDisabledSearch = true;
    
    $scope.contact = {};
    $scope.contacts = [];
    $scope.phone_codes = [];
    $scope.countries = [];
    $scope.customers = [];
    $scope.contact_types = [];

    $scope.alerts = [];

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

    Customers
        .getCustomers()
        .then(function() {
            $scope.customers = Customers.data_customers;
        });

    Contact_types
        .getContactTypes()
        .then(function() {
            $scope.contact_types = Contact_types.data_contact_types;
        });

    $scope.searchOnSunat = function(document_number) {
        $scope.isDisabledSearch = false;
        Invoices
            .getDetailByDocNum(document_number)
            .then(function() {
                $scope.customer = Invoices.data_customer;
                $scope.isDisabledSearch = true;
            });
    }

    $scope.getCustomer = function(customer_id) {

        Customers
            .getCustomer(customer_id)
            .then(function() {
                $scope.contact.phone_code_id = Customers.data_customer.phone_code_id;
                $scope.contact.address_line_1 = Customers.data_customer.address_line_1;
                $scope.contact.address_line_2 = Customers.data_customer.address_line_2;
                $scope.contact.state = Customers.data_customer.state;
                $scope.contact.city = Customers.data_customer.city;
                $scope.contact.country_id = Customers.data_customer.country_id;
                $scope.contact.phone = Customers.data_customer.phone;
                $scope.contact.mobile_phone = Customers.data_customer.mobile_phone;
                $scope.contact.extension = Customers.data_customer.extension;
            });
    }
    
    if(contact_id) {

        $scope.setActive("adminContacts");
        
        Contacts.getContact(contact_id).then(function() {
            $scope.contact = Contacts.data_contact;
        });

        $scope.saveContact = function(contact) {
            $scope.isDisabled = false;
            $scope.alerts = [];
    
            Contacts.save(contact).then(function() {
                $scope.isDisabled = true;

                $scope.activeAlert(Contacts.status, Contacts.message);
    
                if(Contacts.err == false) window.location = "#!/contacts/";
              });
        }

	}
    else {
        $scope.add = function(contact) {
            $scope.isDisabled = false;
            $scope.alerts = [];

            Contacts
                .addContact(contact)
                .then(function() {
                    $scope.isDisabled = true;

                    $scope.activeAlert(Contacts.status, Contacts.message);

                    if(Contacts.err == false) {
                        $scope.contact = {}
                        window.location = "#!/contacts/";
                    }
                });
        }

        $scope.setActive("adminContactAdd");
    }
   

}]);