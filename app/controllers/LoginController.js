app.controller("loginCtrl", function ($scope, $location, apiService) {
  $scope.user = {};
  $scope.showRegister = false;

  $scope.showRegisterOption = function () {
    $scope.showRegister = $scope.user.role === "admin";
  };

  $scope.submitEmail = function () {
    apiService
      .insertData("shared.login", {
        role: $scope.user.role,
        email: $scope.user.email,
      })
      .then(function (response) {
        console.log("API Response:", response); // Log the full API response

        if (response.data.error) {
          if (response.data.error === "email_not_found") {
            showAlert(
              "Account does not Exist",
              "Check entered role or e-mail",
              "error",
              "Try Again"
            );
          } else if (response.data.error === "no_password") {
            window.location.href = "login_no-password.html";
          }
        } else {
          $scope.user.isVerified = true;
          $scope.user.id = response.data.message.id; // Store user ID
          console.log("User verified:", $scope.user); // Log the updated user object
        }
      })
      .catch(function (error) {
        console.error("Error occurred:", error);
        showAlert("Server Error", "Please try again later", "error", "OK");
      });
  };

  $scope.submitPassword = function () {
    apiService
      .insertData("shared.login", {
        role: $scope.user.role,
        id: $scope.user.id, // Use user ID
        password: $scope.user.password,
      })
      .then(function (response) {
        location.href = "/";
      })
      .catch(function (error) {
        console.error("Error occurred:", error);
        showAlert("Server Error", "Please try again later", "error", "OK");
      });
  };
});
