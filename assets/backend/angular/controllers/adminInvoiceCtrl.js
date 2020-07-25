var app = angular.module('pmediaApp.adminInvoiceCtrl', []);

app.controller('adminInvoiceCtrl', [
    '$scope', '$routeParams', '$uibModal', 'DTOptionsBuilder', 'DTColumnDefBuilder', 'Customers', 'Invoices',
    function($scope, $routeParams, $uibModal, DTOptionsBuilder, DTColumnDefBuilder, Customers, Invoices){
        $scope.setActive("adminInvoice");

        var id = $routeParams.id;
        $scope.client = {};
        $scope.disable = false;
        $scope.products = [];

        $scope.invoice = Invoices;
        $scope.invoice.IGV = $scope.config.IGV;
        // $scope.invoice.tax = 

        $scope.now = new Date();

        $scope.dtOptionsInvoices = DTOptionsBuilder
            .newOptions()
            .withBootstrap()
            .withLanguageSource(language_dt);

        $scope.dtInstanceInvoices = {};
        $scope.reloadDataInvoices = function() {
            $scope.dtInstanceInvoices.reloadData(function () {
            }, false);
        }

        $scope.dtColumnDefsInvoices = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2),
            DTColumnDefBuilder.newColumnDef(3),
            DTColumnDefBuilder.newColumnDef(4),
            DTColumnDefBuilder.newColumnDef(5),
            DTColumnDefBuilder.newColumnDef(6),
            DTColumnDefBuilder.newColumnDef(7).notSortable()
        ];

        $scope.invoice.expiration_date = {
            date: {
                startDate: null
            },
            options: {
                singleDatePicker: true,
                locale: {
                        format: "DD/MM/YYYY",
                        daysOfWeek: ["Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb", "Dom"]
                }
            }
        }

        $scope.addProductModal = function() {
            $uibModal
                .open({
                    animation: true,
                    scope: $scope,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: base_url + 'admin/invoices/modal_add_product_view',
                    controller: 'modalInvoiceAddProductCtrl',
                    size: 'md'
                })
                .result.then(function() {}, function() {});
        }

        $scope.deleteProduct = function(index) {
            Invoices.deleteProduct(index);
        }

        $scope.isDisabledSearch = true;

        $scope.searchOnSunat = function(document_number) {
            $scope.isDisabledSearch = false;
            Invoices
                .getDetailByDocNum(document_number)
                .then(function() {
                    $scope.customer = Invoices.data_customer;
                    $scope.isDisabledSearch = true;
                });
        }

        $scope.add = function(customer) {
            $scope.disable = true;

            Customers.addCustomer(customer).then(function() {
                $scope.disable = false;
                if(Customers.err == false) {
                    window.location = "#!/customers/";
                    swal(Customers.msg, {
                        icon: "success",
                    });
                } else {
                    swal(Customers.msg, {
                        icon: "error",
                    });
                }
            });
        }

        $scope.save = function(customer) {
            $scope.disable = true;

            Customers.saveCustomer(customer).then(function() {
                $scope.disable = false;
                swal("Se ha actualizado correctamente", {
                    icon: "success",
                });

                window.location = "#!/customer/";
            });
        }

        if(id) {
            $scope.setActive("adminCustomers");

            Customers.getCustomer(id).then(function() {

                $scope.customer = Customers.data_customer;
            });

        }
        else {
            $scope.setActive("adminInvoiceAdd");
        };
}]);

app.controller('modalInvoiceAddProductCtrl', function($scope, $uibModalInstance, Invoices) {

    $scope.igv = 0.18;

    $scope.addProduct = function(product) {
        Invoices.addProduct(product);

        $uibModalInstance.close('closed');
    };

    $scope.closeModal = function () {
        $uibModalInstance.dismiss('cancel');
    };
});