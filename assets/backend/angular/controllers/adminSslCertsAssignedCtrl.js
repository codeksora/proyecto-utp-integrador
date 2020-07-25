var app = angular.module('pmediaApp.adminSslCertsAssignedCtrl', []);

app.controller('adminSslCertsAssignedCtrl', [
    '$scope', '$compile', '$filter', '$uibModal', '$location', 'DTOptionsBuilder', 
    'DTColumnBuilder', 'Ssl_certs_assigned', 'Ssl_cert_status',
    function($scope, $compile, $filter, $uibModal, $location, DTOptionsBuilder, 
        DTColumnBuilder, Ssl_certs_assigned, Ssl_cert_status) {

    $scope.setActive("adminSslCertsAssigned");
   
    $scope.ssl_certificate_status = [];
    
    $scope.search = {}

    // let ssl_certificate_status_id = '';

    ssl_certificate_status_id = parseInt($location.search().ssl_certificate_status_id) || '';

    
    $scope.search = {
        ssl_certificate_status_id: (ssl_certificate_status_id == '' ? undefined : ssl_certificate_status_id)
    }

    // ssl_certificate_status_id ? ssl_certificate_status_id : 0;

    // $search.

    Ssl_certs_assigned
		.getPrivileges()
		.then(function() {
			$scope.privileges = Ssl_certs_assigned.data_privileges;
        });
        
    Ssl_cert_status
        .getSslCertStatus()
        .then(function() {
            $scope.ssl_cert_status = Ssl_cert_status.data_ssl_cert_status;
        });

    $scope.searchSslCertificateAssigned = function(search) {
		var ssl_certificate_status_id = search.ssl_certificate_status_id;
        ssl_certificate_status_id ? $location.url('/ssl-certificates-assigned?ssl_certificate_status_id='+ssl_certificate_status_id) 
        : $location.url('/ssl-certificates-assigned');
	}

    
    let ssl_certificate_status_s = '';

    // $scope.searchSslCertificateAssigned = function(search) { 
    //     ssl_certificate_status_s = search.ssl_certificate_status_id ? search.ssl_certificate_status_id : '';

    // $scope.dtOptionsSslCertsAssigned = DTOptionsBuilder.newOptions()
    //     .withOption('ajax', {
    //         url: `${base_url}admin/ssl-certificates-assigned/?ssl_certificate_status_s=${ssl_certificate_status_s}`,
    //         type: 'GET',
            
    //     })
    //     .withOption('createdRow', function(row, data, dataIndex) {
    //         $compile(angular.element(row).contents())($scope);
    //     })
    //     .withOption('processing', true)
    //     // .withOption('responsive', true)
    //     .withOption('order', [[3, 'asc']])
    //     .withOption('serverSide', true)
    //     .withDataProp('data')
    //     .withBootstrap()
    //     .withBootstrapOptions({
    //         pagination: {
    //             classes: {
    //                 ul: 'pagination pagination-sm'
    //             }
    //         }
    //     })
    //     .withLanguageSource(language_dt);
    // }

    $scope.dtOptionsSslCertsAssigned = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            url: `${base_url}admin/ssl-certificates-assigned`,
            type: 'GET',
            data: {
				search: {
					ssl_certificate_status_id
				}
			}
        })
        .withOption('createdRow', function(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        })
        .withOption('processing', true)
        // .withOption('responsive', true)
        .withOption('order', [[3, 'desc']])
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

    $scope.dtColumnsSslCertsAssigned = [
        DTColumnBuilder.newColumn('customer_name').withTitle('Cliente'),
        DTColumnBuilder.newColumn('product_name').withTitle('Producto'),
        DTColumnBuilder.newColumn('common_name').withTitle('Common name'),
        DTColumnBuilder.newColumn('user_full_name').withTitle('Técnico'),
        // DTColumnBuilder.newColumn('operating_system_type_name').withTitle('S.O.'),
        // DTColumnBuilder.newColumn('server_type_name').withTitle('Tipo de servidor'),
        DTColumnBuilder.newColumn(null).withTitle('Actualizado en').withOption('type', 'date')
				.renderWith(function(data, type, full, meta) {
					return $filter('date')(data.updated_at, 'dd/MM/yyyy', 'UTC');
				}),
        DTColumnBuilder.newColumn(null).withTitle('Estado').withClass('td-small text-center')
            .renderWith(function(data, type, full, meta) {				
                return `<span class="label bg-${data.class}">${data.status_ssl_certificate_name}</span>`;
            }),
        DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
            .renderWith(function(data, type, full, meta) {				
                let privilege = {
                    read: ($scope.privileges.read == 1) ? `<button ng-click="getSslCertAssigned(${data.id})" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></button>` : ``
                }
                return `<div class="btn-group">${privilege.read}</div>`;
            })
    ];

    $scope.dtInstanceSslCertsAssigned = {};
    $scope.reloadDataSslCertsAssigned = function() {
        $scope.dtInstanceSslCertsAssigned.reloadData(function () {
        }, false);
    }

    $scope.getSslCertAssigned = function(id) { 
        $uibModal
			.open({
				animation: true,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: `${base_url}admin/ssl-certificates-assigned/modal_view`,
                controller: 'modalSslCertAssignedCtrl',
                backdrop: 'static',
                scope: $scope,
				size: 'lg',
				resolve: {
					data: {
						ssl_cert_assigned_id: id
					}
				}
			})
			.result.then(function () {}, function () {});
    }
}]);

