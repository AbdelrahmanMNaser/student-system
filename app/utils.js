function loadNav(path, nav_placeholder, $http, $compile, $scope) {
  $http.get(path)
    .then(function (response) {
      var newNav = angular.element(response.data);
      if (!newNav) {
        console.error('Navigation file could not be loaded');
        return;
      }
      
      var placeholderDiv = angular.element(
        document.querySelector('#' + nav_placeholder)
      );
      if (!placeholderDiv) {
        console.error('Placeholder div not found: #' + nav_placeholder);
        return;
      }

      placeholderDiv.replaceWith(newNav);
      // Compile the new navigation and apply the scope
      $compile(newNav)($scope);
      // Manually trigger digest cycle
      $scope.$applyAsync();
    }, function (error) {
      console.error('Error loading navigation:', error);
    });
}


// sortFunctions
function sortData($scope, column) {
  if ($scope.sortColumn === column) {
    $scope.reverseSort = !$scope.reverseSort;
  } else {
    $scope.sortColumn = column;
    $scope.reverseSort = false;
  }
}

function getSortClass(scope, column) {
  if (scope.sortColumn == column) {
    return scope.reverseSort ? 'arrow-down' : 'arrow-up';
  }
  return '';
}

// filterFunction
function customFilter(scope, defaultFilter) {
  scope.customFilter = function (data) {
    if (!scope.searchText) {
      return true;
    }
    const searchText = scope.searchText.toLowerCase();
    const searchField = scope.searchField || defaultFilter;
    return data[searchField].toLowerCase().includes(searchText);
  };
}
