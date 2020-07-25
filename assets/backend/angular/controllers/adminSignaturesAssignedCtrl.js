var app = angular.module('pmediaApp.adminSignaturesAssignedCtrl', []);

app.controller('adminSignaturesAssignedCtrl', [
    '$scope', '$compile', '$filter', '$uibModal', 'DTOptionsBuilder', 'DTColumnBuilder', 'Signatures_assigned',
    function($scope, $compile, $filter, $uibModal, DTOptionsBuilder, DTColumnBuilder, Signatures_assigned) {

    $scope.setActive("adminSignaturesAssigned");

    Signatures_assigned
		.getPrivileges()
		.then(function() {
			$scope.privileges = Signatures_assigned.data_privileges;
        });

    $scope.dtOptionsSignaturesAssigned = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            //?signature_status_s=${ssl_certificate_status_s}
            url: `${base_url}admin/signatures-assigned/`,
            type: 'GET'
        })
        .withOption('createdRow', function(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        })
        .withOption('processing', true)
        .withOption('order', [[4, 'asc']])
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

    $scope.dtColumnsSignaturesAssigned = [
        DTColumnBuilder.newColumn('customer_name').withTitle('Cliente'),
        DTColumnBuilder.newColumn('product_name').withTitle('Producto'),
        DTColumnBuilder.newColumn('persnombreuser').withTitle('Usuario'),
        DTColumnBuilder.newColumn('persmailuser').withTitle('Correo'),
        DTColumnBuilder.newColumn(null).withTitle('Actualizado en').withOption('type', 'date')
                .renderWith(function(data, type, full, meta) {
                    return $filter('date')(data.updated_at, 'dd/MM/yyyy', 'UTC');
                }),
        DTColumnBuilder.newColumn('user_full_name').withTitle('Técnico'),
        DTColumnBuilder.newColumn(null).withTitle('Estado').withClass('td-small text-center')
            .renderWith(function(data, type, full, meta) {              
                return `<span class="label bg-${data.signature_status_class}">${data.signature_status_name}</span>`;
            }),
        DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
            .renderWith(function(data, type, full, meta) {              
                let privilege = {
                    read: ($scope.privileges.read == 1) ? `<button ng-click="getSignatureAssigned(${data.id})" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></button>` : ``
                }
                return `<div class="btn-group">${privilege.read}</div>`;
            })
    ];

    $scope.dtInstanceSignaturesAssigned = {};
    $scope.reloadDataSignaturesAssigned = function() {
        $scope.dtInstanceSignaturesAssigned.reloadData(function () {
        }, false);
    }

    $scope.getSignatureAssigned = function(signature_assigned_id) {
        $uibModal
            .open({
                animation: true,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: `${base_url}admin/signatures-assigned/modal_view`,
                controller: 'modalSignatureAssignedCtrl',
                backdrop: 'static',
                scope: $scope,
                size: 'lg',
                resolve: {
                    data: { signature_assigned_id }
                }
            })
            .result.then(function () {}, function () {});
    }

}]);

