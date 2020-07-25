var app = angular.module('pmediaApp.adminNotificationsCtrl', []);

app.controller('adminNotificationsCtrl', [
    '$scope', '$compile', '$filter', '$uibModal', 'DTOptionsBuilder', 'DTColumnBuilder', 'Domains',
    function($scope, $compile, $filter, $uibModal, DTOptionsBuilder, DTColumnBuilder, Domains) {

        $scope.isDisabled = true;

        $scope.dtOptionsNotifications = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: `${base_url}admin/notifications/dt`,
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

        $scope.dtColumnsNotifications = [
            DTColumnBuilder.newColumn(null).withTitle('Fecha y Hora').withOption('type', 'date')
                .renderWith(function(data, type, full, meta) {
                    return $filter('date')(data.created_at, 'dd/MM/yyyy HH:mm:ss');
                }),
            DTColumnBuilder.newColumn('subject').withTitle('Asunto'),
            DTColumnBuilder.newColumn('description').withTitle('Descripción'),
            DTColumnBuilder.newColumn('user_full_name').withTitle('Por')
        ];

        $scope.dtInstanceNotifications = {};
        $scope.reloadDataNotifications = function() {
            $scope.dtInstanceNotifications.reloadData(function(json) {
            }, false);
        }

    }]);

