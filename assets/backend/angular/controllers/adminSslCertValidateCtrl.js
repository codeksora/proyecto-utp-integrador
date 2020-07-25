var app = angular.module('pmediaApp.adminSslCertValidateCtrl', []);

app.controller('adminSslCertValidateCtrl', [
    '$scope', '$routeParams', '$compile', '$filter', 'Ssl_certs_validate', 'DTColumnBuilder', 'DTOptionsBuilder',
    function($scope, $routeParams, $compile, $filter, Ssl_certs_validate, DTColumnBuilder, DTOptionsBuilder){

    var id = $routeParams.id;

    $scope.setActive("adminSslCertValidate");

    if(id) {

        $scope.isDisabled = true;

        Ssl_certs_validate
            .getSslCertValidate(id)
            .then(function() {
                $scope.ssl_cert = Ssl_certs_validate.data_ssl_cert_validate;
            });

        $scope.dtOptionsSslCertsAssigned = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: `${base_url}admin/ssl-certificates-assigned/pending/`,
                type: 'GET'
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                $compile(angular.element(row).contents())($scope);
            })
            .withOption('processing', true)
            // .withOption('responsive', true)
            .withOption('order', [[1, 'asc']])
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
            DTColumnBuilder.newColumn(null).withTitle('').notSortable()
                .renderWith(function(data, type, full, meta) {
                    return `<input type="radio" ng-model="ssl_cert.ssl_certificates_assigned_id" ng-value="${data.id}">`;
                }),
            DTColumnBuilder.newColumn('customer_name').withTitle('Cliente'),
            DTColumnBuilder.newColumn('order_number').withTitle('Orden'),
            DTColumnBuilder.newColumn('product_name').withTitle('Producto'),
            DTColumnBuilder.newColumn('common_name').withTitle('Common name'),
        ];

        $scope.dtInstanceSslCertsAssigned = {};
        $scope.reloadDataSslCertsAssigned = function() {
            $scope.dtInstanceSslCertsAssigned.reloadData(function () {
            }, false);
        }
    }

    $scope.save = function(ssl_cert) {
        $scope.isDisabled = false;
        Ssl_certs_validate
            .validateSslCert(ssl_cert)
            .then(function() {
                $scope.isDisabled = true;
                
                $scope.activeAlert(Ssl_certs_validate.status, Ssl_certs_validate.message);

                if(Ssl_certs_validate.err == false) window.location = "#!/ssl-certificates-validate/";
                console.log("Validado correctamente");
            });
    }
}]);