app.controller(
  "mainCtrl",
  function ($scope, $http, apiService, $compile, $rootScope) {
    loadNav(
      "/template/identity_nav.html",
      "identity_nav",
      $http,
      $compile,
      $rootScope
    );

    loadNav("/template/menu_nav.html", "menu_nav", $http, $compile, $rootScope);

    apiService
      .fetchData("shared.session_info")
      .then(function (response) {
        $scope.identity = response.data.message;
      })
      .catch(function (error) {
        console.error("Error fetching session:", error);
      });
  }
);
