courseGrab.factory('dataPersistence', ['$rootScope', function ($rootScope) {
        var service = {
            state: {}
        };
        function saveState() {
            sessionStorage.dataPersistence = angular.toJson(service.state);
        }
        function restoreState() {
            service.state = angular.fromJson(sessionStorage.dataPersistence);
        }
        
        if (sessionStorage.dataPersistence)
            restoreState();

        $rootScope.$on("savestate", saveState);

        return service;
    }]);