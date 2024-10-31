<!DOCTYPE html>
<html ng-app="myApp" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professor - View</title>

  <script src="/assets/js/sweetalert.min.js"></script>
  <script src="/assets/js/confirmation_alert.js"></script>

  <script src="/assets/js/angular.min.js"></script>
  <base href="/user/admin/">

  <script src="/assets/js/app.js"></script>
  <script src="/assets/js/dirPagination.js"></script>

</head>

<body ng-controller="profCtrl">
  <?php
  define('INCLUDE_PATH', '/../../../includes/');

  include(__DIR__ . INCLUDE_PATH . "delete_item.php");
  ?>

  <div id="identity_nav"></div>
  <div id="nav-placeholder"></div>

  <main class="mx-auto admin text-center min-vh-100 py-5 px-3">

    <header class="mb-5">
      <h2 class="f-header fs-1 fw-bold text-white">View Professors</h2>
    </header>

    <div class="row mb-3" ng-include="'/template/table_header.html'" ng-init="itemName='Professor'; addLink='professor/add.php'">
    </div>

    <div class="table-responsive">
      <table ng-model="professor" class="table table-light table-bordered table-striped table-sm">
        <thead class="text-center">
          <th ng-repeat="option in headerOptions" ng-click="sortData(option.value)">
            {{ option.label }}
            <div ng-class="getSortClass(option.value)"></div>
          </th>
          <th colspan="2">Actions</th>
        </thead>
        <tbody>
          <tr ng-if="professors.length == 0">
            <td colspan="7">No professors found</td>
          </tr>

          <tr dir-paginate="professor in professors | filter:customFilter | orderBy:sortColumn:reverseSort | itemsPerPage: itemsPerPage">
            <td>{{ professor.first_name + ' ' + professor.last_name }}</td>
            <td>{{ professor.gender }}</td>
            <td>{{ professor.age }}</td>
            <td>{{ professor.email }}</td>
            <td>
              <ul>
                <li ng-repeat="phone in professor.phone.split('|')">
                  {{ phone }}
                </li>
              </ul>
            </td>
            <td>{{ professor.department }}</td>

            <td>
              <button type="button" class="btn btn-warning btn-sm" ng-click="editProfessor(professor)"> <!-- Added btn-sm -->
                <i class="fas fa-edit"></i>
              </button>
            </td>

            <td>
              <form action="" method="post" onsubmit="confirmRemove(event, 'Professor');">
                <input type="hidden" name="delete_id" ng-value="professor.id">
                <button type="submit" class="btn btn-danger btn-sm"> <!-- Added btn-sm -->
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container float-end">
      <!-- Items per page -->
      <label class="text-white" for="numitems">Items per page:</label>
      <select ng-model="numitems">
        <option>2</option>
        <option selected>5</option>
        <option>10</option>
        <option>25</option>
        <option>50</option>
        <option>100</option>
      </select>

      <dir-pagination-controls max-size="5" direction-links="true" boundary-links="true" template-url="/template/pagination.tpl.html"></dir-pagination-controls>
    </div>

  </main>

  <script>
    var app = angular.module('myApp', ['angularUtils.directives.dirPagination']);

    app.controller("profCtrl", function($scope, $http, $compile, $rootScope) {
      loadNav("/includes/identity_nav.html", "identity_nav", $http, $compile, $scope);
      loadNav("/user/admin/menu_nav.html", "nav-placeholder", $http, $compile, $rootScope);
      fetch_data($http, $scope, "admin", "professor", "fetch.php", "professors");
      fetch_data($http, $scope, "shared", "", "get_info_session.php", "identity");

      $scope.getObjectKeys = function(obj) {
        return Object.keys(obj);
      };

      $scope.headerOptions = [{
          value: 'first_name' + 'last_name',
          label: 'Professor Name'
        },
        {
          value: 'gender',
          label: 'Gender'
        },
        {
          value: 'age',
          label: 'Age'
        },
        {
          value: 'email',
          label: 'E-mail'
        },
        {
          value: 'phone',
          label: 'Phone Number'
        },
        {
          value: 'department',
          label: 'Department Name'
        }
      ];



      // Search
      $scope.customFilter = function() {
        customFilter($scope, "first_name");
      }

      // Sorting
      $scope.sortData = function(column) {
        sortData($scope, column);
      }

      $scope.getSortClass = function(column) {
        return getSortClass($scope, column);
      }

      // numitems
      $scope.numitems = 5;
      $scope.itemsPerPage = $scope.numitems;

      // Watch for changes to numitems
      $scope.$watch('numitems', function(newVal, oldVal) {
        if (newVal !== oldVal) {
          $scope.itemsPerPage = newVal;
        }
      });




      $scope.editProfessor = function(professor) {
        var msg = `- Professor Name: ${professor.first_name} ${professor.last_name}
                   - Professor ID: ${professor.id}`;
        confirmEdit(msg)
          .then((willEdit) => {
            if (willEdit) {
              try {
                localStorage.setItem('professorToEdit', JSON.stringify(professor));
                // After setting the item, redirect
                location.href = '/user/admin/professor/add.php';
              } catch (e) {
                console.error("Error saving to localStorage:", e);
              }
            }
          });
      };
    });
  </script>

  <script>
    if (new URLSearchParams(window.location.search).has("edit")) {
      showAlert("Edit Successful", "Professor data is edited Successfully", "info", "OK");
    }

    if (new URLSearchParams(window.location.search).has("delete")) {
      showAlert("Delete Successful", "Professor data is deleted Successfully", "info", "OK");
    }
  </script>

  <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if (isset($_POST["delete_id"])) {
  $pk_value = $_POST["delete_id"];
  delete_Row("professor", "id", $pk_value);

  header("location: view.php?delete=true");
}
?>