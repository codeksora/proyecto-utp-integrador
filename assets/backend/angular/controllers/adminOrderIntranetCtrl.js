var app = angular.module('pmediaApp.adminOrderIntranetCtrl', []);

app.controller('adminOrderIntranetCtrl', [
	'$scope', '$location', '$routeParams', '$uibModal', '$compile', 'DTOptionsBuilder', 'DTColumnBuilder', 'DTColumnDefBuilder',
	'Orders_intranet', 'Invoices',
	function($scope, $location, $routeParams, $uibModal, $compile, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder,
        Orders_intranet, Invoices){

    const order_id = $routeParams.id;

    $scope.order = {};
    $scope.order_products = [];
    $scope.now = new Date();
    $scope.isDisabled = true;
    $scope.invoice = Orders_intranet;
    // $scope.invoice.IGV = $scope.config.IGV;
    console.log(Orders_intranet);
	if(order_id) {
		$scope.setActive("adminOrdersIntranet");

		Orders_intranet.getOrder(order_id).then(function() {
            $scope.order = Orders_intranet.data_order;
            $scope.customer = Orders_intranet.data_customer;
            $scope.perusecurity = Orders_intranet.data_perusecurity;
        });
        
        Orders_intranet.getProductsByOrder(order_id).then(function() {
            $scope.order_products = Orders_intranet.data_order_products;
        });

        $scope.add = function(invoice) {
            $scope.isDisabled = false;

            Invoices.addInvoice(invoice).then(function() {
                $scope.activeAlert(Invoices.status, Invoices.message);
                $scope.invoice.referral_guide = '';
                $scope.invoice.observation = '';

                //$location.path('/orders-intranet');  
            });

        }

        $scope.invoice.issue_date = {
            date: {
                startDate: null
            },
            minDate: moment().subtract(2, 'days'),
		    maxDate: moment().add(2, 'days'),
            options: {
                singleDatePicker: true,
                locale: {
                        format: "DD/MM/YYYY",
                        daysOfWeek: ["Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb", "Dom"]
                }
            }
        }

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
            DTColumnDefBuilder.newColumnDef(5)
        ];

	}

}]);