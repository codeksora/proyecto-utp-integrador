<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller']   = 'Login_PMController';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| VISTAS
| -------------------------------------------------------------------------
*/
$route['auth']   = 'Login_PMController/auth';
$route['logout'] = 'Login_PMController/logout';
$route['remember_me'] = 'Login_PMController/remember_me';

$route['admin']                = 'Admin_PMController';
$route['admin/configurations/main_view'] = 'Admin_configurations_PMController';
$route['admin/configurations'] = 'Admin_configurations_PMController/configurations';

/*
| ------------------------
| SUNAT
| ------------------------
*/

$route['admin/sunat/search'] = 'Admin_sunat_PMController/search';
$route['admin/sunat/search/(:any)'] = 'Admin_sunat_PMController/search/$1';
$route['admin/sunat/search-edit/(:any)'] = 'Admin_sunat_PMController/search_edit/$1';

/*
| ------------------------
| DASHBOARD
| ------------------------
*/
$route['admin/dashboard/main_view'] = 'Admin_dashboard_PMController';

/*
| ------------------------
| USUARIOS
| ------------------------
*/
$route['admin/users/main_view']  = 'Admin_users_PMController';
$route['admin/users/add_view']   = 'Admin_users_PMController/add_view';
$route['admin/users/edit_view']  = 'Admin_users_PMController/edit_view';
$route['admin/users/modal_view'] = 'Admin_users_PMController/modal_view';
$route['admin/users']            = 'Admin_users_PMController/users';
$route['admin/users/privileges'] = 'Admin_users_PMController/privileges';
$route['admin/users/(:any)']     = 'Admin_users_PMController/users/$1';
$route['admin/logout']           = 'Admin_users_PMController/logout';

/*
| ------------------------
| ROLES
| ------------------------
*/
$route['admin/roles/main_view']  = 'Admin_roles_PMController';
$route['admin/roles/add_view']   = 'Admin_roles_PMController/add_view';
$route['admin/roles/edit_view']  = 'Admin_roles_PMController/edit_view';
$route['admin/roles/modal_view'] = 'Admin_roles_PMController/modal_view';
$route['admin/roles']            = 'Admin_roles_PMController/roles';
$route['admin/roles/(:any)']     = 'Admin_roles_PMController/roles/$1';
$route['admin/roles/(:num)/privileges']     = 'Admin_privileges_PMController/role_privileges/$1';

/*
| ------------------------
| PRIVILEGIOS
| ------------------------
*/
$route['admin/privileges/main_view']  = 'Admin_privileges_PMController';
$route['admin/privileges/add_view']   = 'Admin_privileges_PMController/add_view';
$route['admin/privileges/edit_view']  = 'Admin_privileges_PMController/edit_view';
$route['admin/privileges/modal_view'] = 'Admin_privileges_PMController/modal_view';
$route['admin/privileges']            = 'Admin_privileges_PMController/privileges';
$route['admin/privileges/(:any)']     = 'Admin_privileges_PMController/privileges/$1';

/*
| ------------------------
| IMÁGENES
| ------------------------
*/
$route['admin/images']           = 'Admin_images_PMController';
$route['admin/images/add_view']  = 'Admin_images_PMController/add_view';
$route['admin/images/edit_view'] = 'Admin_images_PMController/edit_view';
$route['admin/images/image/(:num)']  = 'Admin_images_PMController/image/$1';
$route['admin/images/images/(:num)'] = 'Admin_images_PMController/images/$1';
$route['admin/images/add']           = 'Admin_images_PMController/add';
$route['admin/images/update']        = 'Admin_images_PMController/update';
$route['admin/images/delete']        = 'Admin_images_PMController/delete';
$route['admin/images/all_images']    = 'Admin_images_PMController/all_images';

/*
| ------------------------
| MENUS
| ------------------------
*/
$route['admin/menus'] = 'Admin_menus_PMController/menus';

/*
| ------------------------
| PERFÍL
| ------------------------
*/
$route['admin/profile'] = 'Admin_profile_PMController';
$route['admin/profile/user']        = 'Admin_profile_PMController/user';
$route['admin/profile/user/(:num)']        = 'Admin_profile_PMController/user/$1';
$route['admin/profile/update']      = 'Admin_profile_PMController/update';
$route['admin/profile/update_pass'] = 'Admin_profile_PMController/update_pass';

