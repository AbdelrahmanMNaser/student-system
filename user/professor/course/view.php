<!DOCTYPE html>
<html ng-app="myApp" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Course | View</title>
</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "print_data_input.php");

  ?>

  <main class="mx-auto grades min-vh-100 text-center py-5 px-3" ng-controller="courseCtrl" id="courses">

    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Courses</h2>
    </header>

    <select class="form-select w-15 mb-4 mx-auto" ng-model="semesterSel" ng-change="submitForm()" id="semester" name="semester">
      <option value="" disabled selected>Select Semester</option>
      <optgroup ng-repeat="semester in semesters" label="{{semester.year }}">
        <option value="{{ semester.id }}">{{ semester.semester}}</option>
      </optgroup>
    </select>

    <table class="table table-bordered table-striped">
      <thead>
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Students Count</th>
      </thead>
      <tbody>

        <tr ng-if="courses && courses.length == 0">
          <td colspan="3">No courses found</td>
        </tr>

        <tr ng-if="!courses">
          <td colspan="3">Please Select semester</td>
        </tr>

        <tr ng-repeat="course in courses">
          <td>{{ course.code }}</td>
          <td>
            <a ng-click="courseClick(course)" href="view-details.php" class="course-link" data-course-id="{{ course.code }}" data-course-name="{{ course.name }}">
              {{ course.name }}
            </a>
          </td>
          <td>{{ course.students_count }}</td>
        </tr>

      </tbody>
    </table>
  </main>

  <script>
    var app = angular.module('myApp', []);

    app.controller('courseCtrl', function($scope, $http) {
      function getData() {
        $http.get("/api/professor/course/fetch.php")
          .then(function(response) {
            $scope.courses = response.data;
          }, function(error) {
            console.error('Error fetching courses:', error);
          });
      }

      $scope.submitForm = function() {
        if ($scope.semesterSel) { // Only make the HTTP request if a country is selected
          $.ajax({
            url: '/api/shared/update_session.php',
            type: 'POST',
            data: {
              semester: $scope.semesterSel
            },
            success: function(response) {
              console.log(response);
              getData();
            },
            error: function(error) {
              console.error('Error:', error);
            }
          });
        }
      };

      $scope.courseClick = function(course) {
        $.ajax({
          url: '/api/shared/update_session.php',
          type: 'POST',
          data: {
            choosen_course_id: course.code,
            choosen_course_name: course.name
          },
          success: function(response) {
            console.log(response);
          },
          error: function(error) {
            console.error('Error:', error);
          }
        });
      };

      $http.get("/api/shared/fetch_semester.php?function=teaching&role=professor")
        .then(function(response) {
          $scope.semesters = response.data;
          console.log($scope.semesters);
        }, function(error) {
          console.error('Error fetching semesters:', error);
        });

    });
  </script>


</body>

</html>