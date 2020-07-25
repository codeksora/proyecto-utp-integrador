"use strict";

require.config({
  baseUrl: "",
  paths: {
    jquery: "node_modules/jquery/dist/jquery.min",
    bootstrap: "node_modules/bootstrap/dist/js/bootstrap.min",
    icheck: "plugins/iCheck/icheck.min",
    angular: "node_modules/angular/angular.min",
    vcRecaptcha: "node_modules/angular-recaptcha/release/angular-recaptcha.min",
    app: "assets/frontend/angular/app.min",
    "login.loginService": "assets/frontend/angular/services/login_services.min"
  },
  shim: {
    app: ["vcRecaptcha"],
    vcRecaptcha: {
      deps: ["angular"]
    }
  },
  deps: ["app"]
});