/*
| ------------------------
| CLIENTES
| ------------------------
*/
$route['admin/customers']           = 'Admin_customers_PMController/customers';
$route['admin/customers/privileges']     = 'Admin_customers_PMController/privileges';
$route['admin/customers/main_view']        = 'Admin_customers_PMController';
$route['admin/customers/add_view']         = 'Admin_customers_PMController/add_view';
$route['admin/customers/edit_view']        = 'Admin_customers_PMController/edit_view';
$route['admin/customers/modal_view'] = 'Admin_customers_PMController/modal_view';
$route['admin/customers/quantity']         = 'Admin_customers_PMController/quantity_customers';
$route['admin/customers/ruc/(:any)']    = 'Admin_customers_PMController/customers_by_ruc/$1';
$route['admin/customers/(:any)']    = 'Admin_customers_PMController/customers/$1';
$route['admin/customers/(:num)/contacts']    = 'Admin_contacts_PMController/customer_contacts/$1';
$route['admin/customers/(:num)/ssl-certificates'] = 'Admin_ssl_certs_PMController/ssl_certs_by_customer/$1';

/*
| ------------------------
| PRODUCTOS
| ------------------------
*/
$route['admin/products/main_view']      = 'Admin_products_PMController';
$route['admin/products/add_view']       = 'Admin_products_PMController/add_view';
$route['admin/products/edit_view']      = 'Admin_products_PMController/edit_view';
$route['admin/products/modal_view']     = 'Admin_products_PMController/modal_view';
$route['admin/products']                = 'Admin_products_PMController/products';
$route['admin/products/privileges']     = 'Admin_products_PMController/privileges';
$route['admin/products/(:any)']         = 'Admin_products_PMController/products/$1';
$route['admin/products/(:any)/details'] = 'Admin_product_details_PMController/product_details_by_product/$1';
$route['admin/products/(:any)/san-details'] = 'Admin_product_san_details_PMController/product_san_details_by_product/$1';
$route['admin/products/(:any)/information-document'] = 'Admin_products_PMController/information_document/$1';

/*
| ------------------------
| PRODUCTOS
| ------------------------
*/
$route['admin/product-details/currency-type/(:num)'] = 'Admin_product_details_PMController/product_details_by_currency_type/$1';
$route['admin/product-details/(:num)/currency-type/(:num)'] = 'Admin_product_details_PMController/product_details/$1/$2';
$route['admin/product-details/(:num)'] = 'Admin_product_details_PMController/product_details/$1';


/*
| ------------------------
| ORDENES
| ------------------------
*/
$route['admin/orders/main_view']                         = 'Admin_orders_PMController';
$route['admin/orders/add_view']                          = 'Admin_orders_PMController/add_view';
$route['admin/orders/edit_view']                         = 'Admin_orders_PMController/edit_view';
$route['admin/orders/modal_view']                        = 'Admin_orders_PMController/modal_view';
$route['admin/orders/modal_assign_view']                 = 'Admin_orders_PMController/modal_assign_view';
$route['admin/orders/modal_assign_product_view']         = 'Admin_orders_PMController/modal_assign_product_view';
$route['admin/orders/assign_view']                       = 'Admin_orders_PMController/assign_view';
$route['admin/orders/invoice_view'] = 'Admin_orders_PMController/invoice_view';
$route['admin/orders/bill_view'] = 'Admin_orders_PMController/bill_view';
$route['admin/orders']                                   = 'Admin_orders_PMController/orders';
$route['admin/orders/privileges']     = 'Admin_orders_PMController/privileges';
$route['admin/orders/filter']                            = 'Admin_orders_PMController/orders_filter';
$route['admin/orders/product-type/(:num)']               = 'Admin_order_product_details_PMController/order_product_type/$1';
$route['admin/orders/(:any)/observations']               = 'Admin_order_obs_PMController/order_obs/$1';
$route['admin/orders/(:any)/product-details'] 			= 'Admin_order_product_details_PMController/order_product_details_by_order/$1';
$route['admin/orders/(:num)/ssl-certificates-assigned']  = 'Admin_ssl_certs_assigned_PMController/order_ssl_certs_assigned/$1';
$route['admin/orders/(:num)/signatures-assigned']        = 'Admin_signatures_assigned_PMController/order_signatures_assigned/$1';
$route['admin/orders/(:num)/product-details/separate'] = 'Admin_quotation_product_details_PMController/order_product_details_separate/$1';
// $route['admin/orders/(:any)/ssl-certificates']           = 'Admin_ssl_certs_PMController/ssl_certs/$1';
// $route['admin/orders/(:any)/details']                    = 'Admin_order_details_PMController/order_details/$1';
$route['admin/orders/(:num)/products']                    = 'Admin_order_products_PMController/order_product_by_order_dt/$1';
// $route['admin/orders/firm-certificates']                 = 'Admin_firm_certs_PMController/firm_certs';
$route['admin/orders/(:any)']                            = 'Admin_orders_PMController/orders/$1';

