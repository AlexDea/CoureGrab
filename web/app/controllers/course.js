courseGrab.controller('courseController', ['$scope', '$routeParams', 'courseApi', function ($scope, $routeParams, courseApi) {
	$scope.courses = [];

	$scope.searchCourses = function(){
		courseApi.searchCourses(null, function(response){
			console.log(response);
			$scope.courses = response;
		});
	};

}]);