app.controller('modalSignatureAssignedCtrl', [
    '$scope', '$uibModalInstance', '$uibModal', 'data', 'Signatures_assigned', 'Contacts', 'Contacts_signatures_assigned',
    function($scope, $uibModalInstance, $uibModal, data, Signatures_assigned, Contacts, Contacts_signatures_assigned) {
    let signature_assigned_id = data.signature_assigned_id;

    $scope.isDisabledSignatureAssigned = true;

    Contacts_signatures_assigned
        .getContactsSignaturesAssigned(signature_assigned_id)
        .then(function() {
            $scope.contacts_signatures_assigned = Contacts_signatures_assigned.data_contacts_signatures_assigned;
        })
           

    Signatures_assigned
        .getSignatureAssigned(signature_assigned_id)
        .then(function() { 
            $scope.signature_assigned = Signatures_assigned.data_signature_assigned;

            $scope.single_date_options = {
                singleDatePicker: true,
                locale: {
                        format: "DD/MM/YYYY",
                        daysOfWeek: [ "Dom", "Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb"]
                }
            }

            Contacts
                .getContactsByCustomer(Signatures_assigned.data_signature_assigned.customer_id)
                .then(function() {
                    $scope.contacts = Contacts.data_contacts;
                });

            if($scope.signature_assigned.issue_date == '') $scope.signature_assigned.issue_date = moment();
            if($scope.signature_assigned.expiration_date == '') $scope.signature_assigned.expiration_date = moment().add(1, 'year');
            if($scope.signature_assigned.installation_date == '') $scope.signature_assigned.installation_date = moment();
        
        });

    $scope.deleteContactSignatureAssigned = function(contact_signature_assigned_id) {
        Contacts_signatures_assigned
            .deleteContactsSignaturesAssigned(contact_signature_assigned_id, signature_assigned_id)
            .then(function() {
                Contacts_signatures_assigned
                    .getContactsSignaturesAssigned(signature_assigned_id)
                    .then(function() {
                        $scope.contacts_signatures_assigned = Contacts_signatures_assigned.data_contacts_signatures_assigned;
                    });
            });
    }

    $scope.contactSel = {}

    $scope.contactSel.allItemsSelected = false;

    $scope.selectAll = function () { 

        for (var i = 0; i < $scope.contacts.length; i++) {
            $scope.contacts[i].isChecked = $scope.contactSel.allItemsSelected;
        }
    };

    $scope.selectEntity = function () {
        for (var i = 0; i < $scope.contacts.length; i++) {    
            if (!$scope.contacts[i].isChecked) {
                $scope.contactSel.allItemsSelected = false;
                return;
            }
        }
        $scope.contactSel.allItemsSelected = true;
    };

    $scope.toInstall = function(signature_assigned) {
        $scope.isDisabledSignatureAssigned = false;
        $scope.alertsSignaturesAssigned = [];

    Signatures_assigned
        .sendToInstall(signature_assigned)
        .then(function() {
            if(Signatures_assigned.err == false) {
                $scope.activeAlert(Signatures_assigned.status, Signatures_assigned.message);
                
                $uibModalInstance.close('closed');
                if($scope.dtInstanceSignaturesAssigned) $scope.reloadDataSignaturesAssigned();
            } else {
                    
                $scope.alertsSignaturesAssigned = [{
                    status: Signatures_assigned.status,
                    message: Signatures_assigned.message
                }];
            }
            $scope.isDisabledSignatureAssigned = true;
        });
    }

    $scope.assignContacts = function() {
        $uibModal
            .open({
                animation: true,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: `${base_url}admin/signatures-assigned/modal_assign_contacts_view`,
                controller: 'modalAssignContactsSignatureCtrl',
                scope: $scope,
                size: 'lg',
                resolve: {
                    data: {
                        id: signature_assigned_id
                    } 
                }
            })
            .result.then(function () {
                Contacts_signatures_assigned
                    .getContactsSignaturesAssigned(signature_assigned_id)
                    .then(function() {
                        $scope.contacts_signatures_assigned = Contacts_signatures_assigned.data_contacts_signatures_assigned;
                    });
            }, function () {});
    }


    $scope.closeAlert = function(index) {
        $scope.alertsSslCertsAssigned.splice(index, 1);
    };

    $scope.closeModal = function() {
        $uibModalInstance.dismiss('cancel');
    };
}]);

app.controller('modalAssignContactsSignatureCtrl', [
    '$scope', '$uibModalInstance', 'data', 'Contact_types', 'Contacts_signatures_assigned',
    function($scope, $uibModalInstance, data, Contact_types, Contacts_signatures_assigned) {

    let signature_assigned_id = data.id;

    $scope.isDisabledContactsSignature = true;
    $scope.contact_to_signature = {}

    Contact_types
        .getContactTypes()
        .then(function() {
            $scope.contact_types = Contact_types.data_contact_types;
        });

    $scope.addContactsToSignatureAssigned = function(contact_to_signature) {
        $scope.isDisabledContactsSignature = false;
        $scope.alertsContactsSslCert = [];
        $scope.alertsSslCertsAssigned = [];

        Contacts_signatures_assigned
            .addContactsSignaturesAssigned($scope.contacts, contact_to_signature, signature_assigned_id)
            .then(function() {
                $scope.isDisabledContactsSignature = true;

                if(Contacts_signatures_assigned.err == false) { 
                    $scope.alertsSignaturesAssigned = [{
                        status: Contacts_signatures_assigned.status,
                        message: Contacts_signatures_assigned.message
                    }];
                    $uibModalInstance.close('closed');

                } else {
                        
                    $scope.alertsContactsSignature = [{
                        status: Contacts_signatures_assigned.status,
                        message: Contacts_signatures_assigned.message
                    }];
                }
        //         // $scope.isDisabledContactsSslCert = true;
            });
    }





    $scope.closeModalAssignContacts = function() {
        $uibModalInstance.dismiss('cancel');
    };
}]);