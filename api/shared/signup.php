<?php

include("../includes/db_connection.php");
include("../includes/alerts.php");

if (isset($_POST["new_admin"])) {
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $gender = $_POST["gender"];
  $birth = $_POST["bdate"];
  $city = $_POST["city"];
  $street = $_POST["street"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $insert_query = "INSERT into
    Admin (
        first_name,
        last_name,
        gender,
        birth_date,
        city,
        street,
        email, 
        password
    )
    VALUES (
        '$fname',
        '$lname',
        '$gender',
        '$birth',
        '$city',
        '$street',
        '$email', 
        '$password'
    )
    ";


  $insert = $conn->query($insert_query);



  $adminId = mysqli_insert_id($conn);


  for ($i = 0; isset($_POST["phone" . $i]); $i++) {
    $phoneNumber = $_POST["phone" . $i];

    $insert_phone_query = "INSERT INTO 
        admin_phone (
            admin_id,
            phone_number
        )
        VALUES (
            '$adminId',
            '$phoneNumber'
        )
        ";
    $insert_phone = $conn->query($insert_phone_query);
  }
  
  if ($insert) {
    header("Location: ../login/login.html");
    displayAlert("Admin Account", "Created", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
  } else {
    displayAlert("Admin Account", "Created", "error", "Failed!", "\nPlease Try Again", "Try Again");
  }
}
