app.controller("crsView", function ($scope, apiService, $location, $timeout) {
  $scope.msgs = [
    "Course data is edited Successfully",
    "Course data is deleted Successfully",
  ];

  function fetchCourses() {
    apiService
      .fetchData("admin.course")
      .then(function (response) {
        $scope.courses = response.data;
      })
      .catch(function (error) {
        console.error("Error fetching courses:", error);
      });
  }

  function initializeHeaderOptions() {
    $scope.headerOptions = [
      { label: "Index" },
      { label: "Course Code", value: "id" },
      { label: "Course Name", value: "name" },
      { label: "Credits", value: "credit" },
      { label: "Pre-requisites", value: "pre_requisites" },
      { label: "Description", value: "description" },
    ];
  }

  function initializePagination() {
    $scope.currentPage = 1;
    $scope.numitems = 5;
    $scope.itemsPerPage = $scope.numitems;

    $scope.$watch("numitems", function (newVal, oldVal) {
      if (newVal !== oldVal) {
        $scope.itemsPerPage = newVal;
      }
    });
  }

  $scope.customFilter = function (data) {
    customFilter($scope, "name");
  };

  $scope.sortData = function (column) {
    sortData($scope, column);
  };

  $scope.getSortClass = function (column) {
    return getSortClass($scope, column);
  };

  $scope.editCourse = async function (course) {
    var msg = `- Course Name: ${course.name}\n- Course Code: ${course.id}`;
    confirmEdit(msg).then((willEdit) => {
      if (willEdit) {
        $timeout(() => {
          $location.path(`/course/edit/${course.id}`);
        });
      }
    });
  };

  $scope.deleteCourse = function (course) {
    var msg = `- Course Name: ${course.name}\n- Course Code: ${course.id}`;
    confirmRemove(msg).then((willDelete) => {
      if (willDelete) {
        apiService
          .deleteData("admin.course", course.id)
          .then(function (response) {
            $location.path("/course/");
          })
          .catch(function (error) {
            console.error("Error deleting course:", error);
          });
      }
    });
  };

  function checkEditSuccess() {
    if (new URLSearchParams(window.location.search).has("edit")) {
      showAlert(
        "Edit Successful",
        "Course data is edited Successfully",
        "info",
        "OK"
      );
    }
  }

  // Initialize controller
  fetchCourses();
  initializeHeaderOptions();
  initializePagination();
  checkEditSuccess();
});

app.controller("crsAdd", function ($scope, apiService, $location, $routeParams) {
  var courseId = $routeParams.id;

  function fetchCourses() {
    apiService
      .fetchData("admin.course")
      .then(function (response) {
        $scope.fetchedCourses = response.data;
        initializeCourseNameToIdMap();
        initializeCourse();
        if (courseId) {
          fetchCourseById(courseId);
        } else {
          $scope.editMode = false;
        }
      })
      .catch(function (error) {
        console.error("Error fetching courses:", error);
      });
  }

  function initializeCourseNameToIdMap() {
    $scope.courseNameToIdMap = {};
    $scope.fetchedCourses.forEach((course) => {
      $scope.courseNameToIdMap[course.name] = course.id;
    });
  }

  function initializeCourse() {
    $scope.course = {
      edit_id: null,
      pre_requisites: [],
    };
  }

  function fetchCourseById(courseId) {
    apiService
      .fetchDataById("admin.course", courseId)
      .then(function (response) {
        $scope.editMode = true;
        $scope.course = response.data;
        $scope.course.edit_id = $scope.course.id;
        initializePreRequisites();
      })
      .catch(function (error) {
        console.error("Error fetching course by ID:", error);
      });
  }

  function initializePreRequisites() {
    if ($scope.course.pre_requisites) {
      $scope.course.pre_requisites = $scope.course.pre_requisites
        .split(", ")
        .map((name) => name.trim())
        .map((name) => $scope.courseNameToIdMap[name]);
    } else {
      $scope.course.pre_requisites = [];
    }
  }

  $scope.isPreReqSelected = function (courseId) {
    return (
      $scope.course.pre_requisites &&
      $scope.course.pre_requisites.includes(courseId)
    );
  };

  $scope.togglePreReq = function (courseId) {
    if (!Array.isArray($scope.course.pre_requisites)) {
      $scope.course.pre_requisites = [];
    }

    var index = $scope.course.pre_requisites.indexOf(courseId);

    if (index === -1) {
      $scope.course.pre_requisites.push(courseId);
    } else {
      $scope.course.pre_requisites.splice(index, 1);
    }
  };

  $scope.validateInput = function () {
    var inputValue = $scope.course.credit;
    var numericValue = inputValue.replace(/[^0-9]/g, "");
    var parsedValue = parseInt(numericValue, 10) || 0;
    $scope.course.credit = Math.min(Math.max(parsedValue, 0), 3);
  };

  $scope.submitForm = function () {
    var method = $scope.editMode ? "updateData" : "insertData";
    var params = $scope.editMode
      ? [$scope.course.id, $scope.course]
      : [$scope.course];

    apiService[method]("admin.course", ...params).then(function (response) {
      if (response.data.success) {
        $location.path("/course/");
      } else {
        alert("Error: " + response.data.message);
      }
    });
  };

  // Initialize controller
  fetchCourses();
});