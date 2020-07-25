<!DOCTYPE html>
<html ng-app="pmediaApp" ng-controller="mainCtrl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title ng-bind="title + ' | PANEL DE ADMINISTRACIÓN'"></title>
    <link rel="icon" href="<?php echo base_url('assets/frontend/images/favicon.ico'); ?>" sizes="32x32"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/ionicons/css/ionicons.min.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
    <!-- Select2 -->
    <!-- <link rel="stylesheet" href="<?php echo base_url('node_modules/select2/dist/css/select2.min.css'); ?>"> -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/ui-select/dist/select.min.css'); ?>">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <!-- Daterange Picker -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap-daterangepicker/daterangepicker.css'); ?>"/>
    <!-- DataTables Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/angular-datatables/dist/plugins/bootstrap/datatables.bootstrap.min.css'); ?>">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/animate.css/animate.min.css'); ?>">
    <!-- DataTable Responsive -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/datatables.net-responsive-dt/css/responsive.dataTables.min.css'); ?>">
    <!-- OI Select -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/oi.select/dist/select.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.9.2/trix.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('node_modules/ng-tags-input/build/ng-tags-input.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('node_modules/ng-tags-input/build/ng-tags-input.bootstrap.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('dist/css/AdminLTE.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('dist/css/skins/skin-red.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/style.css'); ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- jQuery 3 -->
    <script src="<?php echo base_url('node_modules/jquery/dist/jquery.min.js'); ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url('node_modules/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <!-- <script src="<?php echo base_url('node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script> -->
    <script src="<?php echo base_url('node_modules/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular/angular.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-i18n/angular-locale_es-pe.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-sanitize/angular-sanitize.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-datatables/dist/angular-datatables.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-route/angular-route.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-auto-validate/dist/jcs-auto-validate.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/ng-file-upload/dist/ng-file-upload.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/checklist-model/checklist-model.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-ui-router/release/angular-ui-router.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-animate/angular-animate.min.js'); ?>"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/trix/0.9.2/trix.js"></script>
    <script src="<?php echo base_url('node_modules/angular-trix/dist/angular-trix.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/ng-tags-input/build/ng-tags-input.min.js'); ?>"></script>
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>

    <!--   <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>-->
</head><!-- sidebar-collapse -->
<body class="skin-red sidebar-mini fixed">
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<div class="custom-alert">
    <div uib-alert
         dismiss-on-timeout="8000"
         ng-repeat="alert in alerts"
         class="alert animated fadeInUp"
         ng-class="'alert-' + (alert.status)"
         close="closeAlert($index)">
        <span ng-bind-html="alert.message"></span>
    </div>
</div>
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo base_url() ?>admin/#!/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>F</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>SIS</b>Facturación</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning" ng-if="notifications.length > 0">{{ notifications.length }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Notificaciones de hoy</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li ng-repeat="notif in notifications">
                                        <a href="">
                                            <i class="fa fa-{{ notif.icon }} text-{{ notif.color }}"></i> {{ notif.subject }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#!/notifications">Todos</a></li>
                        </ul>
                    </li>

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <?php $this->load->view('admin/templates/user_profile_view'); ?>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <?php $this->load->view('admin/templates/sidebar_view'); ?>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <ng-view></ng-view>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            {{ config.application }}
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; {{ config.year }} <a href="{{ config.web }}" target="_blank">{{ config.company }}</a>.</strong>
        All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- Datatables Boostrap -->
<script src="<?php echo base_url('node_modules/angular-datatables/dist/plugins/bootstrap/angular-datatables.bootstrap.min.js'); ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('node_modules/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- ChartJS -->
<script src="<?php echo base_url('node_modules/chart.js/Chart.min.js'); ?>"></script>

<!-- SweetAlert -->
<script src="<?php echo base_url('node_modules/sweetalert/dist/sweetalert.min.js'); ?>"></script>
<!-- Select2 -->
<!-- <script src="<?php echo base_url('node_modules/select2/dist/js/select2.full.min.js'); ?>"></script> -->
<!-- Slimscroll -->
<script src="<?php echo base_url('node_modules/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- Select2 - AngularJS -->
<script src="<?php echo base_url('node_modules/ui-select/dist/select.min.js'); ?>"></script>
<script src="<?php echo base_url('node_modules/moment/moment.js'); ?>"></script>
<!-- Daterange picker -->
<script src="<?php echo base_url('node_modules/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script src="<?php echo base_url('node_modules/angular-daterangepicker/js/angular-daterangepicker.min.js'); ?>"></script>
<!-- OI Select -->
<script src="<?php echo base_url('node_modules/oi.select/dist/select-tpls.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('dist/js/adminlte.min.js'); ?>"></script>

<link rel="stylesheet" href="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.css">
<script src="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.js"></script>
<script src="<?php echo base_url('node_modules/ngstorage/ngStorage.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/backend/angular/app.js'); ?> "></script>

<!-- CONTROLLERS -->
<script src="<?php echo base_url('assets/backend/angular/controllers/adminDashboardCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminConfigurationsCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminUsersCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminUserCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminRolesCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminRoleCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminPrivilegesCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminPrivilegeCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProfileCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminCustomersCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminCustomerCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProductsCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProductCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProductTypesCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProductTypeCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProvidersCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProviderCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminOrdersCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminOrderCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSslCertsCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSslCertCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminInvoicesCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminInvoiceCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminOrdersIntranetCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminOrderIntranetCtrl.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminContactsCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminContactCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminQueriesCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminDomainsCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSslCertsAssignedCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSignaturesAssignedCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSslCertsValidateCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSslCertValidateCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSignaturesValidateCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminSignatureValidateCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminQuotationsCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminQuotationCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminQuotationsApproveCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminNotificationsCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProductCategoriesCtrl.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/controllers/adminProductCategoryCtrl.js'); ?>"></script>

<!-- SERVICES -->
<script src="<?php echo base_url('assets/backend/angular/services/login_services.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/angular/services/configurations_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/users_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/images_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/roles_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/menus_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/privileges_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/profile_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/customers_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/products_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/product_types_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/providers_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/orders_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/order_types_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/order_products_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/order_product_details_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/quotation_products_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/quotation_product_details_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/order_ssl_certs_assign_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/order_firm_certs_assign_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/ssl_certs_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/currency_types_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/product_details_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/product_san_details_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/order_details_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/order_obs_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/invoices_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/orders_intranet_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/contacts_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/phone_codes_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/countries_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/contact_types_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/sunat_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/document_types_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/sectors_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/domains_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/ssl_certs_assigned_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/signatures_assigned_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/customer_contacts_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/additional_sans_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/ssl_cert_status_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/operating_system_types_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/server_types_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/contacts_ssl_certs_assigned_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/contacts_signatures_assigned_services.js'); ?> "></script>
  <script src="<?php echo base_url('assets/backend/angular/services/comments_ssl_certs_assigned_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/quantity_years_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/ssl_certs_validate_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/signatures_validate_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/signature_forms_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/concepts_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/quotations_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/quotations_approve_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/notifications_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/quotation_templates_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/product_categories_services.js'); ?> "></script>
<script src="<?php echo base_url('assets/backend/angular/services/credit_times_services.js'); ?> "></script>
</body>
</html>
