<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
<?php
include('header.php');
?>
</head>
<style>
.containerform{
    margin: auto;
    width: 60%;
    border: 3px solid #0277f3;
    padding: 30px;

}
.container{
    display:flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 75vh;
}
.error {
    border: 1px solid red;
}
</style>

<body>
<div class="container">
    <div class="containerform p-2 bg-light m-auto">
        <div class="row">
            <div class="col-7 mx-auto">
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="staticEmail" placeholder="email@example.com"
                               name="email" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div style="text-align: center">
                    <button class="btn btn-primary w-50" onclick="login()">Log In</button>
                </div>
                <div style="text-align: center">
                    <a href="test.php" class="align-self-center">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<?php
include('footer.php');
?>
</html>
<script>
function isEmpty(value) {
    return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}
function login() {

    var email = $("#staticEmail").val();
    var password = $("#password").val();
    // var role = $("#role").val('Admin','User');



    if (isEmpty(email)) {
        $("#staticEmail").addClass("error");
        Swal.fire("Email cannot be empty");
        return;
    } else {
        $("#staticEmail").removeClass("error");
    }
    if (isEmpty(password)) {
        $("#password").addClass("error");
        Swal.fire("Password cannot be empty");
        return;
    } else {
        $("#password").removeClass("error");
    }
    // if(role != 'Admin' || role != 'User'){
    //     Swal.fire("Please select a role");
    //     return;
    // }

    var data = {
        "action": "login",
        "email": email,
        "password": password
        // "role" : role
    };


    $.ajax({
        url: "actions.php",
        method: 'POST',
        type: 'POST',
        data: data,
        cache: false,
        success: function(result){
            var response = JSON.parse(result);
            if (response.code == 200) {
                window.location.href = "userlist.php";
            }
            if (response.code == 201) {
                window.location.href = "userpage.php";
            }

            if (response.code == 404) {
                Swal.fire(response.message);
            }

        }
    });
}

</script>
