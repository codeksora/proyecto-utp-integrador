var app = angular.module('pmediaApp.adminSignaturesValidateCtrl', []);

app.controller('adminSignaturesValidateCtrl', [
    '$scope', '$compile', '$uibModal', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 'Signatures_validate',
    function($scope, $compile, $uibModal, $filter, DTOptionsBuilder, DTColumnBuilder, Signatures_validate){

    $scope.setActive("adminSignaturesValidate");

    Signatures_validate
		.getPrivileges()
		.then(function() {
			$scope.privileges = Signatures_validate.data_privileges;
        });

    $scope.dtOptionsSignaturesValidate = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            url: `${base_url}admin/signatures-validate/`,
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
        
        $scope.dtColumnsSignaturesValidate = [
            DTColumnBuilder.newColumn(null).withTitle('Envío').withOption('type', 'date')
            .renderWith(function(data, type, full, meta) {
                return $filter('date')(data.persfecharegistro, 'dd/MM/yyyy', 'UTC');
            }),
            DTColumnBuilder.newColumn('persempresauser').withTitle('Empresa'),
            DTColumnBuilder.newColumn('full_name').withTitle('Usuario'),
            DTColumnBuilder.newColumn('persmailuser').withTitle('Correo'),
            DTColumnBuilder.newColumn('persdescproducto').withTitle('Producto'),
            DTColumnBuilder.newColumn('accion').withTitle('Tiempo'),
            DTColumnBuilder.newColumn('persestadouser').withTitle('Estado'),
            DTColumnBuilder.newColumn(null).withTitle('Validar').notSortable().withClass('td-small text-center')
                .renderWith(function(data, type, full, meta) {

                    let privilege = {
                        update: ($scope.privileges.update == 1) ? `<a href="#!/signatures-validate/${data.idpersonal}/edit/" class="btn btn-xs btn-danger">VALIDAR <i class="fa fa-paper-plane"></i></a>`:''
                    }
                    return `<div class="btn-group">${privilege.update}</div>`;
                })
        ];

        $scope.dtInstanceSignaturesValidate = {};
        $scope.reloadDataSignaturesValidate = function() {
            $scope.dtInstanceSignaturesValidate.reloadData(function () {
            }, false);
        }

}]);