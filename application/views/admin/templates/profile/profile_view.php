<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Perfíl de usuario
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url('admin/#!'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Perfíl de usuario</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('uploads/' . $this->session->userdata('image_profile')); ?>" alt="User profile picture">

          <h3 class="profile-username text-center"><?php echo $this->session->userdata('full_name') . ' ' . $this->session->userdata('last_name'); ?></h3>

          <p class="text-muted text-center">Usuario conectado</p>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#settings" ng-click="$event.preventDefault()" data-toggle="tab">Editar perfíl</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="settings">
            <form name="frmProfile" ng-submit="save(user)" class="form-horizontal" novalidate="novalidate">
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                <img width="150" ng-if="!user.image.name" ng-src="<?php echo base_url(); ?>uploads/{{user.image_name}}" />
                <img width="150" ng-if="user.image.name" ng-src="<?php echo base_url(); ?>uploads/{{user.image.name}}" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Foto de perfíl</label>
                <div class="col-sm-10">
                  <a href="" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Añadir imágenes a la galería</a>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nombre completo</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" ng-model="user.full_name" placeholder="Nombre" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Nombre de usuario</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" ng-value="user.username" readonly="">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" ng-value="user.email" readonly="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-danger" ng-disabled="disable">Guardar cambios</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.tab-pane -->

        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->
<div class="modal gallery" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Galería de imágenes</h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" ng-click="$event.preventDefault()" data-toggle="tab" aria-expanded="true">Galería de imágenes</a></li>
                          <li class=""><a href="#tab_2" ng-click="$event.preventDefault()" data-toggle="tab" aria-expanded="false">Subir imagen</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_1">
                              <div class="row">
                                <div class="col-md-7">
                                  <div class="row">
                                    <div ng-repeat="image in all_images" class="col-md-4">
                                      <label>
                                          <input type="radio" ng-model="$parent.user.image" class="profile-img" ng-value="image">
                                          <img ng-src="<?php echo base_url(); ?>uploads/{{image.name}}" />
                                      </label>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-5">
                                    <img class="img-preview" ng-src="<?php echo base_url(); ?>uploads/{{user.image.name}}" >
                                </div>
                              </div>
                          </div> <!-- /.tab-pane -->
                          
                          <div class="tab-pane" id="tab_2">
                                <form name="formImage" ng-submit="add_image(image)" novalidate="novalidate">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <input type="file" ng-model="image.data" ngf-multiple="true" ngf-select accept="image/*" ngf-model-invalid="errorFile" required>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-primary" ng-disabled="disable">Subir imágenes</button>
                                        </div>
                                    </div>
                                </form>
                          </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                      </div><!-- nav-tabs-custom -->
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->