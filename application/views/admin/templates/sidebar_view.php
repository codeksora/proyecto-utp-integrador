<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

  <!-- Sidebar user panel (optional) -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="<?php echo base_url('uploads/' . $this->session->userdata('image_profile')); ?>" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
    <p><a href="<?php echo site_url('admin/#!/profile') ?>">
    <?php echo $this->session->userdata('full_name'); ?></a></p>
      <!-- Status -->
      <a href="<?php echo site_url('admin/#!/profile') ?>"><i class="fa fa-circle text-success"></i> En línea</a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENÚ PRINCIPAL</li>
      <li ng-class="adminNotifications"><a href="<?php echo base_url() ?>admin/#!/notifications"><i class="fa fa-user"></i> <span>Notificaciones</span></a></li>
      <li ng-class="adminDashboard"><a href="<?php echo base_url() ?>admin/#!/"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


    <!-- PROVEEDORES -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 7 && $privilege->read == 1): ?>
        <li ng-class="[adminProviders, adminProviderAdd]" class="treeview">
            <a href>
                <i class="fa fa-globe"></i> <span>Proveedores</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li ng-class="adminProviders"><a href="<?php echo base_url() ?>admin/#!/providers/"><i class="fa fa-circle-o"></i> Todos los proveedores</a></li>
                <?php if($privilege->menu_id == 7 && $privilege->insert == 1): ?>
                <li ng-class="adminProviderAdd"><a href="<?php echo base_url() ?>admin/#!/providers/add/"><i class="fa fa-circle-o"></i> Añadir proveedor</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; endforeach; ?>

    <!-- PRODUCTOS -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 5 && $privilege->read == 1): ?>
        <li ng-class="[adminProducts, adminProductAdd]" class="treeview">
            <a href>
                <i class="fa fa-shopping-bag"></i> <span>Productos</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li ng-class="adminProducts"><a href="<?php echo base_url() ?>admin/#!/products/"><i class="fa fa-circle-o"></i> Todos los productos</a></li>
                <?php if($privilege->menu_id == 5 && $privilege->insert == 1): ?>
                <li ng-class="adminProductAdd"><a href="<?php echo base_url() ?>admin/#!/products/add/"><i class="fa fa-circle-o"></i> Añadir producto</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; endforeach; ?>

    <!-- PRODUCTOS -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 27 && $privilege->read == 1): ?>
        <li ng-class="[adminProductCategories, adminProductCategoryAdd]" class="treeview">
            <a href>
                <i class="fa fa-shopping-bag"></i> <span>Categorías del producto</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li ng-class="adminProductCategories"><a href="<?php echo base_url() ?>admin/#!/product-categories/"><i class="fa fa-circle-o"></i> Todas las categorías</a></li>
                <?php if($privilege->menu_id == 27 && $privilege->insert == 1): ?>
                <li ng-class="adminProductCategoryAdd"><a href="<?php echo base_url() ?>admin/#!/product-categories/add/"><i class="fa fa-circle-o"></i> Añadir categoría</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; endforeach; ?>
    
    <!-- CLIENTES -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 9 && $privilege->read == 1): ?>
      <li ng-class="[adminCustomers, adminCustomerAdd]" class="treeview">
        <a href>
          <i class="fa fa-users"></i> <span>Clientes</span>
          
          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li ng-class="adminCustomers"><a href="<?php echo site_url('admin/#!/customers') ?>"><i class="fa fa-circle-o"></i> Todos los clientes</a></li>
          <?php if($privilege->menu_id == 9 && $privilege->insert == 1): ?>
            <li ng-class="adminCustomerAdd"><a href="<?php echo site_url('admin/#!/customers/add') ?>"><i class="fa fa-circle-o"></i> Añadir cliente</a></li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; endforeach; ?>

    <!-- COTIZACIONES -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 25 && $privilege->read == 1): ?>
      <li ng-class="[adminQuotations, adminQuotationAdd]" class="treeview">
        <a href>
          <i class="fa fa-shopping-cart"></i> <span>Cotizaciones</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li ng-class="adminQuotations"><a href="<?php echo base_url() ?>admin/#!/quotations/"><i class="fa fa-circle-o"></i> Todas las cotizaciones</a></li>
          <?php if($privilege->menu_id == 25 && $privilege->insert == 1): ?>
            <li ng-class="adminQuotationAdd"><a href="<?php echo base_url() ?>admin/#!/quotations/add/"><i class="fa fa-circle-o"></i> Añadir cotización</a></li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; endforeach; ?>

    <!-- ORDENES -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 8 && $privilege->read == 1): ?>
      <li ng-class="[adminOrders, adminOrderAdd]" class="treeview">
        <a href>
          <i class="fa fa-shopping-cart"></i> <span>Ordenes</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li ng-class="adminOrders"><a href="<?php echo base_url() ?>admin/#!/orders/"><i class="fa fa-circle-o"></i> Todas las ordenes</a></li>
        </ul>
      </li>
    <?php endif; endforeach; ?>

    <!-- CERTIFICADOS SSL -->
    <?php foreach ($privileges as $privilege): 
      if(($privilege->menu_id == 13) && $privilege->read == 1): ?>
        <li ng-class="[adminSslCerts, adminSslCertsAssigned, adminSslCertsValidate]" class="treeview">
            <a href>
                <i class="fa fa-server"></i> <span>Certificados SSL</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
                <li ng-class="adminSslCertsAssigned"><a href="<?php echo base_url() ?>admin/#!/ssl-certificates-assigned/"><i class="fa fa-circle-o"></i> Todos los cert. SSL asignados</a></li>
                <li ng-class="adminSslCertsValidate"><a href="<?php echo base_url() ?>admin/#!/ssl-certificates-validate/"><i class="fa fa-circle-o"></i> Formularios ingresados</a></li>
                <li ng-class="adminSslCerts"><a href="<?php echo base_url() ?>admin/#!/ssl-certificates/"><i class="fa fa-circle-o"></i> Añadir Certificado SSL</a></li>
            </ul>
        </li>
    <?php endif; endforeach; ?>

    <li class="header">MANTENIMIENTO</li>
    <!-- USUARIOS -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 2 && $privilege->read == 1): ?>
      <li ng-class="[adminUsers, adminUserAdd]" class="treeview">
        <a href>
          <i class="fa fa-users"></i> <span>Usuarios</span>
          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li ng-class="adminUsers"><a href="<?php echo base_url() ?>admin/#!/users/"><i class="fa fa-circle-o"></i> Todos los usuarios</a></li>
          <?php if($privilege->menu_id == 2 && $privilege->insert == 1): ?>
            <li ng-class="adminUserAdd"><a href="<?php echo base_url() ?>admin/#!/users/add/"><i class="fa fa-circle-o"></i> Añadir usuario</a></li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; endforeach; ?>
    <!-- ROLES -->
    <?php foreach ($privileges as $privilege): if($privilege->menu_id == 3 && $privilege->read == 1): ?>
      <li ng-class="[adminRoles, adminRoleAdd]" class="treeview">
        <a href>
          <i class="fa fa-user-secret"></i> <span>Roles</span>
          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li ng-class="adminRoles"><a href="<?php echo base_url() ?>admin/#!/roles/"><i class="fa fa-circle-o"></i> Todos los roles</a></li>
          <?php if($privilege->menu_id == 3 && $privilege->insert == 1): ?>
            <li ng-class="adminRoleAdd"><a href="<?php echo base_url() ?>admin/#!/roles/add/"><i class="fa fa-circle-o"></i> Añadir rol</a></li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; endforeach; ?>
</ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
