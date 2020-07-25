<!-- Menu Toggle Button -->
<a href class="dropdown-toggle" data-toggle="dropdown">
  <!-- The user image in the navbar-->
  <img src="<?php echo base_url('uploads/' . $this->session->userdata('image_profile')); ?>" class="user-image" alt="User Image">
  <!-- hidden-xs hides the username on small devices so only the image appears. -->
  <span class="hidden-xs"><?php echo $this->session->userdata('full_name'); ?></span>
</a>
<ul class="dropdown-menu">
  <!-- The user image in the menu -->
  <li class="user-header">
    <img src="<?php echo base_url('uploads/' . $this->session->userdata('image_profile')); ?>" class="img-circle" alt="User Image">

    <p><?php echo $this->session->userdata('full_name'); ?><small><?php echo $this->session->userdata('role_name'); ?></small></p>
  </li>
  <!-- Menu Footer-->
  <li class="user-footer">
      <div class="pull-left">
          <a href="<?php echo base_url(); ?>admin/#!/profile/" class="btn btn-default btn-flat">Mi perfíl</a>
      </div>

        <div class="pull-right">
            <button ng-click="logout()" class="btn btn-default btn-flat">Cerrar sesión</button>
        </div>
  </li>
</ul>