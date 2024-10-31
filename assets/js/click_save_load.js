function handleCourseLinkClick(course_link) {
  $(course_link).click(function(e) {
    e.preventDefault();

    var course_name = $(this).data('course-name');
    var course_id = $(this).data('course-id');
    var href = $(this).attr('href');
    var ajaxUrl = window.location.pathname;
    
      console.log(ajaxUrl);

      $.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: {
          course_id: course_id,
          course_name: course_name
        },
        success: function () {
          window.location.href = href;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
      });
      
  });
}