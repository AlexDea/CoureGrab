courseGrab.controller('courseController', ['$scope', '$window', '$routeParams', 
    '$location', '$anchorScroll', 'courseApi', 'dataPersistence',
    function ($scope, $window, $routeParams, $location, $anchorScroll, courseApi, dataPersistence) {
        $scope.settings = $window.settings;
        $scope.courses = [];
        $scope.filters = [];
        $scope.isShowCart = false;
        //if data persist is empty, default to an empty object.
        $scope.courseSearch = dataPersistence.state.courseSearch || {};
        $scope.selectedCourses = dataPersistence.state.selectedCourses || [];
        
        $scope.pagination = {
            page:  parseInt($routeParams.page) || 1,
            limit: 20,
            links: []
        };
        
        //watch and persist search state
        $scope.$watch('courseSearch', function(value) {
            dataPersistence.state.courseSearch = value;
        });
        //watch and persist search state
        $scope.$watch('selectedCourses', function(value) {
            dataPersistence.state.selectedCourses = value;
        });

        $scope.toggleCart = function() {
            $scope.isShowCart = !$scope.isShowCart;
        };
        
        $scope.addCourseToCart = function(course) {
            $scope.selectedCourses.push(course);
        };
        
        $scope.removeCourseFromCart = function(course) {
            var index = -1;
            for (var i=0; i < $scope.selectedCourses.length; i++) {
                if ($scope.selectedCourses[i].id === course.id) {
                    index = i;
                    break;
                }
            }
            console.log(index);
            $scope.selectedCourses.splice(index, 1);  
        };
        
        $scope.clearCart = function() {
            $scope.selectedCourses.splice(0, $scope.selectedCourses.length);
        };

        $scope.isInCart = function(course) {
            var selected = $scope.selectedCourses;
            var contains = false;
            for (var i=0; i < selected.length; i++) {
                if (selected[i].courseNumber === course.courseNumber) {
                        contains = true;
                    break;
                }
            }
            return contains;
        };

        $scope.fetchFilters = function() {
            courseApi.fetchFilters($scope.courseSearch, function (response) {
                $scope.filters = response;
                console.log($scope.filters);
            });
        };

        $scope.resetSearch = function() {
            $scope.courseSearch = {};
            //$scope.fetchFilters();
        };

        $scope.searchCourses = function (resetPage) {
            if (resetPage) {
                $scope.pagination.page = 1;
            }

            console.log($scope.courseSearch);
            courseApi.searchCourses($scope.courseSearch, $scope.pagination.page,
                    $scope.pagination.limit, function (response) {
                        console.log(response);
                        $scope.courses = response;
                    });
            courseApi.getTotalPages($scope.courseSearch, $scope.pagination.limit,
                    function (response) {
                        console.log(response);
                        $scope.pagination.total = response.total;
                        $scope.pagination.pages = response.pages;
                        $scope.pagination.links = pagination($scope.pagination.page,
                                $scope.pagination.pages, 3);
                    });
        };

        $scope.goToAnchor = function (id) {
            $location.hash(id);
            $anchorScroll();
        };
        
        $scope.handleDisabledClick = function() {
            return false;
        };

        //pulled from https://github.com/CraftBlock/McmmoStats/blob/master/app/app.js
        function pagination(page, pages, distance) {
            var distance = distance || 3;
            var input = [];
            var start = page - distance;
            var end = page + distance;
            //make sure to continue until buffers from edges and page seperate
            if (start <= distance + 1) {
                start = 1;
            }
            if (end > pages - distance - 1) {
                end = pages;
            }

            //console.log(start);
            //have starting edge buffers
            if (start >= distance + 1) {
                for (var i = 1; i <= distance; i++) {
                    input.push(i);
                }
                //page seperator
                input.push('...');
            }

            //have buffers on either side of "page"
            for (var i = start; i <= end; i++) {
                input.push(i);
            }

            //have ending edge buffers
            if (end <= pages - distance + 1) {
                //page seperator
                input.push('...');
                for (var i = pages - distance + 1; i <= pages; i++) {
                    input.push(i);
                }
            }

            return input;
        }
        
        $scope.fetchFilters();
        //inital the page with courses
        $scope.searchCourses();
    }]);