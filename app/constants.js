app.constant("apiConfig", {
  baseUrl: "/api/",
  endpoints: {
    admin: {
      course: "admin/course",
      professor: "admin/professor.php",
      department: "admin/department",
    },
    shared: {
      session_info: "shared/session_info",
      login: "shared/login",
    },
  },
});