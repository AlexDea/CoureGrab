courseGrab.controller('cartController', ['$scope', '$window', '$routeParams', 
    '$location', '$anchorScroll', 'courseApi', 'dataPersistence',
    function ($scope, $window, $routeParams, $location, $anchorScroll, courseApi, dataPersistence) {
        $scope.settings = $window.settings;
        $scope.cart = {
            form: {},
            submited: false
        }; 
        
        $scope.resetCart = function() {
            $scope.cart.submited = false;
        };
        
        $scope.submitCart = function() {
            $scope.cart.submited = true;
        };
        
        $scope.isCartEmpty = function() {
            return $scope.selectedCourses.length === 0;
        };
       
        
    }]);