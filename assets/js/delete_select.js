function handleDataRemoval(formId, dataKeys) {
  var form = "#" + formId;
  // Attach submit event handler to the form
  $(form).on("submit", function (e) {

    // Loop through each dataKey and remove it from sessionStorage and server session
    dataKeys.forEach(function (dataKey) {
      // Remove from sessionStorage
      sessionStorage.removeItem(dataKey);

      // Remove from server session (using AJAX)
      removeSession(dataKey).done(function () {
        // Reset the select element's value in the DOM after the server response
        $("#" + dataKey).val('');
        location.reload();
      });
    });
    form.submit();
  });
}


function removeSession(dataKey) {
  return $.post("/includes/remove_session.php", {
    'removeKey': dataKey,
  }).fail(function (jqXHR, textStatus, errorThrown) {
    // Handle error here
    console.error("Error occurred: " + textStatus, errorThrown);
  });
}