/*
| ------------------------
| DETALLES DEL PRODUCTO DE LA COTIZACIÓN
| ------------------------
*/
$route['admin/quotation-product-details/(:num)'] = 'Admin_quotation_product_details_PMController/quotation_product_details/$1';

/*
| ------------------------
| CERTIFICADOS SSL
| ------------------------
*/
$route['admin/ssl-certificates/main_view'] = 'Admin_ssl_certs_PMController';
$route['admin/ssl-certificates/add_view'] = 'Admin_ssl_certs_PMController/add_view';
$route['admin/ssl-certificates/modal_add_view'] = 'Admin_ssl_certs_PMController/modal_add_view';
$route['admin/ssl-certificates/modal_assign_domain_to_customer_view'] = 'Admin_ssl_certs_PMController/modal_assign_domain_to_customer_view';
$route['admin/ssl-certificates'] = 'Admin_ssl_certs_PMController/ssl_certs';
$route['admin/ssl-certificates/privileges']     = 'Admin_ssl_certs_PMController/privileges';

/*
| ------------------------
| CERTIFICADOS SSL ASIGNADOS
| ------------------------
*/
$route['admin/ssl-certificates-assigned'] = 'Admin_ssl_certs_assigned_PMController/ssl_certs_assigned';
$route['admin/ssl-certificates-assigned/pending']  = 'Admin_ssl_certs_assigned_PMController/ssl_certs_assigned_pending';
$route['admin/ssl-certificates-assigned/main_view'] = 'Admin_ssl_certs_assigned_PMController';
$route['admin/ssl-certificates-assigned/modal_view'] = 'Admin_ssl_certs_assigned_PMController/modal_view';
$route['admin/ssl-certificates-assigned/privileges']     = 'Admin_ssl_certs_assigned_PMController/privileges';
$route['admin/ssl-certificates-assigned/modal_assign_contacts_view'] = 'Admin_ssl_certs_assigned_PMController/modal_assign_contacts_view';
$route['admin/ssl-certificates-assigned/(:num)'] = 'Admin_ssl_certs_assigned_PMController/ssl_certs_assigned/$1';
$route['admin/ssl-certificates-assigned/(:num)/contacts'] = 'Admin_contacts_ssl_certs_assigned_PMController/contacts_ssl_certs_assigned/$1';
$route['admin/ssl-certificates-assigned/(:num)/comments'] = 'Admin_comments_ssl_certs_assigned_PMController/comments_ssl_certs_assigned/$1';
$route['admin/ssl-certificates-assigned/(:num)/send-to-form'] = 'Admin_ssl_certs_assigned_PMController/send_to_form/$1';
$route['admin/ssl-certificates-assigned/(:num)/send-to-issue'] = 'Admin_ssl_certs_assigned_PMController/send_to_issue/$1';
$route['admin/ssl-certificates-assigned/(:num)/send-to-install'] = 'Admin_ssl_certs_assigned_PMController/send_to_install/$1';
$route['admin/ssl-certificates-assigned/(:num)/send-to-validate'] = 'Admin_ssl_certs_assigned_PMController/send_to_validate/$1';
$route['admin/ssl-certificates-assigned/(:num)/send-to-installed'] = 'Admin_ssl_certs_assigned_PMController/send_to_installed/$1';
$route['admin/ssl-certificates-assigned/(:num)/contacts/(:num)'] = 'Admin_contacts_ssl_certs_assigned_PMController/contacts_ssl_certs_assigned/$1/$2';

/*
| ------------------------
| ESTADOS DEL CERTIFICADOS SSL
| ------------------------
*/

$route['admin/ssl-cert-status'] = 'Admin_ssl_cert_status_PMController/ssl_cert_status';

