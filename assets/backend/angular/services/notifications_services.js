var app = angular.module('pmediaApp.notifications', []);

app.factory('Notifications', ['$http', '$q', function($http, $q) {

    let self = {
        message: '',
        err: false,
        status: '',
        data_notifications: [],
        getNotifications: function() {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + "admin/notifications/"
            }).then(function(resp) {
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;
                self.data_notifications = resp.data;

                return d.resolve();
            });

            return d.promise;
        },
        getNotificationsFromNow: function() {
            var d = $q.defer();

            $http({
                method: 'GET',
                url: base_url + "admin/notifications/now"
            }).then(function(resp) {
                self.err = resp.data.err;
                self.message = resp.data.message;
                self.status = resp.data.status;
                self.data_notifications = resp.data;

                return d.resolve();
            });

            return d.promise;
        }
    };

    return self;
}]);