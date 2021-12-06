<?php
include 'database.php';
require 'database.php';

session_start();

if ($_POST['action'] == "register") {

    $txtname = mysqli_real_escape_string($conn, $_POST['fname']);
    $txtsurname = mysqli_real_escape_string($conn, $_POST['lname']);
    $txtemail = mysqli_real_escape_string($conn, $_POST['email']);
    $txtgender = mysqli_real_escape_string($conn, $_POST['gender']);
    $txtpassword = mysqli_real_escape_string($conn, $_POST['password']);
    $hash = password_hash($txtpassword, PASSWORD_DEFAULT);

    if (empty($txtname)) {
        echo json_encode(array("code" => "404", "message" => "Name cannot be empty!"));
        exit;
    }


        // check if e-mail address is well-formed
        if (!filter_var($txtemail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array("code" => "404", "message" => "Email is not correct"));
            exit;
        }


    $check_email = "SELECT * FROM users WHERE email='$txtemail'";
    $result_email = mysqli_query($conn, $check_email);

    $numRows = mysqli_num_rows($result_email);

    if ($numRows > 0) {
        echo json_encode(array("code" => "404", "message" => "This email already exist in our system!"));
        exit;
    }
    if (empty($txtsurname)) {
        echo json_encode(array("code" => "404", "message" => "Surname cannot be empty!"));
        exit;
    }
    if (empty($txtname)) {
        echo json_encode(array("code" => "404", "message" => "Name cannot be empty!"));
        exit;
    }
    if (empty($txtgender)) {
        echo json_encode(array("code" => "404", "message" => "Gender cannot be empty!"));
        exit;
    }
    if (empty($txtpassword)) {
        echo json_encode(array("code" => "404", "message" => "Password cannot be empty!"));
        exit;
    }




// database insert SQL code
    $sql = "INSERT INTO users
      SET name = '$txtname',
         surname = '$txtsurname',
         email = '$txtemail',
         gender = '$txtgender',
         password = '$hash',
         role = 'User'";


    $rs = mysqli_query($conn, $sql);

    if ($rs) {
        echo json_encode(array("code" => "200", "message" => "Success"));
        exit;
    }

} elseif($_POST['action'] == "login") {

    $txtpassword = $_POST['password'];
    $txtemail = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "SELECT * FROM users WHERE email='$txtemail'";
    $result = mysqli_query($conn, $query);
    $check = mysqli_fetch_assoc($result);



   if(password_verify($txtpassword, $check['password'])) {

       $_SESSION['id'] = $check['id'];
       $_SESSION['name'] = $check['name'];
       $sub_query = "INSERT INTO login_details 
                      SET user_id = '" . $check['id'] . "'
                      ";
       $rs = mysqli_query($conn, $sub_query);
       $last_id = mysqli_insert_id($conn);


       if ($check['role'] == "User") {
           echo json_encode(array("code" => "201", "message" => "Success"));
           exit;
       }
       if ($check['role'] == "Admin") {
           echo json_encode(array("code" => "200", "message" => "Success"));
           exit;
       }
       if (empty($txtemail)) {
           echo json_encode(array("code" => "404", "message" => "Email cannot be empty!"));
           exit;
       }
       if (empty($txtpassword)) {
           echo json_encode(array("code" => "404", "message" => "Password cannot be empty!"));
           exit;
       }
   }

} elseif($_POST['action'] == "update") {
    $id = mysqli_real_escape_string($conn,$_POST['id']);
    $fname = mysqli_real_escape_string($conn,$_POST['name']);
    $lname = mysqli_real_escape_string($conn,$_POST['surname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $role = mysqli_real_escape_string($conn,$_POST['role']);


    $sql = "UPDATE users
      SET name = '$fname',
          surname = '$lname',
          email = '$email',
          role = '$role'
         WHERE id = '$id'";



    $rs = mysqli_query($conn, $sql);

    if ($rs) {
        echo json_encode(array("code" => "200", "message" => "Success"));
        exit;
    }



} elseif($_POST['action'] == "erase") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $sql = mysqli_query($conn, "delete from users where id = '$id'"); // delete query
    $rs = mysqli_query($conn, $sql);

    if ($rs) {
        echo json_encode(array("code" => "200", "message" => "Success"));
        exit;
    }

} elseif($_POST['action'] == "userupdate") {

    $id = mysqli_real_escape_string($conn,$_POST['id']);
    $fname = mysqli_real_escape_string($conn,$_POST['name']);
    $lname = mysqli_real_escape_string($conn,$_POST['surname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);


    $sql = "UPDATE users
      SET name = '$fname',
          surname = '$lname',
          email = '$email'
         WHERE id = '$id'";

    $rs = mysqli_query($conn, $sql);

    if ($rs) {
        echo json_encode(array("code" => "200", "message" => "Success"));
        exit;
    }else{
        echo json_encode(array("code" => "404", "message" => "Error"));
        exit;
    }
}

?>