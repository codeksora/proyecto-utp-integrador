const base_url = $('#base_url').val();
const language_dt = base_url + 'assets/backend/angular/lib/dataTables-spanish.json';

var app = angular.module('pmediaApp', [
	'ngTagsInput',
	'angularTrix',
    'ngRoute',
    'jcs-autoValidate',
    'ngFileUpload',
    'checklist-model',
    'ngTable',
    'ui.select',
    'daterangepicker',
    'datatables',
    'datatables.bootstrap',
    'ui.bootstrap',
    'ngAnimate',
    'ngSanitize',
    'ngStorage',
    'oi.select',
    'pmediaApp.login',
    'pmediaApp.adminDashboardCtrl',
    'pmediaApp.adminConfigurationsCtrl', 'pmediaApp.configurations',
    'pmediaApp.adminUserCtrl', 'pmediaApp.adminUsersCtrl', 'pmediaApp.users',
    'pmediaApp.images',
    'pmediaApp.adminRoleCtrl', 'pmediaApp.adminRolesCtrl', 'pmediaApp.roles',
    'pmediaApp.adminPrivilegeCtrl', 'pmediaApp.adminPrivilegesCtrl', 'pmediaApp.privileges',
    'pmediaApp.menus',
    'pmediaApp.profile',
    'pmediaApp.adminProfileCtrl',
    'pmediaApp.adminCustomerCtrl', 'pmediaApp.adminCustomersCtrl', 'pmediaApp.customers',
    'pmediaApp.adminProductCtrl', 'pmediaApp.adminProductsCtrl', 'pmediaApp.products',
    'pmediaApp.adminProductTypeCtrl', 'pmediaApp.adminProductTypesCtrl', 'pmediaApp.product_types',
    'pmediaApp.adminProviderCtrl', 'pmediaApp.adminProvidersCtrl', 'pmediaApp.providers',
    'pmediaApp.adminOrderCtrl', 'pmediaApp.adminOrdersCtrl', 'pmediaApp.orders',
    'pmediaApp.order_types',
    'pmediaApp.order_product_details',
    'pmediaApp.order_products',
    'pmediaApp.order_ssl_certs_assign',
    'pmediaApp.order_firm_certs_assign',
    'pmediaApp.ssl_certs',
    'pmediaApp.currency_types',
    'pmediaApp.product_details',
    'pmediaApp.product_san_details',
    'pmediaApp.order_details',
    'pmediaApp.order_obs',
    'pmediaApp.adminSslCertsCtrl',
    'pmediaApp.adminInvoicesCtrl', 'pmediaApp.adminInvoiceCtrl', 'pmediaApp.invoices',
    'pmediaApp.adminOrdersIntranetCtrl', 'pmediaApp.adminOrderIntranetCtrl', 'pmediaApp.orders_intranet',
    'pmediaApp.adminContactsCtrl', 'pmediaApp.adminContactCtrl', 'pmediaApp.contacts',
    'pmediaApp.phone_codes',
    'pmediaApp.countries',
    'pmediaApp.contact_types',
    'pmediaApp.sunat',
    'pmediaApp.document_types',
    'pmediaApp.sectors',
    'pmediaApp.adminQueriesCtrl',
	'pmediaApp.adminDomainsCtrl', 'pmediaApp.domains',
	'pmediaApp.adminSslCertsAssignedCtrl', 'pmediaApp.ssl_certs_assigned',
	'pmediaApp.adminSignaturesAssignedCtrl', 'pmediaApp.signatures_assigned',
	'pmediaApp.customer_contacts',
	'pmediaApp.additional_sans',
	'pmediaApp.ssl_cert_status',
	'pmediaApp.operating_system_types',
	'pmediaApp.server_types',
	'pmediaApp.contacts_ssl_certs_assigned',
	'pmediaApp.contacts_signatures_assigned',
  'pmediaApp.comments_ssl_certs_assigned',
	'pmediaApp.quantity_years',
	'pmediaApp.adminSslCertsValidateCtrl', 'pmediaApp.adminSslCertValidateCtrl', 'pmediaApp.ssl_certs_validate',
	'pmediaApp.adminSignaturesValidateCtrl', 'pmediaApp.adminSignatureValidateCtrl', 'pmediaApp.signatures_validate',
	'pmediaApp.signature_forms',
	'pmediaApp.adminQuotationsCtrl', 'pmediaApp.adminQuotationCtrl', 'pmediaApp.quotations',
	'pmediaApp.adminQuotationsApproveCtrl', 'pmediaApp.quotations_approve',
	'pmediaApp.concepts',
	'pmediaApp.quotation_product_details',
	'pmediaApp.quotation_products',
	'pmediaApp.adminNotificationsCtrl', 'pmediaApp.notifications',
	'pmediaApp.quotation_templates',
	'pmediaApp.adminProductCategoriesCtrl', 'pmediaApp.adminProductCategoryCtrl', 'pmediaApp.product_categories',
	'pmediaApp.credit_times'
]);

