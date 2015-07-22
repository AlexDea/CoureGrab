courseGrab.service('courseApi', ['$http', function ($http) {

        this.searchCourses = function (query, callback) {
            console.log(query);
            $http.post('api/post/courses', {
                params: {
                    limit: 5,
                    offset: 0
                }
            }).success(function (data) {
                callback(data);
            }).error(function (data, status, headers, config) {
                console.log('error', config);
            });
        };

        this.fetchFilters = function (callback) {
            $http.post('api/post/filters').success(function (data) {
                callback(data);
            }).error(function (data, status, headers, config) {
                console.log('error', config);
            });
        };

    }]);
