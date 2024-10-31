function updateLinks(user) {
  document.addEventListener("DOMContentLoaded", function () {
    var base_path =
      (location.protocol === "https:" ? "https://" : "http://") +
      window.location.hostname +
      "/" +
      window.location.pathname.split("/")[1] +
      "/" +
      user;

    // Update href attributes of relevant links
    var links = document.querySelectorAll('a[href^="/"]');
    links.forEach(function (link) {
      var path = link.getAttribute("href");
      link.href = base_path + path;
    });
  });
}
