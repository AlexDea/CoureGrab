courseGrab.controller('cartController', ['$scope', '$window', '$routeParams', 
    '$location', '$anchorScroll', 'courseApi', 'notifyApi', 'dataPersistence',
    function ($scope, $window, $routeParams, $location, $anchorScroll, courseApi, 
        notifyApi, dataPersistence) {
        $scope.settings = $window.settings;
        $scope.cart = {
            form: {},
            submitting: false,
            submited: false,
            success: false,
            errors: []
        }; 
        
        $scope.resetCart = function() {
            $scope.clearCart();
            $scope.cart.submited = false;
            $scope.cart.submitting = false;
        };
        
        $scope.submitCart = function() {
            $scope.cart.success = false;
            $scope.cart.submited = false;
            $scope.cart.submitting = true;
            
            if ($scope.validCart()) {
                var query = {
                    email: $scope.cart.form.email,
                    courses: $scope.selectedCourses
                };
                notifyApi.submit(query, function(data) {
                    console.log(data);
                    $scope.cart.success = data.success;
                    $scope.cart.errors = data.errors;
                    $scope.cart.submitting = false;
                    $scope.cart.submited = true;
                    $scope.clearCart();
                });
            }
        };
        $scope.validCart = function() {
            return !$scope.isCartEmpty()
                    && !angular.isUndefined($scope.cart.form.email);
        };
        
        $scope.wasSuccessful = function() {
            return $scope.cart.submited && $scope.cart.success;
        };
        
        $scope.isCartEmpty = function() {
            return $scope.selectedCourses.length <= 0;
        };            
        
    }]);