app.controller('modalSslCertAssignedCtrl', [
    '$scope', '$uibModal', '$uibModalInstance', '$compile', 'data', 'DTOptionsBuilder', 'DTColumnBuilder', 'DTColumnDefBuilder',
    'Ssl_certs_assigned', 'Contacts', 'Orders', 'Additional_sans', 'Operating_system_types', 'Server_types', 'Contacts_ssl_certs_assigned', 'Comments_ssl_certs_assigned',
    function($scope, $uibModal, $uibModalInstance, $compile, data, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder,
        Ssl_certs_assigned, Contacts, Orders, Additional_sans, Operating_system_types, Server_types, Contacts_ssl_certs_assigned, Comments_ssl_certs_assigned) {

    let ssl_cert_assigned_id = data.ssl_cert_assigned_id;

    $scope.isDisabledSslCertAssigned = true;
    $scope.showFormDetail = false;
    $scope.isDisabledAddSan = true;

    $scope.prev_common_name = '';
    $scope.comment = {};
    $scope.alertsCommentSslCertsAssigned = [];
      
    Operating_system_types
        .getOperatingSystemTypes()
        .then(function() {
            $scope.operating_system_types = Operating_system_types.data_operating_system_types;
        });

    Server_types
        .getServerTypes()
        .then(function() {
            $scope.server_types = Server_types.data_server_types;
        });

    Contacts_ssl_certs_assigned
        .getContactsSslCertificatesAssigned(ssl_cert_assigned_id)
        .then(function() {
            $scope.contacts_ssl_certs_assigned = Contacts_ssl_certs_assigned.data_contacts_ssl_certificates_assigned;
        })
      
     Comments_ssl_certs_assigned
        .getCommentsSslCertificatesAssigned(ssl_cert_assigned_id)
        .then(function() {
            $scope.comments_ssl_certs_assigned = Comments_ssl_certs_assigned.data_comments_ssl_certificates_assigned;
        })

    Ssl_certs_assigned
        .getSslCertAssigned(ssl_cert_assigned_id)
        .then(function() {
            $scope.ssl_cert_assigned = Ssl_certs_assigned.data_ssl_cert_assigned;

            Contacts
                .getContactsByCustomer(Ssl_certs_assigned.data_ssl_cert_assigned.customer_id)
                .then(function() {
                    $scope.contacts = Contacts.data_contacts;
                });

            Additional_sans
                .getAdditionalSansBySslCertificateAssigned(ssl_cert_assigned_id)
                .then(function() {
                    $scope.additional_sans = Additional_sans.data_additional_sans;
                });
                

            $scope.single_date_options = {
                singleDatePicker: true,
                locale: {
                        format: "DD/MM/YYYY",
                        daysOfWeek: ["Dom", "Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb"]
                }
            }

            if($scope.ssl_cert_assigned.issue_date == '') $scope.ssl_cert_assigned.issue_date = moment();
            if($scope.ssl_cert_assigned.expiration_date == '') $scope.ssl_cert_assigned.expiration_date = moment().add(1, 'year');
            if($scope.ssl_cert_assigned.installation_date == '') $scope.ssl_cert_assigned.installation_date = moment();


            $scope.ssl_cert_assigned.addtional_sans = [];


            $scope.addSan = function(prev_common_name) {
                $scope.ssl_cert_assigned.addtional_sans.push(prev_common_name);
                $scope.prev_common_name = '';

            }

            $scope.deleteSan = function(prev_common_id) {
                $scope.ssl_cert_assigned.addtional_sans.splice(prev_common_id, 1);
            }
        });

    $scope.deleteContactSslCertAssigned = function(contact_ssl_cert_assigned_id) {
        Contacts_ssl_certs_assigned
            .deleteContactsSslCertificatesAssigned(contact_ssl_cert_assigned_id, ssl_cert_assigned_id)
            .then(function() {
                Contacts_ssl_certs_assigned
                    .getContactsSslCertificatesAssigned(ssl_cert_assigned_id)
                    .then(function() {
                        $scope.contacts_ssl_certs_assigned = Contacts_ssl_certs_assigned.data_contacts_ssl_certificates_assigned;
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

      $scope.addCommentSslCertificatesAssigned = function(comment) { 
        Comments_ssl_certs_assigned
          .addCommentsSslCertificatesAssigned(comment, ssl_cert_assigned_id)
          .then(function() { //Si el comentario se agregó
            

          if(Comments_ssl_certs_assigned.err == false) {

            Comments_ssl_certs_assigned
              .getCommentsSslCertificatesAssigned(ssl_cert_assigned_id)
              .then(function() {
                  $scope.comments_ssl_certs_assigned = Comments_ssl_certs_assigned.data_comments_ssl_certificates_assigned;
              });
            $scope.alertsCommentSslCertsAssigned = [];
          } else {
            $scope.alertsCommentSslCertsAssigned = [{
                          status: Comments_ssl_certs_assigned.status,
                          message: Comments_ssl_certs_assigned.message
                      }];
            
          }   
          $scope.comment = {};
          })
        
      }
	  
	
		
    $scope.sendEmail = function(skip = 1) {
        $scope.isDisabledSslCertAssigned = false;
        $scope.alertsSslCertsAssigned = [];
        Ssl_certs_assigned
            .sendToForm($scope.contacts, ssl_cert_assigned_id, skip)
            .then(function() {
                
                if(Ssl_certs_assigned.err == false) {
                    $scope.activeAlert(Ssl_certs_assigned.status, Ssl_certs_assigned.message);
                    
                    $uibModalInstance.close('closed');
                    if($scope.dtInstanceSslCertsAssigned) $scope.reloadDataSslCertsAssigned();
                } else {
                        
                    $scope.alertsSslCertsAssigned = [{
                        status: Ssl_certs_assigned.status,
                        message: Ssl_certs_assigned.message
                    }];
                }
                $scope.isDisabledSslCertAssigned = true;
            });
    }

    $scope.toValidate = function(ssl_cert_assigned) {

        Ssl_certs_assigned
            .sendToValidate(ssl_cert_assigned)
            .then(function() {
                
                if(Ssl_certs_assigned.err == false) {
                    $scope.activeAlert(Ssl_certs_assigned.status, Ssl_certs_assigned.message);
                    
                    $uibModalInstance.close('closed');
                    if($scope.dtInstanceSslCertsAssigned) $scope.reloadDataSslCertsAssigned();
                } else {
                        
                    $scope.alertsSslCertsAssigned = [{
                        status: Ssl_certs_assigned.status,
                        message: Ssl_certs_assigned.message
                    }];
                }
                $scope.isDisabledSslCertAssigned = true;
            });
    }

    $scope.toIssue = function(ssl_cert_assigned) {
        $scope.isDisabledSslCertAssigned = false;
        $scope.alertsSslCertsAssigned = [];

        Ssl_certs_assigned
            .sendToIssue(ssl_cert_assigned)
            .then(function() {
                if(Ssl_certs_assigned.err == false) {
                    $scope.activeAlert(Ssl_certs_assigned.status, Ssl_certs_assigned.message);
                    
                    $uibModalInstance.close('closed');
                    if($scope.dtInstanceSslCertsAssigned) $scope.reloadDataSslCertsAssigned();
                } else {
                        
                    $scope.alertsSslCertsAssigned = [{
                        status: Ssl_certs_assigned.status,
                        message: Ssl_certs_assigned.message
                    }];
                }
                $scope.isDisabledSslCertAssigned = true;
            });
    }

    $scope.toInstall = function(ssl_cert_assigned) {
        $scope.isDisabledSslCertAssigned = false;
        $scope.alertsSslCertsAssigned = [];

        Ssl_certs_assigned
        .sendToInstall(ssl_cert_assigned)
        .then(function() {
            if(Ssl_certs_assigned.err == false) {
                $scope.activeAlert(Ssl_certs_assigned.status, Ssl_certs_assigned.message);
                
                $uibModalInstance.close('closed');
                if($scope.dtInstanceSslCertsAssigned) $scope.reloadDataSslCertsAssigned();
            } else {
                    
                $scope.alertsSslCertsAssigned = [{
                    status: Ssl_certs_assigned.status,
                    message: Ssl_certs_assigned.message
                }];
            }
            $scope.isDisabledSslCertAssigned = true;
        });
    }

    $scope.toInstalled = function(ssl_cert_assigned) {
        $scope.isDisabledSslCertAssigned = false;
        $scope.alertsSslCertsAssigned = [];

        Ssl_certs_assigned
            .sendToInstalled(ssl_cert_assigned)
            .then(function() {
                if(Ssl_certs_assigned.err == false) {
                    $scope.activeAlert(Ssl_certs_assigned.status, Ssl_certs_assigned.message);
                    
                    $uibModalInstance.close('closed');
                    if($scope.dtInstanceSslCertsAssigned) $scope.reloadDataSslCertsAssigned();
                } else {
                        
                    $scope.alertsSslCertsAssigned = [{
                        status: Ssl_certs_assigned.status,
                        message: Ssl_certs_assigned.message
                    }];
                }
                $scope.isDisabledSslCertAssigned = true;
            });
    }

    $scope.assignContacts = function() {
        $uibModal
			.open({
				animation: true,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: `${base_url}admin/ssl-certificates-assigned/modal_assign_contacts_view`,
                controller: 'modalAssignContactsSslCertCtrl',
                scope: $scope,
                size: 'lg',
                resolve: {
                    data: {
                        id: ssl_cert_assigned_id
                    } 
                }
			})
			.result.then(function () {
                Contacts_ssl_certs_assigned
                    .getContactsSslCertificatesAssigned(ssl_cert_assigned_id)
                    .then(function() {
                        $scope.contacts_ssl_certs_assigned = Contacts_ssl_certs_assigned.data_contacts_ssl_certificates_assigned;
                    });
            }, function () {});
    }

    $scope.closeAlert = function(index) {
		$scope.alertsSslCertsAssigned.splice(index, 1);
	};
      
      $scope.closeAlertComment = function(index) {
		$scope.alertsCommentSslCertsAssigned.splice(index, 1);
	};

    $scope.closeModal = function() {
		$uibModalInstance.dismiss('cancel');
	};
}]);

app.controller('modalAssignContactsSslCertCtrl', [
    '$scope', '$uibModalInstance', 'data', 'Contact_types', 'Contacts_ssl_certs_assigned', 'Ssl_certs_assigned',
    function($scope, $uibModalInstance, data, Contact_types, Contacts_ssl_certs_assigned, Ssl_certs_assigned) {
    
    let ssl_cert_assigned_id = data.id;

    $scope.isDisabledContactsSslCert = true;

    $scope.contact_to_ssl = {}

    Contact_types
        .getContactTypes()
        .then(function() {
            $scope.contact_types = Contact_types.data_contact_types;
        });

    $scope.addContactsToSslCertificateAssigned = function(contact_to_ssl) {
        $scope.isDisabledContactsSslCert = false;
        $scope.alertsContactsSslCert = [];
        $scope.alertsSslCertsAssigned = [];

        Contacts_ssl_certs_assigned
        .addContactsSslCertificatesAssigned($scope.contacts, contact_to_ssl, ssl_cert_assigned_id)
        .then(function() {
            $scope.isDisabledContactsSslCert = true;

            if(Contacts_ssl_certs_assigned.err == false) { 
                $scope.alertsSslCertsAssigned = [{
                    status: Contacts_ssl_certs_assigned.status,
                    message: Contacts_ssl_certs_assigned.message
                }];
                $uibModalInstance.close('closed');

            } else {
                    
                $scope.alertsContactsSslCert = [{
                    status: Contacts_ssl_certs_assigned.status,
                    message: Contacts_ssl_certs_assigned.message
                }];
            }
            $scope.isDisabledContactsSslCert = true;
        });
    }

    $scope.closeModalAssignContacts = function() {
		$uibModalInstance.dismiss('cancel');
	};

}]);