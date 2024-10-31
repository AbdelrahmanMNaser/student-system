function createPDF(title, data) {
  $(document).ready(function () {
    $("#create_pdf").click(function () {
      var $table_clone = $("table").clone(); // clone the table
      $table_clone.find("th:last").remove(); 
      $table_clone.find("#edit, #delete").remove(); 

      // Add styles
      var css =
        "<style>" +
        "table { width: 100%; border-collapse: collapse; }" +
        "th, td { border: 1px solid #dee2e6; padding: 0.75rem; vertical-align: top; text-align: center; }" +
        "thead th { vertical-align: bottom; border-bottom: 2px solid #dee2e6; font-size: 14px; background-color: lightblue; }" +
        "</style>";
      var table_html = css + $table_clone.prop("outerHTML");

      $.post(
        "/includes/generate_pdf.php",
        {
          html: table_html,
          title: title,
          data: data,
        },
        function (data) {
          window.open("/includes/generate_pdf.php");
        }
      );
    });
  });
}
