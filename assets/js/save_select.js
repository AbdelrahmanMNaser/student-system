if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

function handleDataUpdate(dataKey) {
  // Attach change event handler
  $("#" + dataKey).on("change", function () {
    var dataValue = $(this).val();

    // Update Storage
    sessionStorage.setItem(dataKey, dataValue);

    // Update the server (using AJAX)
    updateSession(dataKey, dataValue).done(function () {
      // Update the select element's value in the DOM after the server response
      $("#" + dataKey).val(dataValue);
    });
  });

  // Load initial value from Storage on page load
  var storedValue = sessionStorage.getItem(dataKey);
  if (storedValue) {
    $("#" + dataKey).val(storedValue);
  }
}

function updateSession(dataKey, dataValue) {
  return $.post("/includes/update_session.php", {
    [dataKey]: dataValue,
  }).fail(function (jqXHR, textStatus, errorThrown) {
    // Handle error here
    console.error("Error occurred: " + textStatus, errorThrown);
  });
}
