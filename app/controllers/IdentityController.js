app.controller("identityCtrl", function ($scope, $http, $location, apiService) {    
  $scope.identity = {};

  apiService
    .fetchData("shared.session_info")
    .then(function (response) {
      console.log("Session info:", response.data);
      
      $scope.identity = response.data.message;    
    })
    .catch(function (error) {
      console.error("Error fetching session:", error);
    });
    
    $scope.logout = function () {
      $http ({
        url: "/api/shared/logout",
        method: "GET"
      })
      .then(function (response) {
        location.href = "/";        
      })
    }

});