app.run([
    '$rootScope', 'defaultErrorMessageResolver', 'bootstrap3ElementModifier',
    function ($rootScope, defaultErrorMessageResolver, bootstrap3ElementModifier) {
        // To change the root resource file path
        defaultErrorMessageResolver.setI18nFileRootPath(base_url + 'assets/backend/angular/lib');
				defaultErrorMessageResolver.setCulture('es-co');
				
				$rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
					$rootScope.title = current.$$route.title;
			});
    }
]);

app.controller('mainCtrl', ['$scope', 'Configurations', 'Login', 'Notifications',
	function($scope, Configurations, Login, Notifications) {

	// if($localStorage.user_data == undefined) {
	// 	$window.location.href = base_url;
	// } else {
	// 	$scope.full_name = $localStorage.user_data.full_name;
	// 	$scope.role_id = $localStorage.user_data.role;
	// }

	// if($localStorage.user_data.logged_in == false) {
	// 	$scope.logged_in = $localStorage.user_data.logged_in;
	// 	$window.location.href = base_url + 'admin/';
	// }

	$scope.config = {};

	Configurations.load().then(function() {
		$scope.config = Configurations.config;
	})

	$scope.logout = function() {

		Login.logout().then(function() {
			window.location = base_url;
	  	});
	}

	Notifications.getNotificationsFromNow().then(function() {
		$scope.notifications = Notifications.data_notifications;
	});

	var pusher = new Pusher('5e9b6b6e06917225ff96', {
		cluster: 'us2',
		forceTLS: true
	});

	var channel = pusher.subscribe('ch-notif');
	channel.bind('ev-notif', function(data) {
		Notifications.getNotificationsFromNow().then(function() {
			$scope.notifications = Notifications.data_notifications;
		});
	});

	$scope.alerts = [];

	$scope.activeAlert = function(status, message) {
		$scope.alerts.push({
			status: status,
			message: message
		});
	}

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	};


	$scope.setActive = function(Opcion){

		$scope.adminDashboard = "";

		$scope.adminUsers = "";
		$scope.adminUserAdd = "";

		$scope.adminRoles = "";
		$scope.adminRoleAdd = "";

		$scope.adminPrivileges = "";
		$scope.adminPrivilegeAdd = "";

		$scope.adminCustomers = "";
		$scope.adminCustomerAdd = "";

		$scope.adminProducts = "";
		$scope.adminProductAdd = "";

		$scope.adminOrders = "";
		$scope.adminOrderAdd = "";

		$scope.adminSslCerts = "";
		$scope.adminSslCertAdd = "";

		$scope.adminContacts = "";
		$scope.adminContactAdd = "";

		$scope.adminProviders = "";
		$scope.adminProviderAdd = "";

		$scope.adminQuotations = "";
		$scope.adminQuotationAdd = "";

		$scope.adminDomains = "";

		$scope.adminSslCerts = "";
		$scope.adminSslCertsAssigned = "";
		$scope.adminSslCertsValidate = "";

		$scope.adminProfile = "";

		$scope[Opcion] = "active";

	}

}]);

app.directive('stringToNumber', function() {
	return {
	  require: 'ngModel',
	  link: function(scope, element, attrs, ngModel) {
		ngModel.$parsers.push(function(value) {
		  return '' + value;
		});
		ngModel.$formatters.push(function(value) {
		  return parseFloat(value);
		});
	  }
	};
  });

