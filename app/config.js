var app = angular.module("myApp", ["ngRoute", "angularUtils.directives.dirPagination"]);


app.config(function ($routeProvider, $locationProvider) {
  // Inject $locationProvider
  $locationProvider.html5Mode(true);

  $routeProvider
    .when("/course", {
      templateUrl: "/user/admin/course/view.html",
      controller: "crsView",
    })

    .when("/course/add", {
      templateUrl: "/user/admin/course/add.html",
      controller: "crsAdd",
    })

    .when("/course/edit/:id", {
      templateUrl: "/user/admin/course/add.html",
      controller: "crsAdd",
    })

    .when("/cs_courses", {
      templateUrl: "/catalogue/cs_courses.html",
    })

    .when("/login", {
      templateUrl: "login.html",
      controller: "loginCtrl",
    })

    .when("/", {
      templateUrl: "/user/home.html",
      controller: "mainCtrl",
    })

});