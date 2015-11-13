var origin = document.location.origin;
var folder = document.location.pathname.split('/')[1];
var path = origin + '/' + folder + '/';

var courseGrab = angular.module('courseGrab', ['ngRoute']);
courseGrab.config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/search/:page?', {
            templateUrl: path + 'views/courses.html',
            controller: 'courseController'
        }).when('/faq', {
            templateUrl: path + 'views/faq.html',
            controller: function() {}
        })
        .when('/faq', {
            templateUrl: path + 'views/faq.html',
            controller: function() { }
        })
        .otherwise({redirectTo: '/search'});

    }])
        .run(function ($rootScope) {
            $rootScope._ = _;
            $rootScope.$on("$routeChangeStart", function (event, next, current) {
            if (sessionStorage.restorestate == "true") {
                //let everything know we need to restore state
                $rootScope.$broadcast('restorestate'); 
                sessionStorage.restorestate = false;
            }
            });

            //let everthing know that we need to save state now.
            window.onbeforeunload = function (event) {
                $rootScope.$broadcast('savestate');
            };
        });
;
$(document).ready(function () {
    angular.bootstrap($('body'), ['courseGrab']);
});
