var app = angular.module('pmediaApp.adminOrderCtrl', []);

app.controller('adminOrderCtrl', [
	'$scope', '$routeParams', '$uibModal', '$compile', '$filter', 'DTOptionsBuilder', 'DTColumnBuilder', 'DTColumnDefBuilder',
	'Orders', 'Customers', 'Order_types', 'Currency_types', 'Product_types', 'Products', 'Quotation_product_details', 'Order_ssl_certs_assign',
	'Order_firm_certs_assign', 'Quotation_products',
	function($scope, $routeParams, $uibModal, $compile, $filter, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder,
			 Orders, Customers, Order_types, Currency_types, Product_types, Products, Quotation_product_details, Order_ssl_certs_assign,
			 Order_firm_certs_assign, Quotation_products){

	const order_id = $routeParams.id;

	$scope.order = Orders;
	$scope.order.IGV = $scope.config.igv;

	$scope.isDisabled = true;
	$scope.customers = [];
	// $scope.order.orderDate = {
	// 	date: {
	// 		startDate: null,
	// 		endDate: null
	// 	},
	// 	options: {
	// 		pickerClasses: 'custom-display', //angular-daterangepicker extra
	// 		buttonClasses: 'btn',
	// 		applyButtonClasses: 'btn-primary',
	// 		cancelButtonClasses: 'btn-danger',
	// 		locale: {
	// 			applyLabel: "Aplicar",
	// 			cancelLabel: 'Cancelar',
	// 			separator: ' - ',
	// 			format: "DD/MM/YYYY",
	// 						daysOfWeek: ["Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb", "Dom"],
	// 						monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo","Junio","Julio",
	// 												"Agosto","Septiembre","Octubre","Noviembre","Diciembre"]
	// 		}
	// 	}
	// }

	// $scope.order.singleDate = {
	// 	date: {
	// 		startDate: null
	// 	},
	// 	options: {
	// 		singleDatePicker: true,
	// 		locale: {
	// 				format: "DD/MM/YYYY",
	// 				daysOfWeek: ["Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb", "Dom"]
	// 		}
	// 	}
	// }

	$scope.order.expiration_date = moment();
	$scope.order.reception_date = moment();
	$scope.order.order_date = moment();

	$scope.single_date_options = {
		singleDatePicker: true,
		locale: {
				format: "DD/MM/YYYY",
				daysOfWeek: ["Dom", "Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb"]
		}
	}

	$scope.deleteProduct = function(index) {
		Orders.deleteProduct(index);
	}

	$scope.order.products = [];

	$scope.dtOptionsOrders = DTOptionsBuilder
		.newOptions()
		.withBootstrap()
		.withBootstrapOptions({
            pagination: {
                classes: {
                    ul: 'pagination pagination-sm'
                }
            }
        })
		.withLanguageSource(language_dt);

	$scope.dtInstanceOrders = {};
	$scope.reloadDataOrders = function() {
		$scope.dtInstanceOrders.reloadData(function () {
		}, false);
	}

	$scope.dtColumnDefsOrders = [
		DTColumnDefBuilder.newColumnDef(0),
		DTColumnDefBuilder.newColumnDef(1),
		DTColumnDefBuilder.newColumnDef(2),
		DTColumnDefBuilder.newColumnDef(3),
		DTColumnDefBuilder.newColumnDef(4),
		DTColumnDefBuilder.newColumnDef(5),
		DTColumnDefBuilder.newColumnDef(6),
		DTColumnDefBuilder.newColumnDef(7).notSortable()
	];

	$scope.addProductModal = function() {
		$uibModal
			.open({
				animation: true,
				scope: $scope,
				backdrop: 'static',
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: base_url + 'admin/orders/modal_add_product_view',
				controller: 'modalOrdersAddProductCtrl',
				size: 'md',
				resolve: {
					data: {
						order: $scope.order
					}
				}
			})
			.result.then(function() {}, function() {});
	}


	$scope.add = function(order) {
		$scope.isDisabled = false;
		$scope.alerts = [];

		Orders
			.addOrder(order)
			.then(function() {
				$scope.isDisabled = true;

				$scope.activeAlert(Orders.status, Orders.message);

				if(Orders.err == false) window.location = "#!/orders/";
			});
	}

	$scope.dtOptions = DTOptionsBuilder.newOptions()
		.withBootstrap()
		.withLanguageSource(language_dt);

	Customers
		.getCustomers()
		.then(function() {
			$scope.customers = Customers.data_customers;
		});

	Order_types
		.getOrderTypes()
		.then(function() {
			$scope.order_types = Order_types.data_order_types;
		});

	Currency_types
		.getCurrencyTypes(

		).then(function() {
			$scope.currency_types = Currency_types.data_currency_types;
		});

	Product_types
		.getProductTypes()
		.then(function() {
			$scope.product_types = Product_types.data_product_types;
		});

	// $scope.dtInstanceSslCertsAssign.changeData(Order_ssl_certs_assign.data_order_ssl_certs);

	// $scope.reloadData2 = reloadData2;

	if(order_id) {
		$scope.setActive("adminOrders");

		Orders.getOrder(order_id).then(function() {
			$scope.order = Orders.data_order;
			if(Orders.err == true) window.location = "#!/orders/";
			Quotation_products.getQuotationProductsByQuotation($scope.order.quotation_id).then(function() {
				$scope.products = Quotation_products.data_products;
			});
		});
		Quotation_product_details.getProductDetailsByOrderSeparate(order_id).then(function() {
			$scope.order_product_details_separate = Quotation_product_details.data_order_product_details_separate;
		});

		$scope.invoice = {};

		$scope.invoice.issue_date = {
			date: {
				startDate: null,

			},
			minDate: moment().subtract(2, 'days'),
			maxDate: moment().add(2, 'days'),
			options: {
				singleDatePicker: true,
				locale: {
					format: "DD/MM/YYYY",
					daysOfWeek: ["Dom", "Lun" ,"Mar", "Mie", "Jue" ,"Vie", "Sáb"]
				}
			}
		}

		// DATATABLE PARA PRODUCTOS DE LA ORDEN
		$scope.dtOptionsOrderProducts = DTOptionsBuilder
			.fromFnPromise(function() {
		        return Quotation_product_details.getProductDetailsByOrderSeparate(order_id);
		    })
			.withOption('createdRow', function(row, data, dataIndex) {
				$compile(angular.element(row).contents())($scope);
			})
			.withBootstrap()
			.withBootstrapOptions({
				pagination: {
					classes: {
						ul: 'pagination pagination-sm'
					}
				}
			})
			.withLanguageSource(language_dt);

		$scope.dtColumnsOrderProducts = [
			DTColumnBuilder.newColumn('id').withTitle('ID'),
			DTColumnBuilder.newColumn('product_type_name').withTitle('Tipo de producto'),
			DTColumnBuilder.newColumn('product_name').withTitle('Producto'),
			DTColumnBuilder.newColumn(null).withTitle('Acción').withClass('text-center')
				.renderWith(function(data, type, full, meta) { 
					let html = '';
					switch(data.status_id) {
						case 1:
							$html = `<button type="button" class="btn btn-danger btn-xs" ng-click="assignProduct(${data.id})"><i class="fa fa-paper-plane"></i></button>`
							break;
						case 2:
							$html = `<span class="text-danger"><i class="fa fa-ban"></i></span>`;
							break;
					}
					return $html;
				})
		];

		$scope.dtInstanceOrderProducts = {};
		$scope.reloadDataOrderProducts = function() {
			$scope.dtInstanceOrderProducts.reloadData(function () {
			}, false);
		}

		$scope.assignProduct = function(quotation_product_detail_id) {
			$uibModal
				.open({
					animation: true,
					scope: $scope,
					backdrop: 'static',
					ariaLabelledBy: 'modal-title',
					ariaDescribedBy: 'modal-body',
					templateUrl: base_url + 'admin/orders/modal_assign_product_view',
					controller: 'modalOrderProductAssignCtrl',
					size: 'lg',
					resolve: {
						data: {
							quotation_product_detail_id
						}
					}
				})
				.result.then(function () {
					$scope.reloadDataSslCertsAssigned();
				}, function () { });
		}

		/* CERTIFICADOS DIGITALES */
		$scope.dtOptionsSslCertsAssigned = DTOptionsBuilder.newOptions()
			.withOption('ajax', {
				url: `${base_url}admin/orders/${order_id}/ssl-certificates-assigned`,
				type: 'GET'
			})
			.withOption('createdRow', function(row, data, dataIndex) {
				$compile(angular.element(row).contents())($scope);
			})
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

		$scope.dtColumnsSslCertsAssigned = [
			DTColumnBuilder.newColumn('product_name').withTitle('Producto'),
			DTColumnBuilder.newColumn('common_name').withTitle('Common name'),
			DTColumnBuilder.newColumn(null).withTitle('Fecha de asignación').withOption('type', 'date')
				.renderWith(function(data, type, full, meta) {
					return $filter('date')(data.created_at, 'dd/MM/yyyy', 'UTC');
				}),
			DTColumnBuilder.newColumn(null).withTitle('Estado').withClass('text-center')
				.renderWith(function(data, type, full, meta) {
					return `<span class="label bg-${data.ssl_certificate_status_class}">${data.ssl_certificate_status_name}</span>`;
				})
		];

		$scope.dtInstanceSslCertsAssigned = {};
		$scope.reloadDataSslCertsAssigned = function() {
			$scope.dtInstanceSslCertsAssigned.reloadData(function () {
			}, false);
		}

		/* CERTIFICADOS DIGITALES */
		$scope.dtOptionsSignaturesAssigned = DTOptionsBuilder.newOptions()
			.withOption('ajax', {
				url: `${base_url}admin/orders/${order_id}/signatures-assigned`,
				type: 'GET'
			})
			.withOption('createdRow', function(row, data, dataIndex) {
				$compile(angular.element(row).contents())($scope);
			})
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

		$scope.dtColumnsSignaturesAssigned = [
			DTColumnBuilder.newColumn('product_name').withTitle('Producto'),
			DTColumnBuilder.newColumn('persnombreuser').withTitle('Nombre'),
			DTColumnBuilder.newColumn('persmailuser').withTitle('Correo'),
			DTColumnBuilder.newColumn(null).withTitle('Estado').withClass('text-center')
				.renderWith(function(data, type, full, meta) {
					return `<span class="label bg-${data.signature_assigned_status_class}">${data.signature_status_name}</span>`;
				})
		];

		$scope.dtInstanceSignaturesAssigned = {};
		$scope.reloadDataSignaturesAssigned = function() {
			$scope.dtInstanceSignaturesAssigned.reloadData(function () {
			}, false);
		}



		$scope.dtOptionsDetails = DTOptionsBuilder.newOptions()
			.withBootstrap()
			.withLanguageSource(language_dt);

		$scope.save = function(order) {

			$scope.isDisabled = false;
			$scope.alerts = [];
	
			Orders
				.saveOrder(order)
				.then(function() {
					$scope.isDisabled = true;

					$scope.activeAlert(Orders.status, Orders.message);

					if(Orders.err == false) window.location = "#!/orders/";
				});
		}
	}
	else {
		$scope.setActive("adminOrderAdd");
	};

}]);