app.config(['$routeProvider',
	function($routeProvider){

	$routeProvider
		.when('/', {title: 'DASHBOARD', templateUrl: base_url + 'admin/dashboard/main_view', controller: 'adminDashboardCtrl'})
		.when('/users', {title: 'USUARIOS', templateUrl: base_url + 'admin/users/main_view', controller: 'adminUsersCtrl'})
		.when('/users/add/', {title: 'USUARIOS - AÑADIR USUARIO', templateUrl: base_url + 'admin/users/add_view', controller: 'adminUserCtrl'})
		.when('/users/:id/edit/', {title: 'USUARIOS - EDITAR USUARIO', templateUrl: base_url + 'admin/users/edit_view', controller: 'adminUserCtrl'})
		.when('/roles/', {title: 'ROLES', templateUrl: base_url + 'admin/roles/main_view', controller: 'adminRolesCtrl'})
		.when('/roles/add/', {title: 'ROLES - AÑADIR ROL', templateUrl: base_url + 'admin/roles/add_view', controller: 'adminRoleCtrl'})
		.when('/roles/:id/edit/', {title: 'ROLES - EDITAR ROL', templateUrl: base_url + 'admin/roles/edit_view', controller: 'adminRoleCtrl'})
		// .when('/privileges/', {title: 'PROVEEDORES', templateUrl: base_url + 'admin/privileges/main_view', controller: 'adminPrivilegesCtrl'})
		// .when('/privileges/add/', {templateUrl: base_url + 'admin/privileges/add_view', controller: 'adminPrivilegeCtrl'})
		// .when('/privileges/:id/edit/', {templateUrl: base_url + 'admin/privileges/edit_view', controller: 'adminPrivilegeCtrl'})
		.when('/profile/', {title: 'PERFÍL', templateUrl: base_url + 'admin/profile', controller: 'adminProfileCtrl'})
		.when('/customers/', {title: 'CLIENTES', templateUrl: base_url + 'admin/customers/main_view', controller: 'adminCustomersCtrl'})
		.when('/customers/add/', {title: 'CLIENTES - AÑADIR CLIENTE', templateUrl: base_url + 'admin/customers/add_view', controller: 'adminCustomerCtrl'})
		.when('/customers/:id/edit/', {title: 'CLIENTES - EDITAR CLIENTE', templateUrl: base_url + 'admin/customers/edit_view', controller: 'adminCustomerCtrl'})

		.when('/providers/', {title: 'PROVEEDORES', templateUrl: base_url + 'admin/providers/main_view', controller: 'adminProvidersCtrl'})
		.when('/providers/add/', {title: 'PROVEEDORES - AÑADIR PROVEEDOR', templateUrl: base_url + 'admin/providers/add_view', controller: 'adminProviderCtrl'})
		.when('/providers/:id/edit/', {title: 'PROVEEDORES - EDITAR PROVEEDOR', templateUrl: base_url + 'admin/providers/edit_view', controller: 'adminProviderCtrl'})

		.when('/products/', {title: 'PRODUCTOS', templateUrl: base_url + 'admin/products/main_view', controller: 'adminProductsCtrl'})
		.when('/products/add/', {title: 'PRODUCTOS - AÑADIR PRODUCTO', templateUrl: base_url + 'admin/products/add_view', controller: 'adminProductCtrl'})
		.when('/products/:id/edit/', {title: 'PRODUCTOS - EDITAR PRODUCTO', templateUrl: base_url + 'admin/products/edit_view', controller: 'adminProductCtrl'})

		.when('/invoices/', {title: 'FACTURAS', templateUrl: base_url + 'admin/invoices/main_view', controller: 'adminInvoicesCtrl'})
		.when('/invoices/add/', {title: 'FACTURAS', templateUrl: base_url + 'admin/invoices/add_view', controller: 'adminInvoiceCtrl'})
		// .when('/invoices/:id/edit/', {templateUrl: base_url + 'admin/products/edit_view', controller: 'adminProductCtrl'})

		.when('/orders/', {title: 'ORDENES', templateUrl: base_url + 'admin/orders/main_view', controller: 'adminOrdersCtrl'})
		.when('/orders/:id/edit/', {title: 'ORDENES - EDITAR ORDEN', templateUrl: base_url + 'admin/orders/edit_view', controller: 'adminOrderCtrl'})
		.when('/orders/:id/assign/', {title: 'ORDENES - ASIGNAR A LA ORDEN', templateUrl: base_url + 'admin/orders/assign_view', controller: 'adminOrderCtrl'})
		.when('/orders/:id/invoice/', {title: 'ORDENES - EMITIR FACTURA', templateUrl: base_url + 'admin/orders/invoice_view', controller: 'adminOrderCtrl'})
		.when('/orders/:id/bill/', {title: 'ORDENES - EMITIR BOLETA', templateUrl: base_url + 'admin/orders/bill_view', controller: 'adminOrderCtrl'})


		.when('/ssl-certificates/', {title: 'CERTIFICADOS SSL', templateUrl: base_url + 'admin/ssl-certificates/main_view', controller: 'adminSslCertsCtrl'})
		.when('/ssl-certificates/add/', {title: 'CERTIFICADOS SSL - AÑADIR CERTIFICADO', templateUrl: base_url + 'admin/ssl-certificates/add_view', controller: 'adminSslCertCtrl'})
		
		.when('/ssl-certificates-assigned/', {title: 'CERTIFICADOS SSL ASIGNADOS', templateUrl: base_url + 'admin/ssl-certificates-assigned/main_view', controller: 'adminSslCertsAssignedCtrl'})
		
		.when('/signatures-assigned/', {title: 'FIRMAS ASIGNADAS', templateUrl: base_url + 'admin/signatures-assigned/main_view', controller: 'adminSignaturesAssignedCtrl'})

		.when('/ssl-certificates-validate/', {title: 'CERTIFICADOS PARA VALIDAR', templateUrl: base_url + 'admin/ssl-certificates-validate/main_view', controller: 'adminSslCertsValidateCtrl'})
		.when('/ssl-certificates-validate/:id/edit/', {title: 'CERTIFICADOS PARA VALIDAR - EDITAR CERTIFICADO', templateUrl: base_url + 'admin/ssl-certificates-validate/edit_view', controller: 'adminSslCertValidateCtrl'})

		.when('/signatures-validate/', {title: 'FIRMAS PARA VALIDAR', templateUrl: base_url + 'admin/signatures-validate/main_view', controller: 'adminSignaturesValidateCtrl'})
		.when('/signatures-validate/:id/edit/', {title: 'FIRMAS PARA VALIDAR - EDITAR FIRMA', templateUrl: base_url + 'admin/signatures-validate/edit_view', controller: 'adminSignatureValidateCtrl'})

		.when('/orders-intranet/', {templateUrl: base_url + 'admin/orders-intranet/main_view', controller: 'adminOrdersIntranetCtrl'})
		.when('/orders-intranet/:id/invoice/', {templateUrl: base_url + 'admin/orders-intranet/invoice_view', controller: 'adminOrderIntranetCtrl'})
        .when('/orders-intranet/:id/bill/', {templateUrl: base_url + 'admin/orders-intranet/bill_view', controller: 'adminOrderIntranetCtrl'})
        
		.when('/contacts/', {title: 'CONTACTOS', templateUrl: base_url + 'admin/contacts/main_view', controller: 'adminContactsCtrl'})
		.when('/contacts/add/', {title: 'CONTACTOS - AÑADIR CONTACTO', templateUrl: base_url + 'admin/contacts/add_view', controller: 'adminContactCtrl'})
		.when('/contacts/:id/edit/', {title: 'CONTACTOS - EDITAR CONTACTO', templateUrl: base_url + 'admin/contacts/edit_view', controller: 'adminContactCtrl'})

		.when('/queries/', {title: 'CONSULTAS', templateUrl: `${base_url}admin/queries/main_view`, controller: 'adminQueriesCtrl'})
		.when('/domains/', {title: 'DOMINIOS', templateUrl: `${base_url}admin/domains/main_view`, controller: 'adminDomainsCtrl'})

		.when('/configurations', {title: 'CONFIGURACIÓN', templateUrl: base_url + 'admin/configurations/main_view', controller: 'adminConfigurationsCtrl'})

		.when('/quotations/', {title: 'COTIZACIONES', templateUrl: base_url + 'admin/quotations/main_view', controller: 'adminQuotationsCtrl'})
		.when('/quotations/add/', {title: 'COTIZACIONES - AÑADIR COTIZACIÓN', templateUrl: base_url + 'admin/quotations/add_view', controller: 'adminQuotationCtrl'})
		.when('/quotations/:id/validate/', {title: 'COTIZACIONES - VALIDAR COTIZACIÓN', templateUrl: base_url + 'admin/quotations/validate_view', controller: 'adminQuotationCtrl'})

		.when('/quotations-approve/', {title: 'COTIZACIONES - APROVAR COTIZACIONES', templateUrl: base_url + 'admin/quotations-approve/main_view', controller: 'adminQuotationsApproveCtrl'})

		.when('/notifications/', {title: 'NOTIFICACIONES', templateUrl: base_url + 'admin/notifications/main_view', controller: 'adminNotificationsCtrl'})

		.when('/product-categories/', {title: 'CATEGORÍAS', templateUrl: base_url + 'admin/product-categories/main_view', controller: 'adminProductCategoriesCtrl'})
		.when('/product-categories/add/', {title: 'CATEGORÍAS - AÑADIR CATEGORÍA', templateUrl: base_url + 'admin/product-categories/add_view', controller: 'adminProductCategoryCtrl'})
		.when('/product-categories/:id/edit/', {title: 'CATEGORÍAS - EDITAR CATEGORÍA', templateUrl: base_url + 'admin/product-categories/edit_view', controller: 'adminProductCategoryCtrl'})

		.otherwise({redirectTo: '/'});


}]);
