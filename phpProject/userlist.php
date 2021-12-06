<?php
include('header.php');
?>
<?php
session_start();

  if(!$_SESSION['id'])
  {
      header('location : test.php');
}
require('database.php');
$query= "SELECT * FROM users";
$result = mysqli_query($conn,$query);
$users = [];
while($row = mysqli_fetch_assoc($result)){
  $users[$row['id']]['id']= $row['id'];
  $users[$row['id']]['name']= $row['name'];
  $users[$row['id']]['surname'] = $row['surname'];
  $users[$row['id']]['email'] = $row['email'];
  $users[$row['id']]['gender'] = $row['gender'];
  $users[$row['id']]['role'] = $row['role'];
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
#users {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#users td, #users th {
  border: 1px solid #ddd;
  padding: 8px;
}

#users tr:nth-child(even){background-color: #f2f2f2;}

#users tr:hover {background-color: #ddd;}

#users th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
.error {
    border: 1px solid red;
}
</style>
</head>
<body>

<div style="text-align: center">

    <a href="test.php" title="logout">Log Out</a>

</div>

<h1>User list</h1>

<table id="users">
  <thead>
    <tr>
    <th>Name</th>
    <th>Surname</th>
    <th>Email</th>
    <th>Gender</th>
    <th>Role</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
   <?php foreach($users as $user){ ?>
   <tr>
         <td>
             <input type="text" id="fname_<?= $user['id']?>" name="fname" value="<?= $user['name']?>">
         </td>
         <td>
             <input type="text" id="lname_<?= $user['id']?>" name="lname" value="<?= $user['surname']?>">
         </td>
         <td>
             <input type="text" id="email_<?= $user['id']?>" name="email" value="<?= $user['email']?>">
         </td>
         <td>
             <?= $user['gender']?>
         </td>
     <td>
         <select class="form-control" name="role" id="role_<?= $user['id']?>">
             <option value="<?= $user['role']?>"><?= $user['role']?></option>
             <option value="Admin">Admin</option>
             <option value="User">User</option>
         </select>
     </td>
       <td style="white-space: nowrap">
           <button class="btn btn-primary w-50" name="update" onclick="update('<?= $user['id']?>')">Update</button>
           <button class="btn btn-primary w-50" name="erase" onclick="erase('<?= $user['id']?>')">Delete</button>
       </td>
   </tr>
   <?php } ?>
  </tbody>

  

</table>

</body>
</html>
<script>

    function isEmpty(value) {
        return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
    }

    function update(id) {
        var user_id = id;
        var fname = $("#fname_"+user_id).val();
        var lname = $("#lname_"+user_id).val();
        var email = $("#email_"+user_id).val();
        var role = $("#role_"+user_id).val();

        var data = {
            "action": "update",
            "id": user_id,
            "name": fname,
            "surname": lname,
            "email": email,
            "role": role

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
    function erase(id){
        var user_id = id;

        var data = {
            "action": "erase",
            "id": user_id

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
<?php
include('footer.php');
?>


