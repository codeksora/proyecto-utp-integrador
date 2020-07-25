var app = angular.module('pmediaApp.adminDomainsCtrl', []);

app.controller('adminDomainsCtrl', [
    '$scope', '$compile', '$filter', '$uibModal', 'DTOptionsBuilder', 'DTColumnBuilder', 'Domains',
function($scope, $compile, $filter, $uibModal, DTOptionsBuilder, DTColumnBuilder, Domains) {

    $scope.isDisabled = true;

    Domains
		.getPrivileges()
		.then(function() {
			$scope.privileges = Domains.data_privileges;
		});

    $scope.dtOptionsDomains = DTOptionsBuilder.newOptions()
		.withOption('ajax', {
			url: `${base_url}admin/domains/`,
			type: 'GET'
		})
		.withOption('createdRow', function(row, data, dataIndex) {
			$compile(angular.element(row).contents())($scope);
		})
		.withOption('order', [[0, 'desc']])
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
        
    $scope.dtColumnsDomains = [
        DTColumnBuilder.newColumn('common_name').withTitle('Common name'),
        DTColumnBuilder.newColumn(null).withTitle('Fecha Creación').withOption('type', 'date')
            .renderWith(function(data, type, full, meta) {
                return $filter('date')(data.created_at, 'dd/MM/yyyy', 'UTC');
            }),
        DTColumnBuilder.newColumn(null).withTitle('Última actualización').withOption('type', 'date')
        .renderWith(function(data, type, full, meta) {
            return $filter('date')(data.updated_at, 'dd/MM/yyyy', 'UTC');
        }),
        DTColumnBuilder.newColumn('full_name').withTitle('Creado por'),
        DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
            .renderWith(function(data, type, full, meta) {

                let privilege = {
                    read: ($scope.privileges.read == 1) ? `<button ng-click="assignCustomer(${data.id})" class="btn btn-xs btn-default" tabindex="0" uib-tooltip="Ver clientes asignados" tooltip-trigger="focus"><i class="fa fa-eye"></i></button>` : ``,
                    update: ($scope.privileges.update == 1) ? `<a href="#!/products/${data.id}/edit/" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i> Asignar</a>`:'',
                    delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteProduct(${data.id})" class="btn btn-xs btn-default" tabindex="0" uib-tooltip="Eliminar" tooltip-trigger="focus"><i class="fa fa-close"></i></button>`:''
                }
                return `<div class="btn-group">${privilege.read} ${privilege.update} ${privilege.delete}</div>`;
            })
    ];

    $scope.dtInstanceDomains = {};
    $scope.reloadDataDomains = function() {
        $scope.dtInstanceDomains.reloadData(function(json) {
        }, false);
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

    $scope.assignCustomer = (id) => {
        $uibModal
        .open({
            animation: true,
            scope: $scope,
            backdrop: 'static',
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: `${base_url}admin/domains/modal_assign_customer_view`,
            controller: 'modalAssignCustomerCtrl',
            size: 'md',
            resolve: {
                data: {
                    domain_id: id
                }
            }
        })
        .result.then(function () {}, function () {});
    }
}]);


app.controller('modalAddDomainCtrl', [
    '$scope', '$uibModalInstance', 'Domains',
    function($scope, $uibModalInstance, Domains) {
        $scope.isDisabledAddDomain = true;
        $scope.alertsAddDomain = [];

        $scope.saveDomain = (domain) => {
            $scope.alertsAddDomain = [];
            $scope.isDisabledAddDomain = false;
            Domains
                .addDomain(domain)
                .then(function() {
                    $scope.isDisabledAddDomain = true;
                    if(Domains.err === false) {
                        $scope.activeAlert(Domains.status, Domains.message);

                        if($scope.dtInstanceDomains) $scope.reloadDataDomains();
                        $uibModalInstance.close('closed');
                    } else {
                        
                        $scope.alertsAddDomain = [{
                            status: Domains.status,
                            message: Domains.message
                        }];
                    }
                });
            
        }

        $scope.closeAlert = function(index) {
            $scope.alertsAddDomain.splice(index, 1);
        };

        $scope.closeModal = function () {
            $uibModalInstance.dismiss('cancel');
        };
}]);

app.controller('modalAssignCustomerCtrl', [
    '$scope', '$uibModalInstance', 'data', 'Domains', 'Customers', 
    ($scope, $uibModalInstance, data, Domains, Customers) => {

    let domain_id = data.domain_id;

    Customers
        .getCustomers()
        .then(function() {
            $scope.customers = Customers.data_customers;
        });

    Domains
        .getCustomersByDomain(domain_id)
        .then(function() {
            $scope.domainsCustomers = Domains.data_customers;
        });

    $scope.addCustomer = () => {
 
        $scope.domainsCustomers.push(
            {
                name: 'hola',
                document_number: '4654654'
            }
        );

    }

    $scope.closeModal = function () {
        $uibModalInstance.dismiss('cancel');
    };
}]);