/*
| ------------------------
| CERTIFICADOS SSL POR VALIDAR
| ------------------------
*/
$route['admin/ssl-certificates-validate/main_view'] = 'Admin_ssl_certs_validate_PMController';
$route['admin/ssl-certificates-validate/edit_view'] = 'Admin_ssl_certs_validate_PMController/edit_view';
$route['admin/ssl-certificates-validate'] = 'Admin_ssl_certs_validate_PMController/ssl_certs_validate';
$route['admin/ssl-certificates-validate/privileges']     = 'Admin_ssl_certs_validate_PMController/privileges';
$route['admin/ssl-certificates-validate/(:num)'] = 'Admin_ssl_certs_validate_PMController/ssl_certs_validate/$1';

/*
| ------------------------
| FIRMAS ASIGNADAS
| ------------------------
*/
$route['admin/signatures-assigned/main_view'] = 'Admin_signatures_assigned_PMController';
$route['admin/signatures-assigned/modal_view'] = 'Admin_signatures_assigned_PMController/modal_view';
$route['admin/signatures-assigned/modal_assign_contacts_view'] = 'Admin_signatures_assigned_PMController/modal_assign_contacts_view';
$route['admin/signatures-assigned'] = 'Admin_signatures_assigned_PMController/signatures_assigned';
$route['admin/signatures-assigned/privileges']     = 'Admin_signatures_assigned_PMController/privileges';
$route['admin/signatures-assigned/(:num)/send-to-install'] = 'Admin_signatures_assigned_PMController/send_to_install/$1';
$route['admin/signatures-assigned/(:num)/contacts'] = 'Admin_contacts_signatures_assigned_PMController/contacts_signatures_assigned/$1';
$route['admin/signatures-assigned/(:num)/contacts/(:num)'] = 'Admin_contacts_signatures_assigned_PMController/contacts_signatures_assigned/$1/$2';
$route['admin/signatures-assigned/(:num)'] = 'Admin_signatures_assigned_PMController/signatures_assigned/$1';

/*
| ------------------------
| FIRMAS POR VALIDAR
| ------------------------
*/
$route['admin/signatures-validate/main_view'] = 'Admin_signatures_validate_PMController';
$route['admin/signatures-validate/edit_view'] = 'Admin_signatures_validate_PMController/edit_view';
$route['admin/signatures-validate'] = 'Admin_signatures_validate_PMController/signatures_validate';
$route['admin/signatures-validate/privileges'] = 'Admin_signatures_validate_PMController/privileges';
$route['admin/signatures-validate/(:num)'] = 'Admin_signatures_validate_PMController/signatures_validate/$1';

/*
| ------------------------
| FIRMAS DEL FORMULARIO
| ------------------------
*/
$route['admin/signature-forms'] = 'Admin_signature_forms_PMController/signature_forms';

/*
| ------------------------
| FACTURAS
| ------------------------
*/
$route['admin/invoices/main_view']              = 'Admin_invoices_PMController';
$route['admin/invoices/add_view']               = 'Admin_invoices_PMController/add_view';
$route['admin/invoices/modal_add_product_view'] = 'Admin_invoices_PMController/modal_add_product_view';
$route['admin/invoices']                        = 'Admin_invoices_PMController/invoices';
$route['admin/invoices/info-sunat']             = 'Admin_invoices_PMController/info_sunat';

/*
| ------------------------
| ORDENES DEL INTRANET
| ------------------------
*/
$route['admin/orders-intranet/main_view'] = 'Admin_orders_intranet_PMController';
$route['admin/orders-intranet/invoice_view'] = 'Admin_orders_intranet_PMController/invoice_view';
$route['admin/orders-intranet/bill_view'] = 'Admin_orders_intranet_PMController/bill_view';
$route['admin/orders-intranet/debit_note_view'] = 'Admin_orders_intranet_PMController/invoice_view';
$route['admin/orders-intranet/credit_note_view'] = 'Admin_orders_intranet_PMController/bill_view';
$route['admin/orders-intranet'] = 'Admin_orders_intranet_PMController/orders_intranet';
$route['admin/orders-intranet/(:any)'] = 'Admin_orders_intranet_PMController/orders_intranet/$1';
$route['admin/orders-intranet/(:any)/products'] = 'Admin_orders_intranet_PMController/order_products_intranet/$1';

/*
| ------------------------
| TIPOS DE PRODUCTO
| ------------------------
*/
$route['admin/product-types'] = 'Admin_product_types_PMController/product_types';
$route['admin/product-types/(:num)/products'] = 'Admin_products_PMController/products_by_product_type/$1';

