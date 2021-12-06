<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <title>New Test</title>
    <?php
    include('header.php');
    ?>
</head>
<body>
<style>
    .container{
        position: relative;
        width: 100vw;
        height: 100vh;
    }
    div.a{
        text-align: center;
    }
    .b{
        margin: auto;
        width: 60%;
        border: 3px solid #0277f3;
        padding: 10px;
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%,-30%);
    }
    .mb-3 row{
        margin: auto;
        width: 60%;
        border: 3px solid #0277f3;
        padding: 10px;
    }

    .error {
        border: 1px solid red;
    }
</style>
<div class="container">
    <div class="a">
        <h2>Welcome</h2>
    </div>
    <div class="b p-2 bg-light m-auto">
        <div class="row ">
            <div class="col-6 mx-auto">
                <div class="mb-3 row">
                    <label for="fname" class="col-sm-2 col-form-label">Name </label><br>
                    <input type="text" id="fname" name="fname" required><br>
                </div>
                <div class="mb-3 row">
                    <label for="lname" class="col-sm-2 col-form-label">Surname </label><br>
                    <input type="text" id="lname" name="lname" required><br>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email </label><br>
                    <input type="text"  id="email" name="email" required><br>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">Password </label><br>
                    <input type="password" id="password" name="password" required><br>
                </div>
                <p>Input gender</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="male" required>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="female" checked required>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Female
                    </label>
                </div>

                <button class="btn btn-primary w-100" name="register" onclick="register()">Register</button>
                <br>
                <div style="text-align: center">
                    <a href="login.php" class="align-self-center">Sign in</a>
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

    function register() {
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var gender = $("#gender").val();

        if (isEmpty(fname)) {
            $("#fname").addClass("error");
            Swal.fire("Name cannot be empty");
            return;
        } else {
            $("#fname").removeClass("error");
        }

        if (isEmpty(lname)) {
            $("#lname").addClass("error");
            Swal.fire("Surname cannot be empty");
            return;
        } else {
            $("#lname").removeClass("error");
        }

        if (isEmpty(email)) {
            $("#email").addClass("error");
            Swal.fire("Email cannot be empty");
            return;
        } else {
            $("#email").removeClass("error");
        }

        if (isEmpty(password)) {
            $("#password").addClass("error");
            Swal.fire("Password cannot be empty");
            return;
        } else {
            $("#password").removeClass("error");
        }

        var data = {
            "action": "register",
            "fname": fname,
            "lname": lname,
            "email": email,
            "password": password,
            "gender": gender,


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

                if (response.code == 404) {
                    Swal.fire(response.message);
                }



            }
        });
    }

</script>