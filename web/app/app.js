var origin = document.location.origin;
var folder = document.location.pathname.split('/')[1];
var path = origin +'/'+ folder +'/';

var courseGrab = angular.module('courseGrab', ['ngRoute']);
courseGrab.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/', {
		templateUrl: path +'views/courses.html',
		controller: 'courseController'
	});
}]);
$(document).ready( function(){
    angular.bootstrap($('body'), ['courseGrab']);
});
