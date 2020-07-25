<!DOCTYPE html>
<html ng-app="loginApp" ng-controller="mainCtrl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema de Facturación v2.0 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="<?php echo base_url('assets/frontend/images/favicon.ico'); ?>" sizes="32x32" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('node_modules/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('node_modules/ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('dist/css/AdminLTE.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('plugins/iCheck/square/blue.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/style.css'); ?>">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="<?php echo base_url('node_modules/angular/angular.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/ngstorage/ngStorage.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/angular-recaptcha/release/angular-recaptcha.min.js'); ?>"></script>
</head>
<body class="hold-transition login-page">
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo site_url('login'); ?>"><b>Perú</b>Security</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Logueate para ingresar</p>

    <form ng-submit="login(data_user)" name="frmLogin">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="username" ng-model="data_user.username"  required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="password" ng-model="data_user.password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
<!--       <div vc-recaptcha 
        ng-model="data_user.captcha" 
        key="'6LcCeMYUAAAAAHFWxa-3Aa4_EWDPNJRvBJ_0Qalw'" 
        class="g-recaptcha"></div><br> -->
      <div uib-alert ng-repeat="alert in alerts" class="alert" ng-class="'alert-' + (alert.status)">{{ alert.message }}</div>
      <div class="row">
        <div class="col-xs-6">
          <label style="font-weight: 400;">
            <input type="checkbox" ng-model="data_user.remember_me"> Recordar
          </label>
        </div>
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-flat btn-block" ng-show="isDisabled" ng-disabled="frmLogin.$invalid == isDisabled">Ingresar</button>
          <button type="button" class="btn btn-primary btn-flat btn-block" ng-hide="isDisabled" disabled><i class="fa fa-pulse fa-spinner"></i> Cargando</button>
        </div>
        <!-- /.col -->
      </div>


    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="<?php echo base_url('node_modules/jquery/dist/jquery.min.js'); ?>"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('node_modules/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url('plugins/iCheck/icheck.min.js'); ?>"></script>

  <script src="<?php echo base_url('assets/frontend/angular/app.js'); ?> "></script>
  <script src="<?php echo base_url('assets/frontend/angular/services/login_services.js'); ?> "></script>
</body>
</html>
