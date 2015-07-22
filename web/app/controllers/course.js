courseGrab.controller('courseController', ['$scope', '$window', '$routeParams', 'courseApi', 
    'courseSearch', function ($scope, $window, $routeParams, courseApi, courseSearch) {
        $scope.settings = $window.settings;
        $scope.courses = [];
        $scope.filters = [];

        $scope.courseSearch = courseSearch.initalizeCourseSearch();
        console.log($scope.courseSearch.school);
        courseApi.fetchFilters(function (response) {
            $scope.filters = response;
            console.log($scope.filters);
        });

        $scope.searchCourses = function () {
            console.log($scope.courseSearch);
            courseApi.searchCourses(null, function (response) {
                console.log(response);
                $scope.courses = response;
            });
        };

    }]);
