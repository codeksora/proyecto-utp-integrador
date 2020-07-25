var app = angular.module('pmediaApp.adminProductTypesCtrl', []);

app.controller('adminProductTypesCtrl', ['$scope', '$filter', 'Products', 'NgTableParams', function($scope, $filter, Products, NgTableParams) {


    /* Paginación */
	$scope.$watch('search', function(newValue,oldValue){                   
		if(oldValue!=newValue) $scope.currentPage = 0;
	},true);

	$scope.numberOfPages=function(){
		return Math.ceil($scope.getData().length/$scope.pageSize);
	}

	$scope.getData = function() {
		return $filter('filter')($scope.users, $scope.search);
	}
	
	Users.get_users().then(function() {
		$scope.users = Users.data_users;	
	});
}]);

app.filter('startFrom', function() {
	return function(input, start) {
			start = +start;
			return input.slice(start);
	} 
});

app.filter('range', function() {
	return function(input, total) {
		total = parseInt(total);

		for (var i=0; i<total; i++) {
			input.push(i);
		}

		return input;
	};
});