courseGrab.service('notifyApi', ['$http', function ($http) {

        this.submit = function (query, callback) {
            $http.post('api/post/notify', query).success(function (data) {
                callback(data);
            }).error(function (data, status, headers, config) {
                console.log('error', config);
            });
        };
        
    }]);
