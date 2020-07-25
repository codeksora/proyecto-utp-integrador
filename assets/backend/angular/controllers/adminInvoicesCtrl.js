var app = angular.module('pmediaApp.adminInvoicesCtrl', []);

app.controller('adminInvoicesCtrl', [
    '$scope', '$compile', 'DTOptionsBuilder', 'DTColumnBuilder', 'Invoices',
    function($scope, $compile, DTOptionsBuilder, DTColumnBuilder, Invoices){

        $scope.setActive("adminInvoices");

        $scope.invoices = [];

        $scope.dtOptionsInvoices = DTOptionsBuilder.newOptions()
            .withOption('ajax', {
                url: `${base_url}admin/invoices/`,
                type: 'GET'
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                $compile(angular.element(row).contents())($scope);
            })
            .withBootstrap()
            .withOption('responsive', true)
            .withLanguageSource(language_dt);

        $scope.dtColumnsInvoices = [
            DTColumnBuilder.newColumn('id').withTitle('# Factura'),
            DTColumnBuilder.newColumn('id').withTitle('Fecha Emisión'),
            DTColumnBuilder.newColumn('id').withTitle('Fecha Vencimiento'),
            DTColumnBuilder.newColumn('id').withTitle('Cliente'),
            DTColumnBuilder.newColumn('id').withTitle('Fecha Vencimiento'),
            DTColumnBuilder.newColumn('id').withTitle('Moneda'),
            DTColumnBuilder.newColumn('id').withTitle('Total'),
            DTColumnBuilder.newColumn('id').withTitle('Estado'),
            // DTColumnBuilder.newColumn('nro').withTitle('RUC'),
            // DTColumnBuilder.newColumn('direccion').withTitle('Dirección'),
            // DTColumnBuilder.newColumn('distrito').withTitle('Distrito'),
            // DTColumnBuilder.newColumn('telefono').withTitle('Teléfono'),
            // DTColumnBuilder.newColumn(null).withTitle('Estado')
            //     .renderWith(function(data, type, full, meta) {
            //         return data.validacion == 0 ? '<i class="fa fa-ban text-danger"></i>' : '<i class="fa fa-check text-success"></i>';
            //     }),
            DTColumnBuilder.newColumn(null).withTitle('Nota de crédito').notSortable().withClass('td-small text-center')
                .renderWith(function(data, type, full, meta) {
                    return `<a href="#!/orders/${data.id}/edit/" uib-tooltip="Eliminar" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>`;
                }),
            DTColumnBuilder.newColumn(null).withTitle('Nota de débito').notSortable().withClass('td-small text-center')
                .renderWith(function(data, type, full, meta) {
                    return `<a href="#!/orders/${data.id}/edit/" uib-tooltip="Eliminar" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>`;
                })
        ];


        $scope.deleteCustomer = function(id) {
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

                        Customers.deleteCustomer(id).then(function() {
                            swal("Se ha eliminado correctamente", {
                                icon: "success",
                            });
                        });

                    }
                });
        }

    }]);