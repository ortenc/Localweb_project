<?php
include('header.php');
?>
<?php
session_start();

$user_id = $_SESSION['id'];

if(!$_SESSION['id'])
{
    header('location : test.php');
}
require('database.php');

$query= "SELECT * FROM users WHERE id= '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if(isset($_FILES["profile_photo"]["name"])){
    $target_dir = "photos/";
    $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
        $sql = "UPDATE users SET photo = '$target_file' WHERE id = '$user_id' ";
        $rs = mysqli_query($conn,$sql);
        header("Location: userpage.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>User Home Page</title>
</head>
<style>
    body {
        background: rgb(99, 39, 120)
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #BA68C8
    }

    .profile-button {
        background: rgb(99, 39, 120);
        box-shadow: none;
        border: none
    }

    .profile-button:hover {
        background: #682773
    }

    .profile-button:focus {
        background: #682773;
        box-shadow: none
    }

    .profile-button:active {
        background: #682773;
        box-shadow: none
    }

    .back:hover {
        color: #682773;
        cursor: pointer
    }

    .labels {
        font-size: 11px
    }

    .add-experience:hover {
        background: #BA68C8;
        color: #fff;
        cursor: pointer;
        border: solid 1px #BA68C8
    }
    #imageUpload
    {
        display: none;
    }

    #profileImage
    {
        cursor: pointer;
    }
    #profile-container {
        width: 150px;
        height: 150px;
        overflow: hidden;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }

    #profile-container img {
        width: 150px;
        height: 150px;
    }

</style>
<body>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <form id="fileinfo" action="userpage.php" enctype="multipart/form-data" method="post" name="fileinfo">
                <div id="profile-container">
                <img onclick="fasterPreview()" id="profileImage" src="<?= $user['photo']?>">
                </div>
                <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required="" capture>
                </form>
                <span class="font-weight-bold"><?= $user['name']?></span>
                <span class="text-black-50"><?= $user['email']?></span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="enter name" value="<?= $user['name']?>"></div>
                    <div class="col-md-12"><label class="labels">Surname</label>
                        <input type="text" name="surname" id="surname" class="form-control" placeholder="enter surname" value="<?= $user['surname']?>"></div>
                    <div class="col-md-12"><label class="labels" >Role</label>
                        <input type="text" name="role" id="role" class="form-control" value="<?= $user['role']?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Gender</label>
                        <input type="text" name="gender" id="gender" class="form-control" value="<?= $user['gender']?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="email" value="<?= $user['email']?>"></div>
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button" name="userupdate" onclick="userupdate(<?= $user['id']?>)">Update</button></div>
                <div class="mt-5 text-center"><a href="test.php" title="logout">Log Out</a></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="container rounded bg-white mt-5 mb-5">
<div class="container">
    <br />

    <div class="table-responsive">
        <h4 align="center">Online Users</h4>
        <p align="right">Hi - <?php echo $user['name'];  ?> </p>
        <div id="user_details"></div>
    </div>
</div>
</div>
</body>
<?php
include('footer.php');
?>
</html>
<script>

    $("#profileImage").click(function(e) {
        $("#imageUpload").click();
    });

    $("#imageUpload").change(function(){
        // fasterPreview( this );
        if (this){
            $('#fileinfo').submit();
        }
    });

    function userupdate(id){
        var user_id = id;
        var name = $("#name").val();
        var surname = $("#surname").val();
        var email = $("#email").val();

        var data = {
            "action": "userupdate",
            "id": user_id,
            "name": name,
            "surname": surname,
            "email": email

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
                    window.location.href = "userpage.php";
                }

                if (response.code == 404) {
                    Swal.fire(response.message);
                }



            }
        });
    }
    $(document).ready(function(){

        fetch_user();

        setInterval(function(){
            update_last_activity();
            fetch_user();
        }, 5000);

        function fetch_user()
        {
            $.ajax({
                url:"fetch_user.php",
                method:"POST",
                success:function(data){
                    $('#user_details').html(data);
                }
            })
        }

        function update_last_activity()
        {
            $.ajax({
                url:"update_last_activity.php",
                success:function()
                {

                }
            })
        }

    });
</script>


