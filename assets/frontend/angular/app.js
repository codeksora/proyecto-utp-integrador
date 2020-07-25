const base_url = $('#base_url').val();
var app = angular.module('loginApp', ['login.loginService', 'vcRecaptcha']);

app.controller('mainCtrl', ['$scope', 'LoginService', ($scope, LoginService) => {

    $scope.alerts = [];
    $scope.isDisabled = true;
    $scope.data_user = {};

    LoginService.remember_me().then(() => {
        $scope.data_user = LoginService.data_user_remember;
    });

    $scope.login = data_user => {

        $scope.isDisabled = false;
        $scope.alerts = [];
        LoginService.login(data_user).then(() => {
            // $scope.isDisabled = true;

            $scope.alerts = [{
                status: LoginService.status,
                message: LoginService.message
            }]

            if(LoginService.err == false) {
                // $localStorage.user_data = LoginService.user_data;

                setTimeout(() => {
                    window.location = base_url + 'admin/'
                }, 1000);
            } else {
                grecaptcha.reset();
                $scope.isDisabled = true;
            }
        });
    }
}]);