/*
| ------------------------
| PROVEEDORES
| ------------------------
*/
$route['admin/providers/main_view']      = 'Admin_providers_PMController';
$route['admin/providers/add_view']       = 'Admin_providers_PMController/add_view';
$route['admin/providers/edit_view']      = 'Admin_providers_PMController/edit_view';
$route['admin/providers/modal_view'] = 'Admin_providers_PMController/modal_view';
$route['admin/providers'] = 'Admin_providers_PMController/providers';
$route['admin/providers/dt'] = 'Admin_providers_PMController/providers_dt';
$route['admin/providers/privileges']     = 'Admin_providers_PMController/privileges';
$route['admin/providers/(:num)'] = 'Admin_providers_PMController/providers/$1';

/*
| ------------------------
| TIPOS ORDEN
| ------------------------
*/
$route['admin/order-types'] = 'Admin_order_types_PMController/order_types';

/*
| ------------------------
| TIPOS MONEDA
| ------------------------
*/
$route['admin/currency-types'] = 'Admin_currency_types_PMController/currency_types';

/*
| ------------------------
| CONTACTOS
| ------------------------
*/
$route['admin/contacts/main_view']      = 'Admin_contacts_PMController';
$route['admin/contacts/add_view']       = 'Admin_contacts_PMController/add_view';
$route['admin/contacts/edit_view']      = 'Admin_contacts_PMController/edit_view';
$route['admin/contacts/modal_view'] = 'Admin_contacts_PMController/modal_view';
$route['admin/contacts'] = 'Admin_contacts_PMController/contacts';
$route['admin/contacts/privileges']     = 'Admin_contacts_PMController/privileges';
$route['admin/contacts/(:num)']    = 'Admin_contacts_PMController/contacts/$1';

/*
| ------------------------
| CÓDIGOS DE TELÉFONO
| ------------------------
*/
$route['admin/phone-codes'] = 'Admin_phone_codes_PMController/phone_codes';

/*
| ------------------------
| CONCEPTOS
| ------------------------
*/
$route['admin/concepts'] = 'Admin_concepts_PMController/concepts';

/*
| ------------------------
| CONCEPTOS
| ------------------------
*/
$route['admin/credit-times'] = 'Admin_credit_times_PMController/credit_times';

/*
| ------------------------
| PAÍSES
| ------------------------
*/
$route['admin/countries'] = 'Admin_countries_PMController/countries';

/*
| ------------------------
| TIPOS DE CONTACTO
| ------------------------
*/
$route['admin/contact-types'] = 'Admin_contact_types_PMController/contact_types';

/*
| ------------------------
| TIPOS DE DOCUMENTO
| ------------------------
*/
$route['admin/document-types'] = 'Admin_document_types_PMController/document_types';

/*
| ------------------------
| SECTORES
| ------------------------
*/
$route['admin/sectors'] = 'Admin_sectors_PMController/sectors';

/*
| ------------------------
| CONSULTAS
| ------------------------
*/
$route['admin/queries/main_view'] = 'Admin_queries_PMController';

/*
| ------------------------
| DOMINIOS
| ------------------------
*/
$route['admin/domains/main_view'] = 'Admin_domains_PMController';
$route['admin/domains/modal_add_view'] = 'Admin_domains_PMController/modal_add_view';
$route['admin/domains/modal_assign_customer_view'] = 'Admin_domains_PMController/modal_assign_customer_view';
$route['admin/domains'] = 'Admin_domains_PMController/domains';
$route['admin/domains/(:num)/customers'] = 'Admin_domains_PMController/domains_customers/$1';
$route['admin/domains/privileges'] = 'Admin_domains_PMController/privileges';

/*
| ------------------------
| SAN ADICIONALES
| ------------------------
*/
$route['admin/ssl-certificates-assigned/(:num)/additional-sans'] = 'Admin_additional_sans_PMController/additional_sans/$1';

/*
| ------------------------
| TIPOS DE SISTEMA OPERATIVO
| ------------------------
*/
$route['admin/operating-system-types'] = 'Admin_operating_system_types_PMController/operating_system_types';

/*
| ------------------------
| TIPOS DE SERVIDOR
| ------------------------
*/
$route['admin/server-types'] = 'Admin_server_types_PMController/server_types';

/*
| ------------------------
| TIPOS DE SERVIDOR
| ------------------------
*/
$route['admin/quantity-years'] = 'Admin_quantity_years_PMController/quantity_years';

