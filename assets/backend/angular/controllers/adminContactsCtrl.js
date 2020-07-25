var app = angular.module('pmediaApp.adminContactsCtrl', []);

app.controller('adminContactsCtrl', [
		'$scope', '$uibModal', '$compile', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 'Contacts',
		function($scope, $uibModal, $compile, $filter, DTOptionsBuilder, DTColumnBuilder, Contacts) {

    $scope.setActive("adminContacts");

    Contacts
        .getPrivileges()
        .then(function() {
            $scope.privileges = Contacts.data_privileges;
        });

    $scope.getContact = function(id) {
        $uibModal
        .open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: `${base_url}admin/contacts/modal_view`,
            controller: 'modalContactCtrl',
            size: 'lg',
            resolve: {
                data: {
                    contact_id: id
                }
            }
        })
        .result.then(function () {}, function () {});
    }

    $scope.dtColumnsContacts = [
        DTColumnBuilder.newColumn('first_name').withTitle('Nombre'),
        DTColumnBuilder.newColumn('last_name').withTitle('Apellido'),
        DTColumnBuilder.newColumn('customer_name').withTitle('Empresa'),
        DTColumnBuilder.newColumn('job_title').withTitle('Cargo'),
        DTColumnBuilder.newColumn('email').withTitle('E-mail'),
        DTColumnBuilder.newColumn('phone').withTitle('Teléfono'),
        DTColumnBuilder.newColumn('mobile_phone').withTitle('Celular'),
        DTColumnBuilder.newColumn(null).withTitle('Fecha Creación').withOption('type', 'date')
            .renderWith(function(data, type, full, meta) {
                return $filter('date')(data.created_at, 'dd/MM/yyyy', 'UTC');
            }),
        DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
            .renderWith(function(data, type, full, meta) { 
                let privilege = {
                    read: ($scope.privileges.read == 1) ? `<button ng-click="getContact(${data.id})" class="btn btn-xs btn-info" tooltip-placement="top" uib-tooltip="Ver"><i class="fa fa-eye"></i></button>` : '',
                    update: ($scope.privileges.update == 1) ? `<a href="#!/contacts/${data.id}/edit/" class="btn btn-xs btn-warning" tooltip-placement="top" uib-tooltip="Editar"><i class="fa fa-pencil"></i></a>`:'',
                    delete: ($scope.privileges.delete == 1) ? `<button ng-click="deleteContact(${data.id})" class="btn btn-xs btn-danger" tooltip-placement="top" uib-tooltip="Eliminar"><i class="fa fa-close"></i></button>`:''
                }
                return `${privilege.read} ${privilege.update} ${privilege.delete}`;
            })
    ];


    $scope.dtOptionsContacts = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            url: `${base_url}admin/contacts/`,
            type: 'GET'
        })
        .withOption('createdRow', function(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        })
        .withOption('order', [[7, 'desc']])
        .withOption('processing', true)
        .withOption('responsive', true)
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

    $scope.dtInstanceContacts = {};
    $scope.reloadDataContacts = function() {
        $scope.dtInstanceContacts.reloadData(function (json) {
        }, false);
    }
        
    $scope.deleteContact = function(contact_id) {
        swal({
            title: "¿Estás seguro que desea eliminar el dato?",
            text: "Una vez eliminado ya no se podrá recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancelar", "Eliminar"]
        })
        .then((willDelete) => {
            if (willDelete) {
                $scope.alerts = [];
                                            
                Contacts
                    .deleteContact(contact_id)
                    .then(function() {
                        $scope.activeAlert(Contacts.status, Contacts.message);

                        if(Contacts.err == false) $scope.reloadDataContacts();
                    });
                
            }
        });
    }

}]);

app.controller('modalContactCtrl', function($scope, $uibModalInstance, data, Contacts) {
    let contact_id = data.contact_id;

    Contacts
        .getContact(contact_id)
        .then(function() {
			$scope.contact = Contacts.data_contact;
		});

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};
});