app.controller('modalOrderProductAssignCtrl', function(
	$scope, $uibModalInstance, $compile, $filter, data, DTOptionsBuilder, DTColumnBuilder,
	Quotation_product_details, Ssl_certs, Signature_forms, Ssl_certs_assigned, Signatures_assigned) {
	let quotation_product_detail_id = data.quotation_product_detail_id;


	Quotation_product_details.getQuotationProductDetail(quotation_product_detail_id)
		.then(function() {
			quotation_product_detail = Quotation_product_details.data_quotation_product_detail;

			$scope.isDisabledSslCerts = true;
			$scope.isDisabledSignatures = true;

			$scope.product_type_id = quotation_product_detail.product_type_id;
			let customer_id = quotation_product_detail.customer_id;
			// //Datatable para SSL
			$scope.dtOptionsSslCerts = DTOptionsBuilder
				.fromFnPromise(function() {
					return Ssl_certs.getSslCertsByCustomer(customer_id);
				})
				.withOption('createdRow', function(row, data, dataIndex) {
					$compile(angular.element(row).contents())($scope);
				})
				// .withOption('order', [[3, 'desc']])
				.withBootstrap()
				.withBootstrapOptions({
		            pagination: {
		                classes: {
		                    ul: 'pagination pagination-sm'
		                }
		            }
		        })
				.withLanguageSource(language_dt);

			$scope.dtColumnsSslCerts = [
				DTColumnBuilder.newColumn(null).withTitle('').withClass('text-center').notSortable()
					.renderWith(function(data, type, full, meta) {
						return `<input type="radio" ng-model="ssl_certificate_id" ng-value="${data.id}">`;
					}),
				DTColumnBuilder.newColumn('customer_name').withTitle('Empresa'),
				DTColumnBuilder.newColumn('common_name').withTitle('Dominio'),
				DTColumnBuilder.newColumn(null).withTitle('Fecha de creación')
					.renderWith(function(data, type, full, meta) {
						return $filter('date')(data.created_at, 'dd/MM/yyyy hh:mm:ss', 'UTC');
					}),
			];
			$scope.dtInstanceSslCerts = {};
			$scope.reloadDataSslCerts = function() {
				$scope.dtInstanceSslCerts.reloadData(function () {
				}, false);
			}

			// //Datatable para Firmas
			$scope.dtOptionsSignatureForms = DTOptionsBuilder
				.fromFnPromise(function() {
					return Signature_forms.getSignatureForms();
				})
				.withOption('createdRow', function(row, data, dataIndex) {
					$compile(angular.element(row).contents())($scope);
				})
				.withOption('order', [[6, 'desc']])
				.withOption('responsive', true)
				.withBootstrap()
				.withLanguageSource(language_dt);

			$scope.dtColumnsSignatureForms = [
				DTColumnBuilder.newColumn(null).withTitle('').withClass('text-center').notSortable()
					.renderWith(function(data, type, full, meta) {
						return `<input type="radio" ng-model="idpersonal" ng-value="${data.idpersonal}">`;
					}),
				DTColumnBuilder.newColumn('persempresauser').withTitle('Empresa'),
				DTColumnBuilder.newColumn('persdescproducto').withTitle('Producto'),
				DTColumnBuilder.newColumn('perstiempoproducto').withTitle('Tiempo'),
				DTColumnBuilder.newColumn('persnombreuser').withTitle('Nombres'),
				DTColumnBuilder.newColumn('persmailuser').withTitle('Correo'),
				DTColumnBuilder.newColumn(null).withTitle('Fecha de creación').withOption('type', 'date').notVisible()
					.renderWith(function(data, type, full, meta) {
						return $filter('date')(data.persfechavalidacion, 'dd/MM/yyyy hh:mm:ss', 'UTC');
					})
				
			];
			$scope.dtInstanceSignatureForms = {};
			$scope.reloadDataSignatureForms = function() {
				$scope.dtInstanceSignatureForms.reloadData(function () {
				}, false);
			}
			
			$scope.assignSslCert = function(ssl_certificate_id) {
				$scope.isDisabledSslCerts = false;
				$scope.alertsSslCerts = [];

				quotation_product_detail.ssl_certificate_id = ssl_certificate_id;
				
				Ssl_certs_assigned.addSslCertsAssigned(quotation_product_detail).then(function() {
					
					if(Ssl_certs_assigned.err === false) {
		                $scope.activeAlert(Ssl_certs_assigned.status, Ssl_certs_assigned.message);

		                $scope.reloadDataOrderProducts();
		                $uibModalInstance.close('closed');
		            } else {
		                
		                $scope.alertsSslCerts = [{
		                    status: Ssl_certs_assigned.status,
		                    message: Ssl_certs_assigned.message
		                }];
		            }
		            $scope.isDisabledSslCerts = true;
				});
			}

			$scope.assignSignature = function(signature_id) {
				$scope.isDisabledSignatures = false;

				quotation_product_detail.idpersonal = signature_id;

				Signatures_assigned.addSignatureAssigned(quotation_product_detail).then(function() {
					
					if(Signatures_assigned.err === false) {
		                $scope.activeAlert(Signatures_assigned.status, Signatures_assigned.message);

		                $scope.reloadDataOrderProducts();
		                $scope.reloadDataSignaturesAssigned();
		                $uibModalInstance.close('closed');
		            } else {
		                
		                $scope.alertsSslCerts = [{
		                    status: Signatures_assigned.status,
		                    message: Signatures_assigned.message
		                }];
		            }
		            $scope.isDisabledSignatures = true;
				});
			}
		});



	// $scope.assignCertWidthFirm = function(cert_id) {
	// 	// var order_products_id = data.order_products_id; // id_detordprod
	// 	var order_id = data.order_id;
	// 	var product_id = data.product_id;
	// 	console.log(cert_id, order_id, product_id);
	// 	Order_firm_certs_assign.addFirmCert(order_id, cert_id, product_id).then(function() {
	// 		$uibModalInstance.dismiss('cancel');
	// 	});
	// }
	
	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};

	$scope.closeAlertSslCerts = function(index) {
		$scope.alertsSslCerts.splice(index, 1);
	};
});