/*
| ------------------------
| COTIZACIONES
| ------------------------
*/
$route['admin/quotations/main_view']  = 'Admin_quotations_PMController';
$route['admin/quotations/add_view']   = 'Admin_quotations_PMController/add_view';
$route['admin/quotations/validate_view']  = 'Admin_quotations_PMController/validate_view';
$route['admin/quotations/modal_view'] = 'Admin_quotations_PMController/modal_view';
$route['admin/quotations/modal_add_product_view'] = 'Admin_quotations_PMController/modal_add_product_view';
$route['admin/quotations/dt'] = 'Admin_quotations_PMController/quotations_dt';
$route['admin/quotations/privileges'] = 'Admin_quotations_PMController/privileges';
$route['admin/quotations/demo-pdf'] = 'Admin_quotations_PMController/quotations_demo_pdf';
$route['admin/quotations'] = 'Admin_quotations_PMController/quotations/';
$route['admin/quotations/(:num)'] = 'Admin_quotations_PMController/quotations/$1';
$route['admin/quotations/(:num)/products']  = 'Admin_quotation_products_PMController/quotation_product_by_quotation/$1';
$route['admin/quotations/(:num)/ssl-certificates-assigned']  = 'Admin_ssl_certs_assigned_PMController/quotation_ssl_certs_assigned/$1';
$route['admin/quotations/(:num)/signatures-assigned']        = 'Admin_signatures_assigned_PMController/quotation_signatures_assigned/$1';
$route['admin/quotations/(:num)/product-details'] = 'Admin_quotation_product_details_PMController/quotation_product_details_by_order/$1';
$route['admin/quotations/(:num)/product-details/separate'] = 'Admin_quotation_product_details_PMController/quotation_product_details_separate/$1';
$route['admin/quotations/(:num)/document'] = 'Admin_quotations_PMController/quotations_document/$1';
// $route['admin/quotations/(:any)']     = 'Admin_quotations_PMController/quotations/$1';

/*
| ------------------------
| COTIZACIONES APROBADAS
| ------------------------
*/
$route['admin/quotations-approve/main_view']  = 'Admin_quotations_approve_PMController';
$route['admin/quotations-approve/dt'] = 'Admin_quotations_approve_PMController/quotations_approve_dt';
$route['admin/quotations-approve/privileges'] = 'Admin_quotations_approve_PMController/privileges';
$route['admin/quotations-approve/all'] = 'Admin_quotations_approve_PMController/quotations_approve_all/';
$route['admin/quotations-approve/(:num)'] = 'Admin_quotations_approve_PMController/quotations_approve/$1';

/*
| ------------------------
| NOTIFICACIONES
| ------------------------
*/
$route['admin/notifications/main_view']  = 'Admin_notifications_PMController';
$route['admin/notifications']  = 'Admin_notifications_PMController/notifications';
$route['admin/notifications/dt']  = 'Admin_notifications_PMController/notifications_dt';
$route['admin/notifications/now']  = 'Admin_notifications_PMController/notifications_now';

/*
| ------------------------
| DEMOS
| ------------------------
*/

// $route['admin/demo/pdf'] = 'Admin_dashboard_PMController/pdf';
// $route['admin/demo/pdf-html'] = 'Admin_dashboard_PMController/pdf_html';

/*
| ------------------------
| PLANTILLAS DE COTIZACIÓN
| ------------------------
*/
$route['admin/quotation-templates']  = 'Admin_quotation_templates_PMController/quotation_templates';

/*
| ------------------------
| CATEGORÍAS DEL PRODUCTO
| ------------------------
*/

$route['admin/product-categories/main_view']      = 'Admin_product_categories_PMController';
$route['admin/product-categories/add_view']       = 'Admin_product_categories_PMController/add_view';
$route['admin/product-categories/edit_view']      = 'Admin_product_categories_PMController/edit_view';
$route['admin/product-categories/modal_view'] = 'Admin_product_categories_PMController/modal_view';
$route['admin/product-categories'] = 'Admin_product_categories_PMController/product_categories';
$route['admin/product-categories/dt'] = 'Admin_product_categories_PMController/product_categories_dt';
$route['admin/product-categories/privileges']     = 'Admin_product_categories_PMController/privileges';
$route['admin/product-categories/(:num)']    = 'Admin_product_categories_PMController/product_categories/$1';

/*
| ------------------------
| API V1
| ------------------------
*/
$route['api/orders']    = 'Api/orders';












