<!DOCTYPE html>
<html ng-app="myApp" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student - View</title>
</head>

<body ng-controller="studentCtrl">
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH .  "scores_grades.php");
  ?>

  <main class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Student</h2>
    </header>

    <table class="table table-bordered table-striped">
      <thead>
        <th>ID</th>
        <th>Student Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>City</th>
        <th>E-mail</th>
        <th>Phone(s)</th>
        <th>Register Date</th>
        <th>Department Name</th>
        <th>Level</th>
        <th colspan="2">Actions</th>
      </thead>
      <tbody>
        <tr ng-if="students.length == 0">
          <td colspan="11">No Students found</td>
        </tr>

        <tr ng-repeat="student in students">
          <td>{{student.id}}</td>
          <td>{{student.first_name + ' ' + student.last_name}}</td>
          <td>{{student.gender}}</td>
          <td>{{student.age}}</td>
          <td>{{student.city}}</td>
          <td>{{student.email}}</td>
          <td>{{student.phone}}</td>
          <td>{{student.register_date}}</td>
          <td>{{student.department}}</td>
          <td>{{student.level}}</td>

          <td>
            <form action="add.php" method="post" onsubmit="confirmEdit(event, 'Student ' + student.first_name + ' ' + student.last_name + ' - ID: ' + student.id);">
              <input type="hidden" name="edit_id" ng-value="{{student.id}}">
              <input type="hidden" name="edit_fname" value="{{student.first_name}}">
              <input type="hidden" name="edit_lname" value="{{student.last_name}}">
              <input type="hidden" name="edit_bdate" value="{{student.birth}}">
              <input type="hidden" name="edit_gender" value="{{student.gender}}">
              <input type="hidden" name="edit_city" value="{{student.city}}">
              <input type="hidden" name="edit_street" value="{{student.street}}">
              <input type="hidden" name="edit_email" value="{{student.email}}">
              <input type="hidden" name="edit_dept_name" value="{{student.department}}">
              <button type="submit" class="btn btn-warning">
                <i class="fas fa-edit"></i>
              </button>
            </form>
          </td>

          <td>
            <form action="" method="post" onsubmit="confirmRemove(event, 'Student ' + student.first_name + ' ' + student.last_name + ' - ID: ' + student.id);">
              <input type="hidden" name="delete" value="{{student.num}}">
              <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </td>

        </tr>
      </tbody>
    </table>

  </main>

  <script>
    var app = angular.module("myApp", []);
    app.controller("studentCtrl", function($scope, $http) {
      $http.get("/api/admin/student/fetch.php")
        .then(function(response) {
          $scope.students = response.data;
          console.log(response.data);
        });
    });
  </script>

  <script>
    if (new URLSearchParams(window.location.search).has("edit")) {
      showAlert("Edit Successful", "Student data is editted Successfully", "info", "OK");
    }
  </script>

</body>

</html>