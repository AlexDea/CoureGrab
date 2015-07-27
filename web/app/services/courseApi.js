courseGrab.service('courseApi', ['$http', function ($http) {

        this.searchCourses = function (query, page, limit, callback) {
            var params = {
                limit: limit,
                page: page
            };
            angular.extend(params, query);
            console.log(params);
            
            $http.post('api/post/courses', params)
            .success(function (data) {
                callback(data);
            }).error(function (data, status, headers, config) {
                console.log('error', config);
            });
        };

        this.fetchFilters = function (query, callback) {
            $http.post('api/post/filters', query).success(function (data) {
                callback(data);
            }).error(function (data, status, headers, config) {
                console.log('error', config);
            });
        };
        
        this.getTotalPages = function (query, limit, callback) {
            var params = {
                limit: limit
            };
            angular.extend(params, query);
            console.log(params);
            
            $http.post('api/post/count/pages', params)
            .success(function (data) {
                callback(data);
            }).error(function (data, status, headers, config) {
                console.log('error', config);
            });
        };

    }]);
