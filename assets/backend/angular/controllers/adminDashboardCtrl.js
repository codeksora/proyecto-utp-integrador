var app = angular.module("pmediaApp.adminDashboardCtrl", []);

app.controller("adminDashboardCtrl", [
  "$scope",
  "Users",
  "Customers",
  "Orders",
  "Ssl_certs_validate",
  "Signatures_validate",
  "Ssl_certs_assigned",
  "Quotations_approve",
  "Quotations",
  function(
    $scope,
    Users,
    Customers,
    Orders,
    Ssl_certs_validate,
    Signatures_validate,
    Ssl_certs_assigned,
    Quotations_approve,
    Quotations
  ) {
    $scope.setActive("adminDashboard");

    $scope.countUsers = 0;
    $scope.countContactUsUsers = 0;
    $scope.quantityCustomers = 0;

    Users.getUsers().then(function() {
      $scope.users = Users.data_users;
    });

    Customers.getCustomers().then(function() {
      $scope.customers = Customers.data_customers;
    });

    Orders.getOrders().then(function() {
      $scope.orders = Orders.data_orders;
    });

    Ssl_certs_validate.getSslCertsValidate().then(function() {
      $scope.ssl_certs_validate = Ssl_certs_validate.data_ssl_certs_validate;
    });

    Signatures_validate.getSignaturesValidate().then(function() {
      $scope.signatures_validate = Signatures_validate.data_signatures_validate;
    });

    Quotations_approve.getQuotationsPending().then(function() {
      $scope.quotations_pending = Quotations_approve.data_quotations_pending;
    });

    Quotations.getQuotations().then(function() {
      $scope.quotations = Quotations.data_quotations;
    });

    Ssl_certs_assigned.getSslCertAssignedBySslCertStatusId(3).then(function() {
      $scope.ssl_certs_assigned = Ssl_certs_assigned.data_ssl_certs_assigned;
    });
  }
]);
