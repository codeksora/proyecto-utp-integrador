var app = angular.module('pmediaApp.adminSslCertsValidateCtrl', []);

app.controller('adminSslCertsValidateCtrl', [
    '$scope', '$compile', '$uibModal', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 'Ssl_certs_validate',
    function($scope, $compile, $uibModal, $filter, DTOptionsBuilder, DTColumnBuilder, Ssl_certs_validate){

    $scope.setActive("adminSslCertsValidate");

    Ssl_certs_validate
		.getPrivileges()
		.then(function() {
			$scope.privileges = Ssl_certs_validate.data_privileges;
        });

    $scope.dtOptionsSslCertsValidate = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
            url: `${base_url}admin/ssl-certificates-validate/`,
            type: 'GET'
        })
        .withOption('createdRow', function(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        })
        .withOption('order', [[4, 'desc']])
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
        
        $scope.dtColumnsSslCertsValidate = [
            DTColumnBuilder.newColumn('Organizacion_CSR').withTitle('Cliente'),
            DTColumnBuilder.newColumn('producto').withTitle('Producto'),
            DTColumnBuilder.newColumn('CommonName_CSR').withTitle('Common name'),
            DTColumnBuilder.newColumn('accion').withTitle('Estado'),
            DTColumnBuilder.newColumn(null).withTitle('Fecha de registro').withOption('order', 'asc').withOption('type', 'date')
                .renderWith(function(data, type, full, meta) {
                    return $filter('date')(data.fech_regform, 'dd/MM/yyyy', 'UTC');
                }),
            DTColumnBuilder.newColumn(null).withTitle('Acción').notSortable().withClass('td-small text-center')
                .renderWith(function(data, type, full, meta) {

                    let privilege = {
                        update: ($scope.privileges.update == 1) ? `<a href="#!/ssl-certificates-validate/${data.id_formulario}/edit/" class="btn btn-xs btn-danger">VALIDAR <i class="fa fa-paper-plane"></i></a>`:''
                    }
                    return `<div class="btn-group">${privilege.update}</div>`;
                })
        ];

        $scope.dtInstanceSslCertsValidate = {};
        $scope.reloadDataSslCertsValidate = function() {
            $scope.dtInstanceSslCertsValidate.reloadData(function () {
            }, false);
        }

}]);