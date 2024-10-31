# University System Web Application

## Description
This project is a comprehensive University System Web Application programmed using HTML, CSS, JavaScript, AngularJS, and PHP. It functions as a Single Page Application (SPA), covering a majority of functionalities of a university system and dynamically updating based on the database and user controls, thanks to AngularJS and Bootstrap.
## Features
The application has three types of users: students, professors, and admins, each with their own functionalities.

### Students can:
- Enroll into courses given if they passed the prerequisites.
- View enrolled courses for the semester they select. On clicking on a course name, they can view the tasks they have to do and scores for it.
- View schedule for classes, the assessments of all courses together.
- View grades of the semester they choose only if the sum of all max scores is equal to 100.

### Professors can:
- View enrolled courses for the semester they select. On clicking on a course name, they can submit or view tasks and scores for it.
- View schedule for classes, the assessments of all courses together.
- View and add new tasks to students, setting max score, description, and timing for the online ones.
- Submit and view student scores for the tasks.

### Admins can:
- Add and view everything in the university including rooms, faculty members, students.

## Installation
1. Clone the repository to your local machine.
2. Install a local server environment like XAMPP or MAMP.
3. Move the project folder to the htdocs/www directory of your local server.
4. Start your local server and open phpMyAdmin.
5. Create a new database and import the SQL file located in the project directory.
6. Update the database configuration in the project files if necessary.
7. Open a web browser and navigate to localhost/your_project_folder to start using the application.

## Usage
1. Open a web browser and navigate to localhost/your_project_folder.
2. Register as a new user or log in if you already have an account.
3. Based on your user type (student, professor, admin), you will be redirected to your respective dashboard.
4. From the dashboard, you can access various features such as enrolling in courses, viewing schedules, adding tasks, etc.


## License
This project is licensed under the GNU General Public License v2.1.
