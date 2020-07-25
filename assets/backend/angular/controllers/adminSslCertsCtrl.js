var app = angular.module('pmediaApp.adminSslCertsCtrl', []);

app.controller('adminSslCertsCtrl', [
    '$scope', '$compile', '$uibModal', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 'Ssl_certs',
    function($scope, $compile, $uibModal, $filter, DTOptionsBuilder, DTColumnBuilder, Ssl_certs){

    $scope.setActive("adminSslCerts");

    Ssl_certs
		.getPrivileges()
		.then(function() {
			$scope.privileges = Ssl_certs.data_privileges;
        });
        
    $scope.assignDomainToCustomer = () => {
        $uibModal
            .open({
                animation: true,
                scope: $scope,
                backdrop: 'static',
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: `${base_url}admin/ssl-certificates/modal_assign_domain_to_customer_view`,
                controller: 'modalAssignDomainToCustomerCtrl',
                size: 'md'
            })
            .result.then(function () {}, function () {});
    }

    $scope.addDomain = () => {
        $uibModal
        .open({
            animation: true,
            scope: $scope,
            backdrop: 'static',
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: `${base_url}admin/domains/modal_add_view`,
            controller: 'modalAddDomainCtrl',
            size: 'md',
        })
        .result.then(function () {}, function () {});
    }

    $scope.dtOptionsSslCerts = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            url: `${base_url}admin/ssl-certificates/`,
            type: 'GET'
        })
        .withOption('createdRow', function(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        })
        .withOption('order', [[2, 'desc']])
        .withOption('processing', true)
        .withOption('serverSide', true)
        .withDataProp('data')
        .withBootstrap()
        .withBootstrapOptions({
            pagination: {
                classes: {
                    ul: 'pagination pagination-sm'
                }
            }
        })
        .withLanguageSource(language_dt);
        
        $scope.dtColumnsSslCerts = [
            DTColumnBuilder.newColumn(null).withTitle('Empresa')
                .renderWith(function(data, type, full, meta) {
                    return `<a href="${base_url}admin/#!/customers/${data.customer_id}/edit/" target="_blank">${data.customer_name}</a>`;
                }),
            DTColumnBuilder.newColumn('common_name').withTitle('Common Name'),
            DTColumnBuilder.newColumn(null).withTitle('Fecha de creación').withOption('order', 'asc').withOption('type', 'date')
                .renderWith(function(data, type, full, meta) {
                    return $filter('date')(data.created_at, 'dd/MM/yyyy HH:mm:ss', 'UTC');
                }),
            DTColumnBuilder.newColumn(null).withTitle('Última actualización').withOption('order', 'asc').withOption('type', 'date')
                .renderWith(function(data, type, full, meta) {
                    return $filter('date')(data.updated_at, 'dd/MM/yyyy HH:mm:ss', 'UTC');
                }),
            // DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
            //     .renderWith(function(data, type, full, meta) {

            //         let privilege = {
            //             read: ($scope.privileges.read == 1) ? `<button ng-click="getProduct(${data.id})" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></button>` : ``,
            //             update: ($scope.privileges.update == 1) ? `<a href="#!/products/${data.id}/edit/" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>`:'',
            //             delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteProduct(${data.id})" class="btn btn-xs btn-default"><i class="fa fa-close"></i></button>`:''
            //         }
            //         return `<div class="btn-group">${privilege.read} ${privilege.update} ${privilege.delete}</div>`;
            //     })
        ];

        $scope.dtInstanceSslCerts = {};
        $scope.reloadDataSslCerts = function() {
            $scope.dtInstanceSslCerts.reloadData(function () {
            }, false);
        }

}]);

// app.controller('modalAddSslCertCtrl', ['$scope', function($scope) {
//     console.log('Hola mundo');
// }]);

app.controller('modalAssignDomainToCustomerCtrl', [
    '$scope', '$uibModalInstance', 'Customers', 'Domains', 'Ssl_certs',
    ($scope, $uibModalInstance, Customers, Domains, Ssl_certs) => {
    // let domain_id = data.domain_id;
    $scope.isDisabledAssignDomainToCustomer = true;

    Customers
        .getCustomers()
        .then(function() {
            $scope.customers = Customers.data_customers;
        });
    
    Domains
        .getDomains()
        .then(function() {
            $scope.domains = Domains.data_domains;
        });    

    $scope.saveAssignDomainToCustomer = (ssl_cert) => {
        $scope.isDisabledAssignDomainToCustomer = false;
        
        Ssl_certs
            .assignDomainToCustomer(ssl_cert)
            .then(function() {
                $scope.isDisabledAssignDomainToCustomer = true;

                if(Ssl_certs.err == false) {
                    $scope.activeAlert(Ssl_certs.status, Ssl_certs.message);

                    $uibModalInstance.close('closed');
                    if($scope.dtInstanceSslCerts) $scope.reloadDataSslCerts();
                } else {
                        
                    $scope.alertsAssignDomainToCustomer = [{
                        status: Ssl_certs.status,
                        message: Ssl_certs.message
                    }];
                }
            });

    }

    $scope.closeModal = function () {
        $uibModalInstance.dismiss('cancel');
    };
}]);