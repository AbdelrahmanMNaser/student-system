app = angular.module("myApp", [
  "ngRoute",
  "angularUtils.directives.dirPagination",
]);

app.service('identityService', function($http) {
  var identity = {};

  return {

    fetchIdentity: function() {
      return $http.get("/api/shared/session_info")
        .then(function(response) {
          identity = response.data.message;
          return identity;
        })
        .catch(function(error) {
          console.error("Error fetching session:", error);
        });
    }
  };    
});